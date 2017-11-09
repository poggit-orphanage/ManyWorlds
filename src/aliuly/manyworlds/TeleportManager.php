<?php

namespace aliuly\manyworlds;

use pocketmine\event\Listener;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class TeleportManager implements Listener{
	public $owner;

	public function __construct(PluginBase $plugin){
		$this->owner = $plugin;
		$this->owner->getServer()->getPluginManager()->registerEvents($this, $this->owner);
	}

	/**
	 * @param Player       $player
	 * @param string       $level
	 * @param Vector3|null $spawn
	 *
	 * @return bool
	 */
	public function teleport($player, $level, $spawn = null){
		$world = $this->owner->getServer()->getLevelByName($level);
		if(!$world){
			$player->sendMessage("Unable to teleport to $level");
			$player->sendMessage("Level $level was not found");

			return false;
		}

		// Try to find a reasonable spawn location
		$location = $world->getSafeSpawn($spawn);
		$player->teleport($location); // Start the teleport

		return true;
	}
}
