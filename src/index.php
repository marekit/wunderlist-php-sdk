<?php

require '../vendor/autoload.php';
require '../conf/keys.php';

use Mh\Wunderlist\WunderlistClient;

$wunderlist = new WunderlistClient($clientId, $accessToken);

try {
    $lists = $wunderlist->createTask(88329763, 'Neuer Test Task');

    var_dump($lists);
}
catch(\Exception $exception) {
    var_dump($exception);
}
