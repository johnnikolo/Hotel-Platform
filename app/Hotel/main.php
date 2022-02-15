<?php

require_once __DIR__.'/Room.php';

// Will throw an error
// $room = new Room();

$room = new \Hotel\Floor1\Suites\Room();
var_dump(get_class($room));
