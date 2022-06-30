<?php

//CALL MODEL
include "../model/admin/dramas/dramas.admin.model.php";
include "../model/admin/categories/categories.admin.model.php";
//include "../model/admin/img/img.admin.model.php";


$category = categoryLoadFull($db);


if (isset($_GET['admin']) && $_GET['admin'] == "insertDramas") {

    // si on a envoyé le formulaire (toutes les variables POST attendues existent)
    if (isset($_POST['nom'], $_POST['saison'], $_POST['episodes'], $_POST['pays'], $_POST['annee'], $_POST['resume'])) {
        // traitement des variables
        $nom = htmlspecialchars(strip_tags(trim($_POST['nom'])), ENT_QUOTES);
        $saison = (int) $_POST['saison'];
        $episodes = (int) $_POST['episodes'];
        $pays = htmlspecialchars(strip_tags(trim($_POST['pays'])), ENT_QUOTES);
        $annee = (int) $_POST['annee'];
        $resume = htmlspecialchars(strip_tags(trim($_POST['resume'])), ENT_QUOTES);

        // si un des champs est vide (n'a pas réussi la validation des variables POST)
        if (empty($nom) || empty($saison) || empty($episodes) || empty($pays) || empty($annee) || empty($resume)) {
            $message = "Format des champs non valides";
        } else {
            // insertion du film avec récupération de son id
            $insert = insertDramas($db, $nom, $saison, $episodes, $pays, $annee, $resume);
            // insertion réussie (un id et pas false)
            if ($insert) {

                if (isset($_POST['cat'])) {
                    foreach ($_POST['cat'] as $item) {
                        $idcateg = (int) $item;
                        linkCategoryFilms($db, $idcateg, $insert);
                    }
                }
                if (!$insert) {
                    $erreur = (mysqli_error($db));
                }
                
            }
            if (!$insert) {
                $erreur = (mysqli_error($db));
            } else {
              
            }
        }
    }
} 
 //CALL VIEW
include "../view/admin/dramas/insert.dramas.admin.view.php";
