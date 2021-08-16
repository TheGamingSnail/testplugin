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
              if($data[0] == null){
                  $player->sendMessage("§4Please Type The Name OF The Player You Want To Report");
                  return true;
              }
              if($data[1] == null){
                  $player->sendMessage("§4Please Type The Reason Of The Report");
                  return true;
              }
              $player->sendMessage("Report Sent!");
              foreach($this->getServer()->getOnlinePlayers() as $p){
                  if($p->hasPermission("reportui.staff"))
                      $p->sendMessage("New Report Has Been Sent\nName: " . $data[0] . "\nReason: " . $data[1] . "\nReporter: " . $player->getName() . "\nBan?");        
              }
// Construct a discord webhook with its URL
              $webHook = new Webhook("YOUR WEBHOOK URL");

// Construct a new Message object
              $msg = new Message();

              $msg->setUsername("USERNAME");
              $msg->setAvatarURL("https://cortexpe.xyz/utils/kitsu.png");
              $msg->setContent("INSERT TEXT HERE");

// Create an embed object with #FF0000 (RED) as the embed's color and "EMBED 1" as the title
              $embed = new Embed();
              $embed->setTitle("EMBED 1");
              $embed->setColor(0xFF0000);
              $msg->addEmbed($embed);

              $embed = new Embed();
              $embed->setTitle("EMBED 2");
              $embed->setColor(0x00FF00);
              $embed->setAuthor("AUTHOR", "https://CortexPE.xyz", "https://cortexpe.xyz/utils/kitsu.png");
              $embed->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit.");
              $msg->addEmbed($embed);

              $embed = new Embed();
              $embed->setTitle("EMBED 3");
              $embed->setColor(0x0000FF);
              $embed->addField("FIELD ONE", "Some text here");
              $embed->addField("FIELD TWO", "Some text here", true);
              $embed->addField("FIELD THREE", "Some text here", true);
              $embed->setThumbnail("https://cortexpe.xyz/utils/kitsu.png");
              $embed->setImage("https://cortexpe.xyz/utils/kitsu.png");
              $embed->setFooter("Erin is kawaii UwU","https://cortexpe.xyz/utils/kitsu.png");
              $msg->addEmbed($embed);

              $webHook->send($msg);
          });
           $form->setTitle("Report A Player");
           $form->addInput("Type In A Player Name");
           $form->addInput("Type In The Reason Of The Report");
           $form->sendToPlayer($player);
           return $form;
      }

}
