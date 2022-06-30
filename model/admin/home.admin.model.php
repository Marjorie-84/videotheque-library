<?php

function hour(){
    $hourBrussels = new DateTime('now',new DateTimeZone('Europe/Brussels'));
    return $hourBrussels;
}

