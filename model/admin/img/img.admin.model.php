<?php

//cree une image
function insertImg($db,$name_img,$links_img){
    $sql= "INSERT INTO img (name_img,links_img) VALUES('$name_img','" .$links_img ."');";
    $result = mysqli_query($db, $sql);
	return $result ? "L'insertion a réussi<br>" : "L'insertion a échoué: " . mysqli_error($db) . "<br>";
}

function films_has_imagesInsert($db,$idfilms,$idimg){
    $idfilms=(int)$idfilms;
    $idimg=(int)$idimg;
    if(!empty($idfilms)&&!empty($idimg)){

       $sql = "INSERT INTO films_has_img(films_id_films, img_id_img) VALUES ($idfilms,$idimg);";

       $req = mysqli_query($db,$sql) or die(mysqli_error($db));
       return($sql)? true : false;        
    }else{
        return false;
    }
}
function series_has_imagesInsert($db,$idfilms,$idimg){
    $idfilms=(int)$idfilms;
    $idimg=(int)$idimg;
    if(!empty($idfilms)&&!empty($idimg)){

       $sql = "INSERT INTO series_has_img(series_id_series, img_id_img) VALUES ($idfilms,$idimg);";

       $req = mysqli_query($db,$sql) or die(mysqli_error($db));
       return($sql)? true : false;        
    }else{
        return false;
    }
}

//function upload
function uploadImage(array $fileName,$validExt,$maxSize,$fileNameOrig,$fileNameMed,$fileNameSmall,$widhtMed=600,$heightMed=400,$widhtSmall=100,$heightSmall=100,$qualiteMed=90,$qualiteSmall=80){
    // taille maximum en kilo octet
    $maxSize = 50000;
    $validExt =  array('.jpg','.jpeg','.gif','.png','.gif','.JPG','.JPEG','.PNG','.GIF'); 
    $fileName = $_FILES['links_img'];
    //vaut zero
    if(($fileName['error'] == 0)){
        
        //on prend l'extension
        $extend = imageValidExt($fileName['name'],$validExt);
        //si extension valid
        if($extend){
            //on prend la taille
            $taille = imageVerifSize($fileName['size'],$maxSize);
            if($taille){
                //on reupere largeur et hauteur
                $imageInfo = getimagesize($fileName['tmp_name']);
                //largeur en pixel de l'image d'origine
                $imageWidth = $imageInfo[0];
                //hauteur en pixel de l'image d'origine
                $imageHeight = $imageInfo[1];
                //creation du nouveau nom de fichier
                $nouveauNomFichier = imageNewNom($extend);
                // là ou le nom est stocker temporairement
                $tmpName = $_FILES['links_img']['tmp_name'];
                //on cree un nom et un id unique avec la methode md5 et rand pour avoir un resultat aleatoire
                $fileNameComplet = $fileNameOrig . $nouveauNomFichier ;
                $result = move_uploaded_file($tmpName,$fileNameComplet);
                //on essaye d'envoier physiquement l'image
                if($result){
                    //transformation de l'image vers medium en gardant les proportions
                    imageMakeResize($nouveauNomFichier,$imageWidth,$imageHeight,$extend,$fileNameOrig,$fileNameMed,$widhtMed,$heightMed,$qualiteMed);
                    //transformation de l'image vers Small en gardant les proportions
                    imageMakeThumbs($nouveauNomFichier,$imageWidth,$imageHeight,$extend,$fileNameOrig,$fileNameSmall,$widhtSmall,$heightSmall,$qualiteSmall);
                     //si on a un deplacement de fichier 
                     // envoi le tableau avec le nom sous forme de tableau
                        return [$nouveauNomFichier,];
                    } else {
                        return "Erreur inconnue lors du transfert";
                } 
                    } else {
                        return "Fichier trop lourd! $taille sur " . $maxSize . " autorisée!";
            } 
                }else {
                    return "Extension non valide";
        } 
            }else {
                return "Erreur inconnue lors du transfert";
    }
                
                
            
                
}
    




/*function convertImage($source,$dst,$widht,$height,$qualite){
    //cette valeur sera retourner en tableau
    // indice [0]=> width, indice [1]=> height
    $imageSize = getimagesize($source);
    $imageRessource = imagecreatefromjpeg($source);
    $imageFinal = imagecreatetruecolor($width,$height);
    $final = imagecopyresampled($imageFinal,$imageRessource, 0, 0, 0, 0, $widht,$heigt,$imageSize[0],$imageSize[1]);
    $imagejpeg($imageFinal,$dst,$qualite);{
        
    }
}
*/
function imageValidExt($nomOrig,$format){
    // on stock le nom  de l'image dans une variable
    $fileName = $_FILES['links_img']['name'];
    //renvoie une partie d'une chaîne(substr),on recupere l extension avec le dernie "." (strrchr), on met les majuscule en miniscule(strtolower),
    $fileExt = "." . strtolower(substr(strrchr($fileName, '.'),1));
    //on verifie si l extension est valide
    if(in_array($fileExt,$format)){
        return $fileExt;
    }else{
        return false;
    }
}

function imageVerifSize($taille,$maxSize) {
    if($taille > $maxSize){
        return false;
    }else{
        return $taille;
    }
}

function imageNewNom($extend) {
    $uniqueName = md5(uniqId(rand(),true));
    return  $uniqueName . $extend;
}


// redimensionne l'image en gardant les proportions
function imageMakeResize($name, $largeurOri, $hauteurOri, $extension, $origin, $medium,  $largeurMax=800, $hauteurMax=600, $qualityJpg=90) {

    // si la largeur d'origine est plus petite que la largeur maximum et idem hauteur origine/hauteur maximum
    if ($largeurOri < $largeurMax && $hauteurOri < $hauteurMax) {
        $largeurFinal = $largeurOri;
        $hauteurFinal = $hauteurOri;
    } else {
        // si l'image est en paysage
        if ($largeurOri > $hauteurOri) {
            // pour obtenir le ratio (proportion)
            $proportion = $largeurMax / $largeurOri;
            // l'image est en mode portrait ou un carré
        } else {
            // pour obtenir le ratio (proportion)
            $proportion = $hauteurMax / $hauteurOri;
        }
        // mise en proportion de la largeur et hauteur finales
        $largeurFinal = round($largeurOri * $proportion);// arrondit le nombre
        $hauteurFinal = round($hauteurOri * $proportion);
    }
    //var_dump($largeurFinal,$hauteurFinal);
    // création du fichier vierge aux tailles finales
    $newImg = imagecreatetruecolor($largeurFinal, $hauteurFinal);

    // on va copier l'image originale suivant son extension
    if ($extension == ".jpg" || $extension == ".jpeg") {
        // en jpg
        $copie = imagecreatefromjpeg($origin . $name);
        // on adapte l'image au bon format, puis on colle
        imagecopyresampled($newImg, $copie, 0, 0, 0, 0, $largeurFinal, $hauteurFinal, $largeurOri, $hauteurOri);
        // on finalise le fichier jpg
        imagejpeg($newImg, $medium . $name, $qualityJpg);
    } elseif ($extension == ".png") {
        // en png
        $copie = imagecreatefrompng($origin . $name);
        // on adapte l'image au bon format, puis on colle
        imagecopyresampled($newImg, $copie, 0, 0, 0, 0, $largeurFinal, $hauteurFinal, $largeurOri, $hauteurOri);
        // on finalise le fichier png
        imagepng($newImg, $medium . $name);
    } else {
        // en gif
        $copie = imagecreatefromgif($origin . $name);
        // on adapte l'image au bon format, puis on colle
        imagecopyresampled($newImg, $copie, 0, 0, 0, 0, $largeurFinal, $hauteurFinal, $largeurOri, $hauteurOri);
        // on finalise le fichier png
        imagegif($newImg, $medium . $name);
    }
}
// redimensionne l'image en coupant pour obtenir une miniature centrée
function imageMakeThumbs($name, $largeurOri, $hauteurOri, $extension, $origin, $thumb,  $largeurMax=80, $hauteurMax=80, $qualiteJpg=80) {
    // création du fichier vierge aux tailles finales
    $newImg = imagecreatetruecolor($largeurMax, $hauteurMax);

    // calcul pour garder les proportions
    $thumb_width = $largeurMax;
    $thumb_height = $hauteurMax;

    $width = $largeurOri;
    $height = $hauteurOri;

    $original_aspect = $width / $height;
    $thumb_aspect = $thumb_width / $thumb_height;

    // divisions pour trouver le point de départ en X ou en Y pour couper l'image au milieu, que ça soit en hauteur (paysage) ou en largeur (portrait)
    if ($original_aspect >= $thumb_aspect) {

        $new_height = $thumb_height;
        $new_width = $width / ($height / $thumb_height);
    } else {

        $new_width = $thumb_width;
        $new_height = $height / ($width / $thumb_width);
    }


    // on va copier l'image originale suivant son extension
    if ($extension == ".jpg" || $extension == ".jpeg") {
        // en jpg
        $copie = imagecreatefromjpeg($origin . $name);
        // on adapte l'image au bon format, puis on colle
        imagecopyresampled($newImg, $copie, 0 - ($new_width - $thumb_width) / 2, 0 - ($new_height - $thumb_height) / 2, 0, 0, $new_width, $new_height, $width, $height);
        // on finalise le fichier jpg
        imagejpeg($newImg, $thumb . $name, $qualiteJpg);
    } elseif ($extension == ".png") {
        // en png
        $copie = imagecreatefrompng($origin . $name);
        // on adapte l'image au bon format, puis on colle
        imagecopyresampled($newImg, $copie, 0 - ($new_width - $thumb_width) / 2, 0 - ($new_height - $thumb_height) / 2, 0, 0, $new_width, $new_height, $width, $height);
        // on finalise le fichier png
        imagepng($newImg, $thumb . $name);
    } else {
        // en gif
        $copie = imagecreatefromgif($origin . $name);
        // on adapte l'image au bon format, puis on colle
        imagecopyresampled($newImg, $copie, 0 - ($new_width - $thumb_width) / 2, 0 - ($new_height - $thumb_height) / 2, 0, 0, $new_width, $new_height, $width, $height);
        // on finalise le fichier png
        imagegif($newImg, $thumb . $name);
    }
}


        
        