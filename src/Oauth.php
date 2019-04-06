<?php
namespace Ardralik\API\Blizzard;

class Oauth{
	private $client;

	/**
	* @param \Ardralik\API\Blizzard\Client $client
	* @return void
	*/
	public function __construct(Client $client): void{
		$this->client = $client;
	}

	/**
	* @param string $ressource
	* @param array $data
	* @throws \Ardralik\API\Blizzard\Exception\BlizzardAPIException
	* @return string|array
	*/
	public function get(string $ressource, array $data){
		$url = $this->client->getRegionsHostLocales()[$this->client->getRegion()]["host"]["oauth"];

		switch($ressource):
			case "link":
				$data["client_id"] = $this->client->getClientId();
				$data["redirect_uri"] = $this->client->getRedirectUri();
				$data["response_type"] = "code";

				return $url ."authorize?". http_build_query($data);
				break;

			case "token":
				$data["redirect_uri"] = $this->client->getRedirectUri();
				$data["grant_type"] = "authorization_code";

				$curl = [
					CURLOPT_URL => $url ."token",
					CURLOPT_CUSTOMREQUEST => "POST",
					CURLOPT_POSTFIELDS => $data,
					CURLOPT_USERPWD => $this->client->getClientId() .":". $this->client->getClientSecret()
				];
				return json_decode($this->client->request($curl), true);

				break;

			case "user":
				$curl = [
					CURLOPT_URL => $url ."userinfo",
					CURLOPT_CUSTOMREQUEST => "GET",
					CURLOPT_HTTPHEADER => ["Authorization: Bearer ". $data["token"]]
				];
				return json_decode($this->client->request($curl), true);

				break;

			case "check_token":
				$curl = [
					CURLOPT_URL => $url ."check_token",
					CURLOPT_CUSTOMREQUEST => "POST",
					CURLOPT_POSTFIELDS => ["token" => $data["token"]]
				];
				return json_decode($this->client->request($curl), true);

				break;
		endswitch;
	}
}