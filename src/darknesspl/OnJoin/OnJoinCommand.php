<?php

namespace darknesspl\OnJoin;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use darknesspl\OnJoin\OnJoin;
use pocketmine\utils\TextFormat as TF;
use pocketmine\player\Player;

Class OnJoinCommand extends Command{

    private OnJoin $plugin;

    public function __construct(OnJoin $plugin)
    {
        $this->setPermission("onjoin.config");
        $this->plugin = $plugin;
        parent::__construct("onjoin", "/onjoin help for more information", null, ["oj"]);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): string {
        if(!$sender instanceof Player) return $sender->sendMessage(TF::RED . "This command is only available in-game");
        if(!$this->testPermissionSilent($sender)) {
			$sender->sendMessage(TF::RED . "You do not have permission to use this command");
			return;
		}
        if(!isset($args[0])) return $sender->sendMessage("§cType /onjoin help for the commands list");
        switch($args[0]){
            default:
            case "help":
                $sender->sendMessage(TF::RED . "/onjoin help > " . TF::YELLOW . "List all available commands.\n" . TF::RED . "/onjoin joinmessage <text> > " . TF::YELLOW . "set a new Join message\n" . TF::RED . "/onjoin quitmessage <text> > " . TF::YELLOW . "set a new Leaving message\n" . TF::RED . "/onjoin settype <message/tip> > " . TF::YELLOW . "Edit the type of Join/Quit Messages");
            break;
            case "joinmessage":
                array_shift($args);
                $joinmessage = implode(" ", $args);
                $this->plugin->getConfig()->set("joinMessage", $joinmessage);
                $this->plugin->getConfig()->save();
                $this->plugin->configdata["joinMessage"] = $joinmessage;
                $joinmessage = str_replace("{PLAYER}", $sender->getName(), $joinmessage);
                $sender->sendMessage(TF::GREEN . "Join Message has been changed\n" . TF::YELLOW . "Preview: " . TF::RESET . $joinmessage);
            break;
            case "quitmessage":
                array_shift($args);
                $quitmessage = implode(" ", $args);
                $this->plugin->getConfig()->set("quitMessage", $quitmessage);
                $this->plugin->getConfig()->save();
                $this->plugin->configdata["quitMessage"] = $quitmessage;
                $quitmessage = str_replace("{PLAYER}", $sender->getName(), $quitmessage);
                $sender->sendMessage(TF::GREEN . "Leaving Message has been changed\n" . TF::YELLOW . "Preview: " . TF::RESET . $quitmessage);
            break;
            case "settype":
                if($args[1] == "message" || $args[1] == "tip"){
                    $this->plugin->getConfig()->set("type", $args[1]);
                    $this->plugin->getConfig()->save();
                    $this->plugin->configdata["type"] = $args[1];
                    $sender->sendMessage(TF::GREEN . "Join/Quit Message type has been changed to " . TF::YELLOW . $args[1]);
                }else{
                    $sender->sendMessage(TF::RED . 'Invalid input, the value should be "message" or "tip".');
                }
            break;
            case "reload":
                $this->plugin->getConfig()->reload();
                $this->plugin->configdata = $this->plugin->getConfig()->getAll();
                $sender->sendMessage(TF::GREEN . "The Config data has been realoaded correctly.");
            break;
        }
    }

}
