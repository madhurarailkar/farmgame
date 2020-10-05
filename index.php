<?php

require 'play.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
use Play;

$play=new Play();

$result = $play->playgame();

print_r($result);
