<?php

namespace darknesspl\OnJoin;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;

class OnJoin extends PluginBase implements \pocketmine\event\Listener
{
  public array $configdata = [];

  public function onEnable(): void {
    $this->getServer()->getCommandMap()->register("OnJoin", new OnJoinCommand($this));
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    $this->configdata = $this->getConfig()->getAll();
  }

  public function onDisable(): void {
    $this->getConfig()->setAll($this->configdata);
    $this->getConfig()->save();
  }
  
  public function onJoin(PlayerJoinEvent $event): void {
    if(!isset($this->configdata["type"])){
      $this->configdata["type"] = "message";
    }
    if(!isset($this->configdata["joinMessage"])){
      $this->configdata["joinMessage"] = "§8[§a+§8] §r{PLAYER}";
    }

    $playerName = $event->getPlayer()->getName();
    $joinMessage = str_replace("{PLAYER}", $playerName, $this->configdata["joinMessage"]);

    if($this->configdata["type"] === "message"){
        $event->setJoinMessage($joinMessage);
    } else {
        $event->setJoinMessage("");
        $this->getServer()->broadcastTip($joinMessage);
    }
  }

  public function onQuit(PlayerQuitEvent $event): void {
    if(!isset($this->configdata["type"])){
      $this->configdata["type"] = "message";
    }
    if(!isset($this->configdata["quitMessage"])){
      $this->configdata["quitMessage"] = "§8[§c-§8] §r{PLAYER}";
    }

    $playerName = $event->getPlayer()->getName();
    $quitMessage = str_replace("{PLAYER}", $playerName, $this->configdata["quitMessage"]);

    if($this->configdata["type"] === "message"){
        $event->setQuitMessage($quitMessage);
    } else {
        $event->setQuitMessage("");
        $this->getServer()->broadcastTip($quitMessage);
    }
  }
}
