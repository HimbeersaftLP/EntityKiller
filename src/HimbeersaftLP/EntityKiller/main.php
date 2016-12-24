<?php
namespace HimbeersaftLP\EntityKiller;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat as TF;
use pocketmine\entity\Entity;
use pocketmine\entity\Human;
use pocketmine\entity\Creature;
class main extends PluginBase implements Listener{
     
     public function onEnable(){
          $this->getServer()->getPluginManager()->registerEvents($this,$this);
          $this->getLogger()->info("EntityKiller by HimbeersaftLP enabled!");
     }
     
     public function onCommand(CommandSender $sender, Command $command, $label, array $args){
          switch($command->getName()){
               case "listentities":
                    $humans = 0;
                    $creatures = 0;
                    $unknown = 0;
                    foreach($this->getServer()->getLevels() as $level) {
                         foreach ($level->getEntities() as $e) {
                              if ($e instanceof Human)
                                   ++$humans;
                              elseif($e instanceof Creature)
                                   ++$creatures;
                              else
                                   ++$unknown;
                         }
                    }
                    $sender->sendMessage(TF::GREEN."List of all entities on your server:");
                    $sender->sendMessage(TF::GREEN."Humans: ".TF::AQUA.$humans.TF::WHITE." e.g. Players, Slappers, ...");
                    $sender->sendMessage(TF::GREEN."Creatures: ".TF::AQUA.$creatures.TF::WHITE." e.g. Mobs");
                    $sender->sendMessage(TF::GREEN."Unknown: ".TF::AQUA.$unknown.TF::WHITE." e.g. Items, Fishing-Rod-Bobbers, ...");
                    break;
               case "killall":
                    $c = 0;
                    foreach($this->getServer()->getLevels() as $level) {
                         foreach($level->getEntities() as $e) {
                              if(!$e instanceof Human){
                                   $e->close();
                                   $e->kill();
                                   $c++;
                              }
                         }
                    }
                    $sender->sendMessage("Succesfully killed ".$c." entities. Mode: All");
                    break;
               case "killcreatures":
                    $c = 0;
                    foreach($this->getServer()->getLevels() as $level) {
                         foreach($level->getEntities() as $e) {
                              if($e instanceof Creature && !$e instanceof Human){
                                   $e->close();
                                   $e->kill();
                                   $c++;
                              }
                         }
                    }
                    $sender->sendMessage("Succesfully killed ".$c." entities. Mode: Creatures");
                    break;
               case "killunknown":
                    $c = 0;
                    foreach($this->getServer()->getLevels() as $level) {
                         foreach($level->getEntities() as $e) {
                              if(!$e instanceof Human && !$e instanceof Creature && !$e instanceof DroppedItem){
                                   $e->close();
                                   $e->kill();
                                   $c++;
                              }
                         }
                    }
                    $sender->sendMessage("Succesfully killed ".$c." entities. Mode: Unknwown");
                    break;
               case "killplayers":
                    $c = 0;
                    foreach($this->getServer()->getLevels() as $level) {
                         foreach($level->getEntities() as $e) {
                              if($e instanceof Human){
                                   $e->close();
                                   $e->kill();
                                   $c++;
                              }
                         }
                    }
                    $sender->sendMessage("Succesfully killed ".$c." entities. Mode: Players");
                    break;
               case "killeverything":
                    $c = 0;
                    foreach($this->getServer()->getLevels() as $level) {
                         foreach($level->getEntities() as $e) {
                              $e->close();
                              $e->kill();
                              $c++;
                         }
                    }
                    $sender->sendMessage("Succesfully killed ".$c." entities. Mode: Everything");
                    break;
          }
          return true;
     }
}
