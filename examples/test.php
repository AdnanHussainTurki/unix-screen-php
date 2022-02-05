<?php

require "../vendor/autoload.php";

use myPHPnotes\Screen;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as Capsule;

require "../src/Screen.php";
require "../src/Models/DataStore.php";


$capsule = new Capsule;
$capsule->addConnection([
    'driver' => 'mysql',
    'host' => 'myphpnotes.com',
    'database' => 'my',
    'username' => 'ad22021998',
    'password' => 'zaq!@#45',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);
$capsule->setEventDispatcher(new Dispatcher(new Container));
$capsule->setAsGlobal();
$capsule->bootEloquent();

Capsule::schema()->create('users', function ($table) {
    $table->increments('id');
    $table->string('email')->unique();
    $table->timestamps();
});


class Process extends \Illuminate\Database\Eloquent\Model {
    protected $table = "processes";
}


// $screen = new Screen(__DIR__. DIRECTORY_SEPARATOR."datastore", new Process());
// $screen->executeFile(__DIR__. DIRECTORY_SEPARATOR."scripts".DIRECTORY_SEPARATOR. "usercreate.sh", [
//     "ossama2a2", "passwordkapasswsord"
// ]);
// $screen->executeCommand("top"); // yes young lad