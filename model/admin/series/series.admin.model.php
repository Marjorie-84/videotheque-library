<?php
//récupérer toutes les séries
function allSeries($db){
    $query = "SELECT * FROM series";
    return mysqli_query($db, $query);
}

//Comptage de toutes les séries
Function countSeries($db){
    $query = "SELECT COUNT(id_Series) AS nb_series
FROM series";
    $recup = mysqli_query($db,$query);
    $out = mysqli_fetch_assoc($recup);
    return $out["nb_series"];
}

// insertion d'un nouveau film
function insertSeries($db,$nom,$saison,$nombre_episodes,$pays,$annee,$resume){

    $query="INSERT INTO series (nom, saison, nombre_episodes,pays, annee, resume) VALUES ('$nom', '$saison','$nombre_episodes', '$pays', '$annee','$resume');";
    $request = mysqli_query($db,$query) or die(mysqli_error($db));
    // si l'article est bien inséré, on renvoie son ID
    return ($request)? mysqli_insert_id($db) :false;
}