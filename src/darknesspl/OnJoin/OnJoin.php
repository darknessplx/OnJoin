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
    switch($this->configdata["type"]){
      default:
      case "message":
        $playerName = $event->getPlayer()->getName();
        $joinMessage = $this->configdata["joinMessage"];
        $joinMessage = str_replace("{PLAYER}", $playerName, $joinMessage);

        $event->setJoinMessage($joinMessage);
      break;
      case "tip":
        $playerName = $event->getPlayer()->getName();
        $joinMessage = $this->configdata["joinMessage"];
        $joinMessage = str_replace("{PLAYER}", $playerName, $joinMessage);

        $event->setJoinMessage("");
        $this->getServer()->broadcastTip($joinMessage);
      break;
    }
  }
  public function onLeave(PlayerQuitEvent $event): void {
    if(!isset($this->configdata["type"])){
      $this->configdata["type"] = "message";
    }
    if(!isset($this->configdata["joinMessage"])){
      $this->configdata["quitMessage"] = "§8[§c-§8] §r{PLAYER}";
    }
    switch($this->configdata["type"]){
      default:
      case "message":
        $playerName = $event->getPlayer()->getName();
        $quitMessage = $this->configdata["quitMessage"];
        $quitMessage = str_replace("{PLAYER}", $playerName, $quitMessage);

        $event->setQuitMessage($quitMessage);
      break;
      case "tip":
        $playerName = $event->getPlayer()->getName();
        $quitMessage = $this->configdata["quitMessage"];
        $quitMessage = str_replace("{PLAYER}", $playerName, $quitMessage);

        $event->setQuitMessage("");
        $this->getServer()->broadcastTip($quitMessage);
      break;
    }
    $playerName = $event->getPlayer()->getName();
    $quitMessage = $this->getConfig()->get("quitMessage", "§8[§c-§8] §r{PLAYER}");
    $quitMessage = str_replace("{PLAYER}", $playerName, $quitMessage);

    $event->setQuitMessage($quitMessage);
    }
}
