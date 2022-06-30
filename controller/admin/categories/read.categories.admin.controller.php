<?php
include "../model/admin/categories/categories.admin.model.php";

$category = categoryLoadFull($db);


if(isset($_GET['admin'])&&$_GET['admin']=="detailCategories"){

    // si on a envoyé le formulaire (toutes les variables POST attendues existent)
    if(isset($_POST['id_categorie'],$_POST['type_categorie'])){

        ///var_dump($_POST);
        //exit();

        // traitement des variables
        $idcategory= htmlspecialchars(strip_tags(trim($_POST['id_categorie'])),ENT_QUOTES);
        $typecategory= htmlspecialchars(strip_tags(trim($_POST['type_categorie'])),ENT_QUOTES);
     
        // si un des champs est vide (n'a pas réussi la validation des variables POST)
        if(empty($idcategory)||empty($typecategory)){
            $erreur = "Format des champs non valides";
        }else{
            // récupération de magasin avec récupération de son id
            $recup = categoryLoadFull($db,$id);
            if (!$recup){
            $erreur =(mysqli_error($db));
            }
  
        }   
        
    }
}
//CALL VIEW
include "../view/admin/categories/categories.admin.view.php";