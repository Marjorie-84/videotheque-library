<?php
include "../model/admin/categories/categories.admin.model.php";

// on a cliqué sur supprimer un article
if(isset($_GET['admin'])&&$_GET['admin']=="deleteCategories"){

    // si la variable d'id existe et est une chaîne de caractère ne contenant qu'un entier positif non signé
    if(isset($_GET['id_categorie'])&&ctype_digit($_GET['id_categorie'])){
        // conversion en numérique entier
        $id = (int) $_GET['id_categorie'];

        // on récupère l'article en question
        $recup = categoryLoadFullWithId($db,$id);

        // pas de récupération
        if(!$recup){
            $erreur = "catégorie introuvable";
        }else{
            $type_category = $recup["type_categorie"];
            // on clique sur confirmation de suppression
            if(isset($_GET['ok'])){
                // on tente de supprimer le magasin
                if(deleteCategory($db,$id)){
                    header("location:?admin=detailCategories");
                    //$erreur="Suppression effectuée, vous allez être rédirigé dans 5 secondes <script>setTimeout(function(){ document.location.href = './' }, 5000);</script>";
                }else{
                    $erreur="Echec de la suppression, erreur inconnue, Veuillez recommencer!";
                }
            }

        }

    }else{
        $erreur = "Format de l'id non valable";
    }
}
//CALL VIEW
include "../view/admin/categories/delete.categories.admin.view.php";