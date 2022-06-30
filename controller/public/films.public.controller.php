<?php

//CALLING MODEL 
include "../model/public/films.public.model.php";

$allFilms = allFilms($db);

//CALLING VIEW
include "../view/public/films.public.view.php";
