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
        if (!is_dir($pico_link)) {
            symlink($pico_dir, $pico_link);
        }

        echo "Creating theme and plugin symlinks... \n";
        $theme_source = $root_dir . "/vendor/pedervl/ovase-pico-theme";
        $plugin_source = $root_dir . "/vendor/pedervl/pico_edit";
        if (!is_dir($pico_dir . "/themes/ovase-theme")) {
            symlink($theme_source, $pico_dir . "/themes/ovase-theme");
        }
        if (!is_dir($pico_dir . "/plugins/pico_edit")) {
            symlink($plugin_source, $pico_dir . "/plugins/pico_edit");
        }

        echo "Creating config symlinks... \n";
        $pico_cfg_source = $root_dir . "/config/config.php";
        $pico_edit_cfg_source = $root_dir . "/config/pico_edit/config.php";
        if (!file_exists($pico_dir . "/config/config.php")) {
            symlink($pico_cfg_source, $pico_dir . "/config/config.php");
        }
        if (!is_link($plugin_source . "/config.php")) {
            unlink($plugin_source . "/config.php");
        }
        if (!file_exists($plugin_source . "/config.php")) {
            symlink($pico_edit_cfg_source, $plugin_source . "/config.php");
        }

        echo "Creating content symlinks... \n";
        if (!is_dir($pico_dir . "/content")) {
            symlink($root_dir . "/content", $pico_dir . "/content");
        }
        if (!is_dir($pico_dir . "/assets")) {
            symlink($root_dir . "/assets", $pico_dir . "/assets");
        }
    }
}

?>
