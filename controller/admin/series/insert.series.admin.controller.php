<?php

//CALL MODEL
include "../model/admin/series/series.admin.model.php";
include "../model/admin/categories/categories.admin.model.php";
include "../model/admin/img/img.admin.model.php";

$category = categoryLoadFull($db);


if (isset($_GET['admin']) && $_GET['admin'] == "insertSeries") {

// si on a envoyé le formulaire (toutes les variables POST attendues existent)
if (isset($_POST['nom'], $_POST['saison'], $_POST['nombre_episodes'], $_POST['pays'], $_POST['annee'],$_POST['resume'])) {
    // traitement des variables
    $nom = htmlspecialchars(strip_tags(trim($_POST['nom'])), ENT_QUOTES);
    $saison = (int) $_POST['saison'];
    $episodes = (int) $_POST['nombre_episodes'];
    $pays = htmlspecialchars(strip_tags(trim($_POST['pays'])), ENT_QUOTES);
    $annee = (int) $_POST['annee'];
    $resume = htmlspecialchars(strip_tags(trim($_POST['resume'])), ENT_QUOTES);

    // si un des champs est vide (n'a pas réussi la validation des variables POST)
    if (empty($nom) || empty($saison) || empty($episodes) || empty($pays) || empty($annee) || empty($resume)) {
        $message = "Format des champs non valides";
    } else {
        // insertion du film avec récupération de son id
        $insert = insertSeries($db, $nom, $saison, $episodes, $pays, $annee, $resume);
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
            //   
            if (!empty($_FILES['links_img'])) {
                $upload = uploadImage($_FILES['links_img'], IMG_FORMAT, IMG_MAX_SIZE, IMG_UPLOAD_ORIGINAL, IMG_UPLOAD_MEDIUM, IMG_UPLOAD_SMALL, IMG_MEDIUM_WIDTH, IMG_MEDIUM_HEIGHT, IMG_SMALL_WIDTH, IMG_SMALL_HEIGHT, IMG_JPG_MEDIUM, IMG_JPG_SMALL);

                // l'image a bien été envoyée, donc on obtient un tableau
                if (is_array($upload)) {
                    // on insert l'image (et on récupère l'id de l'image)
                    $idtheimages = insertImg($db, $_POST['name_img'], $upload[0]);
                    if ($idtheimages) series_has_imagesInsert($db, $insert, $idtheimages);
                }
            }

            //CALL VIEW
        }
    }
}
}include "../view/admin/series/insert.series.admin.view.php";
