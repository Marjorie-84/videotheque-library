<?php
//récupérer toutes les dramas
function allDramas($db){
    $query = "SELECT * FROM dramas";
    return mysqli_query($db, $query);
}
//compter le nombre de dramas vus
Function countdramas($db){
    $query = "SELECT COUNT(id_dramas) AS nb_dramas
FROM dramas";
    $recup = mysqli_query($db,$query);
    $out = mysqli_fetch_assoc($recup);
    return $out["nb_dramas"];
}
// insertion d'un nouveau drama
function insertDramas($db,$nom,$saison,$nombre_episodes,$pays,$annee,$resume){

    $query="INSERT INTO dramas (nom, saison, episodes,pays, annee, resume) VALUES ('$nom', '$saison','$nombre_episodes', '$pays', '$annee','$resume');";
    $request = mysqli_query($db,$query) or die(mysqli_error($db));
    // si l'article est bien inséré, on renvoie son ID
    return ($request)? mysqli_insert_id($db) :false;
}

 // suppression d'un drama via son id
 function deleteDrama($connect,$id){
    $id = (int) $id;
    $query = "DELETE FROM dramas WHERE id_dramas=$id";
    return(@mysqli_query($connect,$query))? true : false;
}

//charge toutes les catégories par leur id
function dramasLoadFullWithId($db,$id){
    $query = "SELECT * FROM dramas WHERE id_dramas=$id";   
    $recup = mysqli_query($db,$query);
    //si au moins un résultat
    if(mysqli_num_rows($recup)){
        
        return mysqli_fetch_assoc($recup);
    }
    //no result
    return false;
    }