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
			$data["name"] = urlencode(strtolower($data["name"]));
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

			case "gameData":
				switch($data["data"]):
					case "achievementCategory":
						$url = "data/wow/achievement-category/". ($data["id"] ?? "index") ."?". http_build_query($params);
						$curl[CURLOPT_HTTPHEADER] = ["Battlenet-Namespace: static-". $this->client->getRegion()];
						break;

					case "achievement":
						$url = "data/wow/achievement/". ($data["id"] ?? "index") ."?". http_build_query($params);
						$curl[CURLOPT_HTTPHEADER] = ["Battlenet-Namespace: static-". $this->client->getRegion()];
						break;

					case "achievementMedia":
						$url = "data/wow/media/achievement/". $data["id"] ."?". http_build_query($params);
						$curl[CURLOPT_HTTPHEADER] = ["Battlenet-Namespace: static-". $this->client->getRegion()];
						break;

					case "connectedRealm":
						$url = "data/wow/connected-realm/". ($data["id"] ?? "index") ."?". http_build_query($params);
						$curl[CURLOPT_HTTPHEADER] = ["Battlenet-Namespace: dynamic-". $this->client->getRegion()];
						break;

					case "creatureFamily":
						$url = "data/wow/creature-family/". ($data["id"] ?? "index") ."?". http_build_query($params);
						$curl[CURLOPT_HTTPHEADER] = ["Battlenet-Namespace: static-". $this->client->getRegion()];
						break;

					case "creatureType":
						$url = "data/wow/creature-family/". ($data["id"] ?? "index") ."?". http_build_query($params);
						$curl[CURLOPT_HTTPHEADER] = ["Battlenet-Namespace: static-". $this->client->getRegion()];
						break;

					case "creature":
						$url = "data/wow/creature-family/". $data["id"] ."?". http_build_query($params);
						$curl[CURLOPT_HTTPHEADER] = ["Battlenet-Namespace: static-". $this->client->getRegion()];
						break;

					case "creatureDisplayMedia":
						$url = "data/wow/media/creature-display/". $data["id"] ."?". http_build_query($params);
						$curl[CURLOPT_HTTPHEADER] = ["Battlenet-Namespace: static-". $this->client->getRegion()];
						break;

					case "creatureFamilyMedia":
						$url = "data/wow/media/creature-family/". $data["id"] ."?". http_build_query($params);
						$curl[CURLOPT_HTTPHEADER] = ["Battlenet-Namespace: static-". $this->client->getRegion()];
						break;

					case "guild":
						$url = "data/wow/guild/". $this->formatRealm($data["realm"]) ."/". $data["name"] ."?". http_build_query($params);
						$curl[CURLOPT_HTTPHEADER] = ["Battlenet-Namespace: profile-". $this->client->getRegion()];
						break;

					case "guildAchievements":
						$url = "data/wow/guild/". $this->formatRealm($data["realm"]) ."/". $data["name"] ."/achivements?". http_build_query($params);
						$curl[CURLOPT_HTTPHEADER] = ["Battlenet-Namespace: profile-". $this->client->getRegion()];
						break;

					case "guildRoster":
						$url = "data/wow/guild/". $this->formatRealm($data["realm"]) ."/". $data["name"] ."/roster?". http_build_query($params);
						$curl[CURLOPT_HTTPHEADER] = ["Battlenet-Namespace: profile-". $this->client->getRegion()];
						break;

					case "guildCrest":
						$url = "data/wow/guild-crest/index?". http_build_query($params);
						$curl[CURLOPT_HTTPHEADER] = ["Battlenet-Namespace: static-". $this->client->getRegion()];
						break;

					case "guildCrestBorder":
						$url = "data/wow/media/guild-crest/border/". $data["id"] ."?". http_build_query($params);
						$curl[CURLOPT_HTTPHEADER] = ["Battlenet-Namespace: static-". $this->client->getRegion()];
						break;

					case "guildCrestEmblem":
						$url = "data/wow/media/guild-crest/emblem/". $data["id"] ."?". http_build_query($params);
						$curl[CURLOPT_HTTPHEADER] = ["Battlenet-Namespace: static-". $this->client->getRegion()];
						break;

					case "mythicAffix":
						$url = "data/wow/keystone-affix/". ($data["id"] ?? "index") ."?". http_build_query($params);
						$curl[CURLOPT_HTTPHEADER] = ["Battlenet-Namespace: static-". $this->client->getRegion()];
						break;

					case "mythicRaid":
						$url = "data/wow/leaderboard/hall-of-fame/". $data["raid"] ."/". $data["faction"] ."/?". http_build_query($params);
						$curl[CURLOPT_HTTPHEADER] = ["Battlenet-Namespace: dynamic-". $this->client->getRegion()];
						break;

					case "mythicKeystone":
						$url = "data/wow/mythic-keystone/index/?". http_build_query($params);
						$curl[CURLOPT_HTTPHEADER] = ["Battlenet-Namespace: dynamic-". $this->client->getRegion()];
						break;

					case "mythicKeystoneDungeon":
						$url = "data/wow/mythic-keystone/dungeon/". ($data["id"] ?? "index") ."?". http_build_query($params);
						$curl[CURLOPT_HTTPHEADER] = ["Battlenet-Namespace: dynamic-". $this->client->getRegion()];
						break;

					case "mythicKeystonePeriod":
						$url = "data/wow/mythic-keystone/period/". ($data["id"] ?? "index") ."?". http_build_query($params);
						$curl[CURLOPT_HTTPHEADER] = ["Battlenet-Namespace: dynamic-". $this->client->getRegion()];
						break;

					case "mythicKeystoneSeason":
						$url = "data/wow/mythic-keystone/period/". ($data["id"] ?? "index") ."?". http_build_query($params);
						$curl[CURLOPT_HTTPHEADER] = ["Battlenet-Namespace: dynamic-". $this->client->getRegion()];
						break;

					case "mythicLeaderboard":
						if(isset($data["dungeon"])):
							$url = "data/wow/connected-realm/". $data["id"] ."/mythic-leaderboard/". $data["dungeon"] ."/period/". $data["period"] ."?". http_build_query($params);
						else:
							$url = "data/wow/connected-realm/". $data["id"] ."/mythic-leaderboard/index?". http_build_query($params);
						endif;
						$curl[CURLOPT_HTTPHEADER] = ["Battlenet-Namespace: dynamic-". $this->client->getRegion()];
						break;

					case "pet":
						$url = "data/wow/pet/". ($data["id"] ?? "index") ."?". http_build_query($params);
						$curl[CURLOPT_HTTPHEADER] = ["Battlenet-Namespace: static-". $this->client->getRegion()];
						break;

					case "class":
						$url = "data/wow/playable-class/". ($data["id"] ?? "index") ."?". http_build_query($params);
						$curl[CURLOPT_HTTPHEADER] = ["Battlenet-Namespace: static-". $this->client->getRegion()];
						break;

					case "classPvP":
						$url = "data/wow/playable-class/". $data["id"] ."/pvp-talent-slots?". http_build_query($params);
						$curl[CURLOPT_HTTPHEADER] = ["Battlenet-Namespace: static-". $this->client->getRegion()];
						break;

					case "specialization":
						$url = "data/wow/playable-specialization/". ($data["id"] ?? "index") ."?". http_build_query($params);
						$curl[CURLOPT_HTTPHEADER] = ["Battlenet-Namespace: static-". $this->client->getRegion()];
						break;

					case "powerType":
						$url = "data/wow/power-type/". ($data["id"] ?? "index") ."?". http_build_query($params);
						$curl[CURLOPT_HTTPHEADER] = ["Battlenet-Namespace: static-". $this->client->getRegion()];
						break;

					case "PvPSeason":
						$url = "data/wow/pvp-season/". ($data["id"] ?? "index") ."?". http_build_query($params);
						$curl[CURLOPT_HTTPHEADER] = ["Battlenet-Namespace: dynamic-". $this->client->getRegion()];
						break;

					case "PvPLeaderboard":
						$url = "data/wow/pvp-season/". $data["id"] ."/pvp-leaderboard/". ($data["bracket"] ?? "index") ."?". http_build_query($params);
						$curl[CURLOPT_HTTPHEADER] = ["Battlenet-Namespace: dynamic-". $this->client->getRegion()];
						break;

					case "PvPRewards":
						$url = "data/wow/pvp-season/". $data["id"] ."/pvp-reward/index?". http_build_query($params);
						$curl[CURLOPT_HTTPHEADER] = ["Battlenet-Namespace: dynamic-". $this->client->getRegion()];
						break;

					case "PvPTier":
						$url = "data/wow/pvp-tier/". ($data["id"] ?? "index") ."?". http_build_query($params);
						$curl[CURLOPT_HTTPHEADER] = ["Battlenet-Namespace: static-". $this->client->getRegion()];
						break;

					case "PvPTierMedia":
						$url = "data/wow/media/pvp-tier/". ($data["id"] ?? "index") ."?". http_build_query($params);
						$curl[CURLOPT_HTTPHEADER] = ["Battlenet-Namespace: static-". $this->client->getRegion()];
						break;

					case "realms":
						$url = "data/wow/realm/". (isset($data["slug"]) ? $this->formatRealm($data["slug"]) : "index") ."?". http_build_query($params);
						$curl[CURLOPT_HTTPHEADER] = ["Battlenet-Namespace: dynamic-". $this->client->getRegion()];
						break;

					case "region":
						$url = "data/wow/region/". ($data["id"] ?? "index") ."?". http_build_query($params);
						$curl[CURLOPT_HTTPHEADER] = ["Battlenet-Namespace: dynamic-". $this->client->getRegion()];
						break;

					case "token":
						$url = "data/wow/token/index?". http_build_query($params);
						$curl[CURLOPT_HTTPHEADER] = ["Battlenet-Namespace: dynamic-". $this->client->getRegion()];
						break;
				endswitch;
		endswitch;

		$curl[CURLOPT_URL] = $this->client->getRegionsHostLocales()[$this->client->getRegion()]["host"]["api"] . $url;
		$curl[CURLOPT_CUSTOMREQUEST] = "GET";
		if(!array_key_exists(CURLOPT_HTTPHEADER, $curl)):
			$curl[CURLOPT_HTTPHEADER] = ["Authorization: Bearer ". $this->client->getToken()];
		else:
			$curl[CURLOPT_HTTPHEADER] = array_merge($curl[CURLOPT_HTTPHEADER], ["Authorization: Bearer ". $this->client->getToken()]);
		endif;
		
		return $this->client->request($curl);
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