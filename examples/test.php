<?php

use myPHPnotes\Screen;
require "../vendor/autoload.php";
require "../src/Screen.php";
require "../src/Models/DataStore.php";

$screen = new Screen(__DIR__. DIRECTORY_SEPARATOR."datastore");
$screen->executeFile(__DIR__. DIRECTORY_SEPARATOR."scripts".DIRECTORY_SEPARATOR. "usercreate.sh", [
    "ossama2a2", "passwordkapasswsord"
]);
$screen->executeCommand("top");