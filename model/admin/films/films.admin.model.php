<?php
//récupérer tous les films
function allFilms($db){
    $query = "SELECT * FROM films";
    return mysqli_query($db, $query);
}

// insertion d'un nouveau film
function insertFilm($db,$nom,$pays,$annee,$resume){

    $query="INSERT INTO films (nom, pays, annee, resume) VALUES ('$nom', '$pays','$annee', '$resume');";
    $request = mysqli_query($db,$query) or die(mysqli_error($db));
    // si l'article est bien inséré, on renvoie son ID
    return ($request)? mysqli_insert_id($db) :false;
}
function selectsAllFilmsById($db,$id){
    $sql="SELECT * 
    FROM films F 
    WHERE F.id_films = '$id' ; ";
    $result = mysqli_query($db, $sql);
    if($result) {

        $data = mysqli_fetch_assoc($result);
        return $data;
        
    }else{
        return "La sélection a échoué: " . mysqli_error($db) . "<br>";
    }
}

Function countFilms($db){
    $query = "SELECT COUNT(id_films) AS nb_films
FROM films";
    $recup = mysqli_query($db,$query);
    $out = mysqli_fetch_assoc($recup);
    return $out["nb_films"];
}
//Récupération et affichage de tous les livres avec les catégories
function filmsLoadFullwithCateg($db){
    $query = "SELECT * 
    FROM (
    SELECT *, 
    GROUP_CONCAT(type_categorie SEPARATOR ' | ') AS cat 
    FROM films AS f
    LEFT JOIN films_has_categories AS fac ON f.id_films= fac.films_id_films
    LEFT JOIN categories c ON c.id_categorie= fac.categories_id_categorie
    GROUP BY id_films
    ) AS films_categs";
    $recup = mysqli_query($db,$query);
    // si au moins 1 résultat
    if(mysqli_num_rows($recup)){
        // on utilise le fetch all car il peut y avoir plus d'un résultat
        return mysqli_fetch_all($recup,MYSQLI_ASSOC);
    }
    // no result
    return false;
    }
    function selectsProduitById($db,$idfilm){
    
        $sql="SELECT *, 
        GROUP_CONCAT(DISTINCT type_categorie SEPARATOR '|') AS categorie
        FROM films F
        LEFT JOIN films_has_categories AS FHC ON F.id_films= FHC.films_id_films
        LEFT JOIN categories AS C ON C.id_categorie = FHC.categories_id_categorie
        WHERE id_films = $idfilm
        GROUP BY F.id_films ;";
        $result = mysqli_query($db, $sql);
        if($result) {
            $data = mysqli_fetch_assoc($result);
            return $data;
        } else {
            return false;
        }
        
    }
    // SELECT THE PRODUCT
function selectTheProduct($id, $db){
    $query = "SELECT DISTINCT p.id_product AS id_product,
                    p.name_product, p.description_product,
                    p.price_product, p.discount_product, p.discount_end_date_product, 
                    p.promoted_product, p.instock_product, p.discount_start_date_product, 
                    GROUP_CONCAT( DISTINCT img.name_img SEPARATOR 'µµ') AS name_img, 
                    GROUP_CONCAT( DISTINCT img.alt_img SEPARATOR 'µµ') AS alt_img ,
                    GROUP_CONCAT(DISTINCT category.name_category SEPARATOR 'µµ') AS name_category 
    FROM product AS p 
        JOIN product_has_img ON id_product = product_id_product_has_img 
        JOIN img ON img_id_product_has_img = id_img 
        JOIN product_has_category ON id_product = product_id_product 
        JOIN category ON category_id_category = id_category 
    WHERE p.id_product = ".$id."
    GROUP BY id_product;";
    return mysqli_query($db, $query);
}
