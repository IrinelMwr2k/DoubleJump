<?php

namespace MWR;

use pocketmine\event\player\PlayerToggleFlightEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\TextFormat;

class DoubleJump extends PluginBase implements Listener {
	
	public function onEnable() {
		
		if($this->getDescription()->getAuthors()[0] !== "IrinelMwr" or $this->getDescription()->getName() !== "DoubleJump"){
			
			$this->getLogger()->info("Fatal error! Unallowed use of DoubleJump!");
			$this->getServer()->shutdown();
			
		} else {
			
			$this->getServer()->getPluginManager()->registerEvents($this, $this);
			$this->getLogger()->info(TextFormat::GREEN . "§7DoubleJump - §aON§7!");
		}
	}
	
	public function onDisable() {
		
		$this->getLogger()->info("§7DoubleJump - §cOFF§7!");
		
		if($this->getDescription()->getAuthors()[0] !== "IrinelMwr" or $this->getDescription()->getName() !== "DoubleJump"){
			$this->getLogger()->info("Fatal error! Unallowed use of Double Jump!");
			$this->getServer()->shutdown();
		}
	}
	
	public function onJoin(PlayerJoinEvent $event) {
		
		$player = $event->getPlayer();
		
		if($player->hasPermission("mwr.doublejump")) {
			$player->setAllowFlight(true);
		}
	}
	
	public function setFlyOnJump(PlayerToggleFlightEvent $event) {
		$player = $event->getPlayer();
		if($player->getLevel()->getFolderName() == $this->getServer()->getDefaultLevel()->getFolderName()) {
			if($event->isFlying() && $player->hasPermission("mwr.doublejump")) {
				$player->setFlying(false);
				$jump = $player->getLocation()->multiply(0, 0.001, 0);
				$jump->y = 1.1;
				$player->setMotion($jump);
				$event->setCancelled(true);
			}
		}
	}
}
