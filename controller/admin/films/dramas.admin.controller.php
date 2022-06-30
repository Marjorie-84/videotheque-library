<?php

//CALLING MODEL 
include "../model/admin/films/films.admin.model.php";


$allFilms = allFilms($db);
// calcul pour la requête - nombre d'articles totaux, sans erreurs SQL ce sera toujours un int, de 0 à ...
$nbTotalFilms = countFilms($db);

$movies = filmsLoadFullwithCateg($db);

if(isset($_GET['admin'])&&$_GET['admin']=="?admin=films"){

    // si on a envoyé le formulaire (toutes les variables POST attendues existent)
    if(isset($_POST['nom'],$_POST['pays'],$_POST['annee'],$_POST['resume'],$_POST['cat'])){

        //exit();

        // traitement des variables
        $nom= htmlspecialchars(strip_tags(trim($_POST['nom'])),ENT_QUOTES);
        $pays= htmlspecialchars(strip_tags(trim($_POST['pays'])),ENT_QUOTES);
        $annee= (int) $_POST['annee'];
        $resume= htmlspecialchars(strip_tags(trim($_POST['resume'])),ENT_QUOTES);
        $categ= htmlspecialchars(strip_tags(trim($_POST['cat'])),ENT_QUOTES);

        // si un des champs est vide (n'a pas réussi la validation des variables POST)
        if(empty($nom)||empty($pays)||empty($annee)||empty($resume)||empty($categ)){
            $erreur = "Format des champs non valides";
        }else{
            // récupération de livres avec récupération de son id
            $recup = filmsLoadFullwithCateg($db);
            if (!$recup){
            $erreur =(mysqli_error($db));
            }
  
        }   
        
    }
}

//CALLING VIEW
include "../view/admin/films/films.admin.view.php";


