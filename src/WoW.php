<?php
namespace Ardralik\API\Blizzard;

class WoW{
	private $client;
	
	/**
	* @param \Ardralik\API\Blizzard\Client $client
	*/
	public function __construct(Client $client){
		$this->client = $client;
	}

	/**
	* @param string $ressource
	* @param array $data
	* @throws \Ardralik\API\Blizzard\Exception\BlizzardAPIException
	* @return string
	*/
	public function get(string $ressource, array $data = []): string{
		$params = [];

		if(array_key_exists("fields", $data)):
			$params["fields"] = implode(",", $data["fields"]);
		endif;

		if(array_key_exists("name", $data)):
			$data["name"] = urlencode($data["name"]);
		endif;

		$params["locale"] = $this->client->getLocale();

		switch($ressource):
			case "achievement":
				$url = "wow/achievement/". $data["id"] ."?". http_build_query($params);
				break;

			case "auction":
				$url = "wow/auction/data/". $this->formatRealm($data["realm"]) ."?". http_build_query($params);
				break;

			case "boss":
				$url = "wow/boss/". ($data["id"] ?? "") ."?". http_build_query($params);
				break;

			case "challenge":
				$url = "wow/challenge/". ($data["realm"] ? $this->formatRealm($data["realm"]) : "region") ."?". http_build_query($params);
				break;

			case "character":
				$url = "wow/character/". $this->formatRealm($data["realm"]) ."/". strtolower($data["name"]) ."?". http_build_query($params);
				break;

			case "guild":
				$url = "wow/guild/". $this->formatRealm($data["realm"]) ."/". strtolower($data["name"]) ."?". http_build_query($params);
				break;

			case "item":
				$url = "wow/item/". $data["id"];
				break;

			case "item_set":
				$url = "wow/item/set/". $data["id"];
				break;

			case "mount":
				$url = "wow/mount/";
				break;

			case "pet":
				$url = "wow/pet/";

				if(array_key_exists("details", $data)):
					switch($data["details"]):
						case "ability":
							$url .= "ability/". $data["id"];
							break;

						case "species":
							$url .= "species/". $data["id"];
							break;

						case "stats":
							$url .= "stats/". $data["id"];
							break;
					endswitch;
				endif;

				break;

			case "pvp":
				$url = "wow/leaderboard/". $data["format"];
				break;

			case "quest":
				$url = "wow/quest/". $data["id"];
				break;

			case "realm":
				$url = "wow/realm/status";
				break;

			case "recipe":
				$url = "wow/recipe/". $data["id"];
				break;

			case "spell":
				$url = "wow/spell/". $data["id"];
				break;

			case "zone":
				$url = "wow/zone/". ($data["id"] ?? "");
				break;

			case "data":
				switch($data["type"]):
					case "battlegroups":
						$endpoint = "battlegroups/";
						break;

					case "races":
						$endpoint = "character/races";
						break;

					case "classes":
						$endpoint = "character/classes";
						break;

					case "achievements":
						$endpoint = "character/achievements";
						break;

					case "guild_rewards":
						$endpoint = "guild/rewards";
						break;

					case "guild_perks":
						$endpoint = "guild/perks";
						break;

					case "guild_achievements":
						$endpoint = "guild/achievements";
						break;

					case "item_classes":
						$endpoint = "item/classes";
						break;

					case "talents":
						$endpoint = "talents";
						break;

					case "pet_types":
						$endpoint = "pet/types";
						break;
				endswitch;

				$url = "wow/data/". $endpoint ."?". http_build_query($params);
				break;

			case "characters":
				$curl = [
					CURLOPT_URL => "wow/user/characters",
					CURLOPT_CUSTOMREQUEST => "GET",
					CURLOPT_HTTPHEADER => ["Authorization: Bearer ". $this->client->getToken()],
				];
				return $this->client->request($curl);

				break;
		endswitch;
		
		$data = [
			CURLOPT_URL => $this->client->getRegionsHostLocales()[$this->client->getRegion()]["host"]["api"] . $url,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => ["Authorization: Bearer ". $this->client->getToken()]
		];
		
		return $this->client->request($data);
	}

	/**
	* @param string $realm
	* @return string
	*/
	private function formatRealm(string $realm): string{
		$realm = strtolower($realm);
		$realm = str_replace("-", "", $realm);
		$realm = str_replace(" ", "-", $realm);
		$realm = str_replace("(", "", $realm);
		$realm = str_replace(")", "", $realm);
		$realm = str_replace("ê", "e", $realm);
		$realm = str_replace("'", "", $realm);
		$realm = str_replace("à", "a", $realm);
		return $realm;
	}
}