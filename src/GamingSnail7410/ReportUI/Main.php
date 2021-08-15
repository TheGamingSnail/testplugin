<?php

namespace GamingSnail7410\ReportUI;

use pocketmine\Server;
use pocketmine\Player;

use pocketmine\plugin\PluginBase;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use CortexPE\DiscordWebhookAPI\Webhook;
use CortexPE\DiscordWebhookAPI\Embed;
use CortexPE\DiscordWebhookAPI\Message;

class Main extends PluginBase {

   public function onCommand(CommandSender $sender, Command $cmd, String $label, Array $args) : bool {
       switch($cmd->getName()){
           case "report":
            if($sender instanceof Player){
               $this->reportUI($sender);
            } else {
               $sender->sendMessage("you must be in game to run this command NERDDDDD");
            }
           break;
       }
   return true;
   }
   
   public function reportUI($player){
       $form =  $this->getServer()->getPluginManager()->getPlugin("FormAPI")->createCustomForm(function (Player $player, array $data = null){
              if($data === null){
                  return true;
              }
              $webhook = new Webhook("https://discord.com/api/webhooks/876598099429187584/wkKXKbe2io90sGUYpdIPZebpec9qvWfpCm16XAUWXJWeYvp3bwtOl8cNRbnCaWEf1_lW");
              $msg = new Message();
              $embed = new Embed();
              $embed->setTitle("New Player Reported");
              $embed->addField("Name:", $data[0]);
              $embed->addField("Reason:", $data[1]);
              $embed->addField("Reporter:", $player->getName());
              $embed->setFooter("Hmmmmm");
              $msg->addEmbed($embed);
              $webhook->send($msg);
            });
            $form->setTitle("Report A Player");
            $form->addInput("Type In A Player Name");
            $form->addInput("Type In The Reason Of The Report");
            $form->sendToPlayer($player);
            return $form;
          }

}