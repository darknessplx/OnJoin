<?php

namespace darknesspl\Onjoin;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;

class OnJoin extends PluginBase implements \pocketmine\event\Listener
{

public function onEnable(): void {
    $this->getConfig()->save();
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
}
public function onDisable(): void {
  $this->getConfig()->save();
}
public function onJoin(PlayerJoinEvent $event): void {
$player = $event->getPlayer();
$playerName = $player->getName();
$joinMessage = $this->getConfig()->get("joinMessage", "§8[§a+§8] §r{PLAYER}");
$joinMessage = str_replace("{PLAYER}", $playerName, $joinMessage);

$event->setJoinMessage($joinMessage);
}
public function onLeave(PlayerQuitEvent $event): void {
$player = $event->getPlayer();
$playerName = $event->getPlayer()->getName();
$quitMessage = $this->getConfig()->get("quitMessage", "§8[§c-§8] §r{PLAYER}");
$quitMessage = str_replace("{PLAYER}", $playerName, $quitMessage);

$event->setQuitMessage($quitMessage);
    }
}
