<?php

session_start();

$service = $_GET['service'];
switch ($service) {
    case 'track': include 'icl/track.inc.php'; track(); break;
}

