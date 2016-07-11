<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 2/23/14
 * Time: 4:03 PM
 */

class FixtureDirectoriesComponent extends Object {

    private function check_directory($transdir)
    {
        if (!file_exists($transdir)) {
            echo " made directory ".$transdir."\n";
            mkdir($transdir);
        }
    }
}