# Blizzard-API

## Installation
First, you need to install the library. For this, use Composer:
`composer require ardralik/blizzard-api`

## Getting started
First, you need to init the `Client` which is used by all Blizzard APIs:
```php
// I assume you have included Composer autoloader

$client = new \Ardralik\API\Blizzard\Client("clientId", "clientSecret", "returnUri");
```

Parameter | Type | Description
--------- | ---- | -----------
`clientId` | `string` | Your Blizzard App public key
`clientSecret` | `string` | Your Blizzard App secret key
`returnUri` | `string` | The value you have set in your Blizzard App settings

## *World of Warcraft* API
First, init the `WoW` class. It uses the `Client` object previously created:
```php
$wow = new \Ardralik\API\Blizzard\WoW($client);
```

Then, call the `get` method:
```php
$wow->get("ressource", "data");
```

Parameter | Type | Description
--------- | ---- | -----------
`ressource` | `string` | The ressource you want to retrieve
`data` | `array` | Params required by the ressource

Here is `data` structure depending on `ressource`:
<table>
	<tr>
		<th>Ressource</th>
		<th>'data' keys (type)</th>
		<th>Details</th>
	</tr>
	<tr>
		<td>
			achievement
		</td>
		<td>
			id (int)
		</td>
		<td></td>
	</tr>
	<tr>
		<td>
			auction
		</td>
		<td>
			realm (string)
		</td>
		<td></td>
	</tr>
	<tr>
		<td>
			boss
		</td>
		<td>
			id (int)
		</td>
		<td>
			Can be blank to get all bosses. 'data' is not required in this case.
		</td>
	</tr>
	<tr>
		<td>
			challenge
		</td>
		<td>
			realm (string)
		</td>
		<td>
			Can be blank to get all realms of the region. 'data' is not required in this case.
		</td>
	</tr>
	<tr>
		<td rowspan="3">
			character
		</td>
		<td>
			realm (string)</li>
		</td>
		<td></td>
	</tr>
	<tr>
		<td>
			name (string)</li>
		</td>
		<td></td>
	</tr>
	<tr>
		<td>
			fields (array)</li>
		</td>
		<td>
			Example: <pre>["achievements", "mounts"]</pre> Not required to get basic info.
		</td>
	</tr>
	<tr>
		<td rowspan="3">
			guild
		</td>
		<td>
			realm (string)</li>
		</td>
		<td></td>
	</tr>
	<tr>
		<td>
			name (string)</li>
		</td>
		<td></td>
	</tr>
	<tr>
		<td>
			fields (array)</li>
		</td>
		<td>
			Example: <pre>["members"]</pre> Not required to get basic info.
		</td>
	</tr>
	<tr>
		<td>
			item
		</td>
		<td>
			id (int)
		</td>
		<td></td>
	</tr>
	<tr>
		<td>
			item_set
		</td>
		<td>
			id (int)
		</td>
		<td></td>
	</tr>
	<tr>
		<td>
			mount
		</td>
		<td>
			*None*
		</td>
		<td></td>
	</tr>
	<tr>
		<td rowspan="2">
			pet
		</td>
		<td>
			details (string)
		</td>
		<td>
			'data' is not required to get a list of all pets.<br />
			<br />
			If used, available values are:
			<ul>
				<li>ability</li>
				<li>species</li>
				<li>stats</li>
			</ul>
		</td>
	</tr>
	<tr>
		<td>
			id (int)
		</td>
		<td>
			Required only if 'type' key used.
		</td>
	</tr>
	<tr>
		<td>
			pvp
		</td>
		<td>
			format (string)
		</td>
		<td>
			Available values:
			<ul>
				<li>2v2</li>
				<li>3v3</li>
				<li>5v5</li>
				<li>rbg</li>
			</ul>
		</td>
	</tr>
	<tr>
		<td>
			quest
		</td>
		<td>
			id (int)
		</td>
		<td></td>
	</tr>
	<tr>
		<td>
			realm
		</td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td>
			recipe
		</td>
		<td>
			id (int)
		</td>
		<td></td>
	</tr>
	<tr>
		<td>
			spell
		</td>
		<td>
			id (int)
		</td>
		<td></td>
	</tr>
	<tr>
		<td>
			zone
		</td>
		<td>
			id (int)
		</td>
		<td>
			Can be blank for all zones. 'data' not required in this case.
		</td>
	</tr>
	<tr>
		<td>
			data
		</td>
		<td>
			type (string)
		</td>
		<td>
			Available values:
			<ul>
				<li>battlegroups</li>
				<li>races</li>
				<li>classes</li>
				<li>achievements</li>
				<li>guild_rewards</li>
				<li>guild_perks</li>
				<li>guild_achievements</li>
				<li>item_classes</li>
				<li>talents</li>
				<li>pet_types</li>
		</td>
	</tr>
	<tr>
		<td>
			gameData
		</td>
		<td>
			data (string)
		</td>
		<td>
			Available balues :
			<ul>
				<li>achievementCategory</li>
				<li>achievement</li>
				<li>achievementMedia</li>
				<li>connectedRealm</li>
				<li>creatureFamily</li>
				<li>creatureType</li>
				<li>creature</li>
				<li>creatureDisplayMedia</li>
				<li>creatureFamilyMedia</li>
				<li>guild</li>
				<li>guildAchievements</li>
				<li>guildRoster</li>
				<li>guildCrest</li>
				<li>guildCrestBorder</li>
				<li>guildCrestEmblem</li>
				<li>mythicAffix</li>
				<li>mythicRaid</li>
				<li>mythicKeystone</li>
				<li>mythicKeystoneDungeon</li>
				<li>mythicKeystonePeriod</li>
				<li>mythicKeystoneSeason</li>
				<li>mythicLeaderboard</li>
				<li>pet</li>
				<li>class</li>
				<li>classPvP</li>
				<li>specialization</li>
				<li>powerType</li>
				<li>PvPSeason</li>
				<li>PvPLeaderboard</li>
				<li>PvPRewards</li>
				<li>PvPTier</li>
				<li>PvPTierMedia</li>
				<li>realms</li>
				<li>region</li>
				<li>token</li>
			</ul>
		</td>
	</tr>
</table>

Additional values when using `gameData`:
<table>
	<tr>
		<th>'data' keys</th>
		<th>Value</th>
		<th>Optional/Required</th>
	</tr>
	<tr>
		<td>achievementCategory</td>
		<td>id (int)</td>
		<td>Optional</td>
	</tr>
	<tr>
		<td>achievement</td>
		<td>id (int)</td>
		<td>Optional</td>
	</tr>
	<tr>
		<td>achievementMedia</td>
		<td>id (int)</td>
		<td>Required</td>
	</tr>
	<tr>
		<td>connectedRealm</td>
		<td>id (int)</td>
		<td>Optional</td>
	</tr>
	<tr>
		<td>creatureFamily</td>
		<td>id (int)</td>
		<td>Optional</td>
	</tr>
	<tr>
		<td>creatureType</td>
		<td>id (int)</td>
		<td>Optional</td>
	</tr>
	<tr>
		<td>creature</td>
		<td>id (int)</td>
		<td>Required</td>
	</tr>
	<tr>
		<td>creatureDisplayMedia</td>
		<td>id (int)</td>
		<td>Required</td>
	</tr>
	<tr>
		<td>creatureFamilyMedia</td>
		<td>id (int)</td>
		<td>Required</td>
	</tr>
	<tr>
		<td rowspan="2">guild</td>
		<td>realm (string)</td>
		<td>Required</td>
	</tr>
	<tr>
		<td>name (string)</td>
		<td>Required</td>
	</tr>
	<tr>
		<td rowspan="2">guildAchievements</td>
		<td>realm (string)</td>
		<td>Required</td>
	</tr>
	<tr>
		<td>name (string)</td>
		<td>Required</td>
	</tr>
	<tr>
		<td rowspan="2">guildRoster</td>
		<td>realm (string)</td>
		<td>Required</td>
	</tr>
	<tr>
		<td>name (string)</td>
		<td>Required</td>
	</tr>
	<tr>
		<td>guildCrestBorder</td>
		<td>id (int)</td>
		<td>Required</td>
	</tr>
	<tr>
		<td>guildCrestEmblem</td>
		<td>id (int)</td>
		<td>Required</td>
	</tr>
	<tr>
		<td>mythicAffix</td>
		<td>id (int)</td>
		<td>Optional</td>
	</tr>
	<tr>
		<td rowspan="2">mythicRaid</td>
		<td>raid (string)</td>
		<td>Required</td>
	</tr>
	<tr>
		<td>faction (string)</td>
		<td>Required</td>
	</tr>
	<tr>
		<td>mythicKeystoneDungeon</td>
		<td>id (int)</td>
		<td>Optional</td>
	</tr>
	<tr>
		<td>mythicKeystonePeriod</td>
		<td>id (int)</td>
		<td>Optional</td>
	</tr>
	<tr>
		<td>mythicKeystoneSeason</td>
		<td>id (int)</td>
		<td>Optional</td>
	</tr>
	<tr>
		<td rowspan="3">mythicLeaderboard</td>
		<td>id (int)</td>
		<td>Required (connected-realm ID)</td>
	</tr>
	<tr>
		<td>dungeon (int)</td>
		<td>Optional</td>
	</tr>
	<tr>
		<td>period (int)</td>
		<td>Required (only if 'dungeon' is used)</td>
	</tr>
	<tr>
		<td>pet</td>
		<td>id (int)</td>
		<td>Optional</td>
	</tr>
	<tr>
		<td>class</td>
		<td>id (int)</td>
		<td>Optional</td>
	</tr>
	<tr>
		<td>classPvP</td>
		<td>id (int)</td>
		<td>Required</td>
	</tr>
	<tr>
		<td>specialization</td>
		<td>id (int)</td>
		<td>Optional</td>
	</tr>
	<tr>
		<td>powerType</td>
		<td>id (int)</td>
		<td>Optional</td>
	</tr>
	<tr>
		<td>PvPSeason</td>
		<td>id (int)</td>
		<td>Optional</td>
	</tr>
	<tr>
		<td rowspan="2">PvPLeaderboard</td>
		<td>id (int)</td>
		<td>Required</td>
	</tr>
	<tr>
		<td>bracket (string)</td>
		<td>Optional</td>
	</tr>
	<tr>
		<td>PvPRewards</td>
		<td>id (int)</td>
		<td>Required</td>
	</tr>
	<tr>
		<td>PvPTier</td>
		<td>id (int)</td>
		<td>Optional</td>
	</tr>
	<tr>
		<td>PvPTierMedia</td>
		<td>id (int)</td>
		<td>Optional</td>
	</tr>
	<tr>
		<td>realms</td>
		<td>slug (string)</td>
		<td>Optional</td>
	</tr>
	<tr>
		<td>region</td>
		<td>id (int)</td>
		<td>Optional</td>
	</tr>
</table>

## *Diablo III* API
First, init the `Diablo` class. It uses the `Client` object previously created:
```php
$diablo = new \Ardralik\API\Blizzard\Diablo($client);
```

Then, call the `get` method:
```php
$wow->diablo("ressource", "data");
```

Parameter | Type | Description
--------- | ---- | -----------
`ressource` | `string` | The ressource you want to retrieve
`data` | `array` | Params required by the ressource

Here is `data` structure depending on `ressource`:
<table>
	<tr>
		<th>Ressource</th>
		<th>'data' keys (type)</th>
		<th>Details</th>
	</tr>
	<tr>
		<td>
			act
		</td>
		<td>
			id (int)
		</td>
		<td>
			Not required. 'data' not required in this case.
		</td>
	</tr>
	<tr>
		<td rowspan="2">
			artisan_recipe
		</td>
		<td>
			artisan (string)
		</td>
		<td></td>
	</tr>
	<tr>
		<td>
			recipe (string)
		</td>
		<td>
			<em>Optional</em>
		</td>
	</tr>
	<tr>
		<td>
			follower
		</td>
		<td>
			slug (string)
		</td>
		<td></td>
	</tr>
	<tr>
		<td rowspan="2">
			class_skill
		</td>
		<td>
			hero (string)
		</td>
		<td></td>
	</tr>
	<tr>
		<td>
			skill (string)
		</td>
		<td>
			Not required. 'data' not required in this case.
		</td>
	</tr>
	<tr>
		<td>
			item_type
		</td>
		<td>
			type (string)
		</td>
		<td>
			Not required. 'data' not required in this case.
		</td>
	</tr>
	<tr>
		<td>
			item
		</td>
		<td>
			slug (string)
		</td>
		<td></td>
	</tr>
	<tr>
		<td rowspan="3">
			profile
		</td>
		<td>
			battleTag (string)
		</td>
		<td></td>
	</tr>
	<tr>
		<td>
			hero (int)
		</td>
		<td>
			ID of the hero
		</td>
	</tr>
	<tr>
		<td>
			field (string)
		</td>
		<td>
			Available values:
			<ul>
				<li>items</li>
				<li>follower-items</li>
			</ul>
		</td>
	</tr>
</table>

## Oauth API
First, init the `Oauth` class. It uses the `Client` object previously created:
```php
$oauth = new \Ardralik\API\Blizzard\Oauth($client);
```

Then, call the `get` method:
```php
$wow->oauth("ressource", "data");
```

Parameter | Type | Description
--------- | ---- | -----------
`ressource` | `string` | The ressource you want to retrieve
`data` | `array` | Params required by the ressource

Here is `data` structure depending on `ressource`:
<table>
	<tr>
		<th>Ressource</th>
		<th>'data' keys (type)</th>
		<th>Details</th>
	</tr>
	<tr>
		<td rowspan="2">
			link
		</td>
		<td>
			scope (string)
		</td>
		<td>
			Available values:
			<ul>
				<li>wow.profile</li>
				<li>sc2.profile</li>
			</ul>
		</td>
	</tr>
	<tr>
		<td>
			state (string)
		</td>
		<td></td>
	</tr>
	<tr>
		<td rowspan="2">
			token
		</td>
		<td>
			scope (string)
		</td>
		<td>
			The same used previously via 'link'
		</td>
	</tr>
	<tr>
		<td>
			code (string)
		</td>
		<td></td>
	</tr>
	<tr>
		<td>
			characters
		</td>
		<td>
			token (string)
		</td>
		<td></td>
	</tr>
	<tr>
		<td>
			check_token
		</td>
		<td>
			token (string)
		</td>
		<td></td>
	</tr>
</table>