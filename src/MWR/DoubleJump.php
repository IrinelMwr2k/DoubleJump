<?php

namespace MWR;

use pocketmine\event\player\PlayerToggleFlightEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\Player;


class DoubleJump extends PluginBase implements Listener {
	
	public function onEnable() {
		
		if($this->getDescription()->getAuthors()[0] !== "IrinelMwr" or $this->getDescription()->getName() !== "DoubleJump-MWR"){
			
			$this->getLogger()->info("§cFatal error! §8(§d@IrinelMwr2k§8)§c!");
			$this->getServer()->shutdown();
			
		} else {
			
			$this->getServer()->getPluginManager()->registerEvents($this, $this);
			$this->getLogger()->info("§7DoubleJump - §aON§7!");
		}
	}
	
	public function onDisable() {
		
		$this->getLogger()->info("§7DoubleJump - §cOFF§7!");
		
		if($this->getDescription()->getAuthors()[0] !== "IrinelMwr" or $this->getDescription()->getName() !== "DoubleJump-MWR"){
			$this->getLogger()->info("§cFatal error! §8(§d@IrinelMwr2k§8)§7!");
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
