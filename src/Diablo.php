<?php
namespace Ardralik\API\Blizzard;

class Diablo{
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
		$params["locale"] = $this->client->getLocale();

		switch($ressource):
			case "act":
				$url = "d3/data/act". ($data["id"] ?? "") ."?". http_build_query($params);
				break;

			case "artisan_recipe":
				$recipe = isset($data["recipe"]) ? "/recipe/". $data["recipe"] : "";
				$url = "d3/data/artisan/". $data["artisan"] . $recipe ."?". http_build_query($params);
				break;

			case "follower":
				$url = "d3/data/follower/". $data["slug"] ."?". http_build_query($params);
				break;

			case "class_skill":
				$skill = isset($data["skill"]) ? "/skill/". $data["skill"] : "";
				$url = "d3/data/hero/". $data["hero"] . $skill ."?". http_build_query($params);
				break;

			case "item_type":
				$url = "d3/data/item-type/". ($data["type"] ?? "") ."?". http_build_query($params);
				break;

			case "item":
				$url = "d3/data/item/". $data["slug"] ."?". http_build_query($params);
				break;

			case "profile":
				$url = "d3/profile/". str_replace("#", "-", $data["battleTag"]) ."/";
				$url .= isset($data["hero"]) ? "hero/". $data["hero"] : "";
				$url .= isset($data["field"]) ? "/". $data["field"] : "";
				$url .= "?". http_build_query($params);
				break;
		endswitch;

		$data = [
			CURLOPT_URL => $this->client->getRegionsHostLocales()[$this->client->getRegion()]["host"]["api"] . $url,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => [
				"Authorization: Bearer ". $this->client->getToken()
			]
		];
		
		return $this->client->request($data);
	}
}