<?php

function track(){

    global $songs;
    global $announcer;

    $rand = rand(0,100);

    if(false and ( (!isset($_SESSION['lastplayed'])) or (($rand > 80) and ($_SESSION['lastplayed'] != 'announcer')))) {
        if(!isset($announcer) or count($announcer) <= 0)
        {
            $announcer = scandir(__DIR__.'/../audio/announcer');
            $announcer = array_slice($announcer, 2);
            shuffle($announcer);
        }

        $audio = 'announcer/'.array_shift($announcer);
        $_SESSION['lastplayed'] = 'announcer';
    }

    else {
        if(!isset($songs) or count($songs) <= 0)
        {
            $songs = scandir(__DIR__.'/../audio');
            $songs = array_slice($songs, 2);
            shuffle($songs);
        }

        $audio = array_shift($songs);
        $_SESSION['lastplayed'] = 'track';
    }


    ?>

    <!--<?=$rand?> <?=$_SESSION['lastplayed']?>-->
    <source src="audio/<?=$audio?>" type="audio/mpeg">

    <?php
}?>

