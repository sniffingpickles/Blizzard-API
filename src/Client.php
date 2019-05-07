<?php
namespace Ardralik\API\Blizzard;

use \Ardralik\API\Blizzard\Exception\BlizzardAPIException;

class Client{
	private $clientId = "";
	private $clientSecret = "";
	private $redirectUri = "";
	private $token = "";
	private $region = "eu";
	private $locale = "en_GB";
	private $regionsHostLocales = [
		"us" => [
			"host" => [
				"api" => "https://us.api.blizzard.com/",
				"oauth" => "https://us.battle.net/oauth/"
			],
			"locales" => ["en_US", "es_MX", "pt_BR"]
		],
		"eu" => [
			"host" => [
				"api" => "https://eu.api.blizzard.com/",
				"oauth" => "https://eu.battle.net/oauth/"
			],
			"locales" => ["en_GB", "es_ES", "fr_FR", "ru_RU", "de_DE", "pt_PT", "it_IT"]
		],
		"kr" => [
			"host" => [
				"api" => "https://kr.api.blizzard.com/",
				"oauth" => "https://apac.battle.net/oauth/"
			],
			"locales" => ["ko_KR"]
		],
		"tw" => [
			"host" => [
				"api" => "https://tw.api.blizzard.com/",
				"oauth" => "https://apac.battle.net/oauth/"
			],
			"locales" => ["zh_TW"]
		],
		"cn" => [
			"host" => [
				"api" => "https://gateway.battlenet.com.cn/",
				"oauth" => "https://www.battlenet.com.cn/oauth/"
			],
			"locales" => ["zh_CN"]
		]
	];

	/**
	* @param string $clientId
	* @param string $clientSecret
	* @param string $redirectUri
	*/
	public function __construct(string $clientId, string $clientSecret, string $redirectUri){
		$this->clientId = $clientId;
		$this->clientSecret = $clientSecret;
		$this->redirectUri = $redirectUri;
	}

	/**
	* @param string $clientId
	* @return void
	*/
	public function setClientId(string $clientId): void{
		$this->clientId = $clientId;
	}

	/**
	* @return string
	*/
	public function getClientId(): string{
		return $this->clientId;
	}

	/**
	* @param string $clientSecret
	* @return void
	*/
	public function setClientSecret(string $clientSecret): void{
		$this->clientSecret = $clientSecret;
	}

	/**
	* @return string
	*/
	public function getClientSecret(): string{
		return $this->clientSecret;
	}

	/**
	* @param string $redirectUri
	* @return void
	*/
	public function setRedirectUri(string $redirectUri): void{
		$this->redirectUri = $redirectUri;
	}

	/**
	* @return string
	*/
	public function getRedirectUri(): string{
		return $this->redirectUri;
	}

	/**
	* @param string $region
	* @throws \Ardralik\API\Blizzard\Exception\BlizzardAPIException
	* @return void
	*/
	public function setRegion(string $region): void{
		if(array_key_exists($region, $this->regionsHostLocales)):
			$this->region = $region;
		else:
			throw new BlizzardAPIException("Incorrect value for 'region' parameter. Must be one of these values: ". implode(", ", array_keys($this->regionsHostLocales)));
		endif;
	}

	/**
	* @return string
	*/
	public function getRegion(): string{
		return $this->region;
	}

	/**
	* @param string $locale
	* @throws \Ardralik\API\Blizzard\Exception\BlizzardAPIException
	* @return void
	*/
	public function setLocale(string $locale): void{
		if(in_array($locale, $this->regionsHostLocales[$this->region]["locales"])):
			$this->locale = $locale;
		else:
			throw new BlizzardAPIException("Incorrect value for 'locale' parameter. Must be one of these values: ". implode(", ", $this->regionsHostLocales[$this->region]["locales"]));
		endif;
	}

	/**
	* @return string
	*/
	public function getLocale(): string{
		return $this->locale;
	}

	/**
	* @return array
	*/
	public function getRegionsHostLocales(): array{
		return $this->regionsHostLocales;
	}

	/**
	* @return string
	*/
	public function getToken(): string{
		if(empty($this->token)):
			$this->setToken();
		else:
			$data = [
				CURLOPT_URL => $this->regionsHostLocales[$this->region]["host"]["oauth"] ."check_token",
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_USERPWD => $this->clientId .":". $this->clientSecret,
				CURLOPT_POSTFIELDS => [
					"token" => $this->token
				]
			];

			$result = json_decode($this->request($data), true);

			if(null === $result || $result["exp"] < time()):
				$this->setToken();
			endif;
		endif;

		return $this->token;
	}

	/**
	* @return void
	*/
	private function setToken(): void{
		$data = [
			CURLOPT_URL => $this->regionsHostLocales[$this->region]["host"]["oauth"] ."token",
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_USERPWD => $this->clientId .":". $this->clientSecret,
			CURLOPT_POSTFIELDS => [
				"redirect_uri" => $this->redirectUri,
				"grant_type" => "client_credentials"
			]
		];

		$result = json_decode($this->request($data), true);
		$this->token = $result["access_token"];
	}

	/**
	* @param array $data
	* @throws \Ardralik\API\Blizzard\Exception\BlizzardAPIException
	* @return string
	*/
	public function request(array $data): string{
		$data[CURLOPT_CAINFO] = __DIR__ . DIRECTORY_SEPARATOR ."blizzard.cer";
		$data[CURLOPT_RETURNTRANSFER] = true;
		$data[CURLOPT_TIMEOUT] = 5;

		$curl = curl_init();
		curl_setopt_array($curl, $data);
		$result = curl_exec($curl);

		if(false === $result || curl_getinfo($curl, CURLINFO_HTTP_CODE) !== 200):
			curl_close($curl);
			$result = json_decode($result);
			if(property_exists($result, "status")):
				if($result->status === "nok"):
					throw new BlizzardAPIException($result->reason ?? "An error has occured when retrieving data.");
				endif;
			endif;
		endif;
		
		curl_close($curl);

		return $result;
	}
}