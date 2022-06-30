<?php
include "../model/admin/dramas/dramas.admin.model.php";
include "../model/admin/categories/categories.admin.model.php";


// on a cliqué sur supprimer un article
if(isset($_GET['admin'])&&$_GET['admin']=="deleteDramas"){

    // si la variable d'id existe et est une chaîne de caractère ne contenant qu'un entier positif non signé
    if(isset($_GET['id_dramas'])&&ctype_digit($_GET['id_dramas'])){
        // conversion en numérique entier
        $id = (int) $_GET['id_dramas'];

        // on récupère l'article en question
        $recup = dramasLoadFullWithId($db,$id);

        // pas de récupération
        if(!$recup){
            $erreur = "drama introuvable";
        }else{
            $drama = $recup["nom"];
            // on clique sur confirmation de suppression
            if(isset($_GET['ok'])){
                // on tente de supprimer le magasin
                if(deleteDrama($db,$id)){
                    header("location:?admin=dramas");
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
include "../view/admin/dramas/delete.dramas.admin.view.php";