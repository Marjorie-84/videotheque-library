<?php

//CALLING MODEL 
include "../model/admin/films/films.admin.model.php";


if(isset($_GET['id_films'])&&ctype_digit($_GET['id_films'])){
    $idfilm= (int) $_GET['id_films'];
    $detailFilms= selectsProduitById($db,$idfilm);

}
//CALLING VIEW
include "../view/admin/films/details.films.admin.view.php";

