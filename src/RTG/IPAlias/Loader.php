<?php

/* 
 * 
 *  _____ _______ _____ _____         _____          _           
 * |  __ \__   __/ ____|  __ \       / ____|        | |          
 * | |__) | | | | |  __| |  | | __ _| |     ___   __| | ___ _ __ 
 * |  _  /  | | | | |_ | |  | |/ _` | |    / _ \ / _` |/ _ \ '__|
 * | | \ \  | | | |__| | |__| | (_| | |___| (_) | (_| |  __/ |   
 * |_|  \_\ |_|  \_____|_____/ \__,_|\_____\___/ \__,_|\___|_|   
 *                                                                
 *                                                                
 * Copyright (C) 2017 Your Name <RTG>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * 
 */

namespace RTG\IPAlias;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;

class Loader extends PluginBase implements Listener {
    
    public $cfg;
    
    public function onEnable() {
        
        // Make Folders
        @mkdir($this->getDataFolder());
        @mkdir($this->getDataFolder() . "players");
        // !>
        
        // Config
        $this->cfg = new \pocketmine\utils\Config($this->getDataFolder() . "config.yml", \pocketmine\utils\Config::YAML, array(
            "tracing" => false
        ));
        
        
    }
    
    public function onJoin(\pocketmine\event\player\PlayerJoinEvent $e) {
        
        $this->onIPAdd($e->getPlayer()->getName(), $e->getPlayer()->getAddress());
        
    }
    
    public function onIPAdd($name, $ip) {
        
        if ($this->cfg->get("tracing") === true) {
            
            if (!is_dir($this->getDataFolder() . "players/"  . $name . ".yml")) {
                
                $file = new \pocketmine\utils\Config($this->getDataFolder() . "players/" . $name . ".yml", \pocketmine\utils\Config::YAML, array("ips" => array()));
                
                $get = $file->get("ips");
                
                if (in_array($ip, $get)) {
                    
                    $this->getLogger()->warning($e->getPlayer()->gatName() . " joined with an existing IP!");
                    
                } else {
                    
                    array_push($get, $ip);
                    
                    $file->set("ips", $get);
                    $file->save();
                    
                    $this->getLogger()->warning($e->getPlayer()->getName() . " joined with a new IP!");
                    
                }
                
            }
               
        } else {
            
            
            $file = new \pocketmine\utils\Config($this->getDataFolder() . "players/" . $name . ".yml", \pocketmine\utils\Config::YAML, array("ips" => array()));
                
            $get = $file->get("ips");
                
            if (in_array($ip, $get)) {
                    
                $this->getLogger()->warning($e->getPlayer()->gatName() . " joined with an existing IP!");
                    
            } else {
                    
                array_push($get, $ip);
                    
                $file->set("ips", $get);
                $file->save();
                    
                $this->getLogger()->warning($e->getPlayer()->getName() . " joined with a new IP!");
                
            }
            
        }
        
    }
    
    
}