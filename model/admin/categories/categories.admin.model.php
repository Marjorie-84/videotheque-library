<?php

// insertion d'une nouvelle catégorie
function InsertCategory($categ,$type_category){
    $query = "INSERT INTO categories (type_categorie) VALUES ('$type_category');";
    $request = mysqli_query($categ,$query);
    return($request)?true :false;
    }

    //charge toutes les catégories
function categoryLoadFull($connect){
    $query = "SELECT * FROM categories";
    $recup = mysqli_query($connect,$query);
    // si au moins 1 résultat
    if(mysqli_num_rows($recup)){
        // on utilise le fetch all car il peut y avoir plus d'un résultat
        return mysqli_fetch_all($recup,MYSQLI_ASSOC);
    }
    // no result
    return false;
    }

    //charge toutes les catégories par leur id
function categoryLoadFullWithId($db,$id){
    $query = "SELECT * FROM categories WHERE id_categorie=$id";   
    $recup = mysqli_query($db,$query);
    //si au moins un résultat
    if(mysqli_num_rows($recup)){
        
        return mysqli_fetch_assoc($recup);
    }
    //no result
    return false;
    }

    function updateCategory($db,$type_category,$id){
        $id = (int) $id;
    $query ="UPDATE categories SET type_categorie = '$type_category' WHERE id_categorie = $id";
    
    return (@mysqli_query($db,$query))? true : "Erreur inconnue lors de la modification, Veuillez recommencer";
    
    }

    // suppression d'une categorie via son ID
function deleteCategory($connect,$id){
    $id = (int) $id;
    $query = "DELETE FROM categories WHERE id_categorie=$id";
    return(@mysqli_query($connect,$query))? true : false;
}
// insertion du lien d'une catégorie avec films
function linkCategoryFilms($db,$idcateg,$idfilms){
    $query = "INSERT INTO films_has_categories VALUES ($idfilms,$idcateg);";
    $request = mysqli_query($db,$query);
    return($request)?true :false;
    }