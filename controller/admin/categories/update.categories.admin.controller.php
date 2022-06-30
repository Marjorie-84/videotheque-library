<?php
include "../model/admin/categories/categories.admin.model.php";

if(isset($_GET['id_categorie'])&& ctype_digit($_GET['id_categorie'])){
    //conversion en numérique entier
    $id = (int) $_GET['id_categorie'];
    //si le formulaire est envoyé
    if (!empty($_POST["type_categorie"])) {
        $update = updateCategory($db,$_POST["type_categorie"],$id);

        //si l'update a eu lieu
        if($update===true){
            header("Location:?admin=detailCategories");
            exit;
        }
    }
    $datas = categoryLoadFullWithId($db,$id);
    
}

include "../view/admin/categories/update.categories.admin.view.php";
