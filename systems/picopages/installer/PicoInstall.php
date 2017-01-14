<?php

namespace Ovase;

use Composer\Script\Event;
use Composer\Installer\PackageEvent;

/*
 * TODO:
 * Give message that admin is needed
 * Handle symlink already created
 * Copy config file
 * Maybe take config parameters preInstall
 */

class PicoInstaller
{
    public static function postInstall(Event $event)
    {
        $composer = $event->getComposer();
        
        $root_dir = __DIR__ . "/..";

        echo "Creating pico symlink to '/www'... \n";
        $pico_dir = $root_dir . "/vendor/picocms/pico";
        $pico_link = $root_dir . "/www";
        symlink($pico_source, $pico_link);

        echo "Creating theme and plugin symlinks... \n";
        $theme_source = $root_dir . "/vendor/pedervl/ovase-pico-theme";
        $plugin_source = $root_dir . "/vendor/pedervl/pico_edit";
        symlink($theme_source, $pico_dir . "/themes/ovase-theme");
        symlink($plugin_source, $pico_dir . "/plugins/pico_edit");

        echo "Creating config symlinks... \n";
        $pico_cfg_source = $root_dir . "/config/config.php";
        $pico_edit_cfg_source = $root_dir . "/config/pico_edit/config.php";
        symlink($pico_cfg_source, $pico_dir . "/config.php");
        symlink($pico_edit_cfg_source, $plugin_source . "/config.php". 

        echo "Creating content symlinks... \n";
        symlink($root_dir . "/content", $pico_dir . "/content")
        symlink($root_dir . "/assets", $pico_dir . "/assets")
    }
}

?>