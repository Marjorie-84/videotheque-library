<?php
//CALL MODEL
include "../model/admin/categories/categories.admin.model.php";

if(isset($_GET['admin'])&&$_GET['admin']=="insertCategories"){

    // si on a envoyé le formulaire (toutes les variables POST attendues existent)
    if(isset($_POST['type_categorie'])){

        ///var_dump($_POST);
        //exit();

        // traitement des variables
        $type_category= htmlspecialchars(strip_tags(trim($_POST['type_categorie'])),ENT_QUOTES);
    


        // si un des champs est vide (n'a pas réussi la validation des variables POST)
        if(empty($type_category)){
            $erreur = "tous les champs ne sont pas remplis";
        }else{
            // insertion de catégorie avec récupération de son id
            $insert = insertCategory($db,$type_category);
            if (!$insert){
            $erreur =(mysqli_error($db));
            }
            else{
                //header("Location: ?p=readCategory.Admin");
                false;
                
            }
        }   
        
    }
}
//CALL VIEW
include "../view/admin/categories/insert.categories.admin.view.php";