<?php

function track(){

    global $songs;

        if(!isset($songs) or count($songs) <= 0)
        {
            $songs = scandir(__DIR__.'/../audio');
            $songs = array_slice($songs, 2);
            shuffle($songs);
        }

        $audio = array_shift($songs);
        $_SESSION['lastplayed'] = 'track';

    ?>

    <source src="audio/<?=$audio?>" type="audio/mpeg">

    <?php
}?>

