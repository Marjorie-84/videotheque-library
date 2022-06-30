<?php

// connect function
function connectUser($connect,$pseudo,$password){
    // traitement des données
    $pseudo = htmlspecialchars(strip_tags(trim($pseudo)),ENT_QUOTES);
    $password = htmlspecialchars(strip_tags(trim($password)),ENT_QUOTES);
    // request
    $sql = "SELECT * FROM admin WHERE pseudo='$pseudo' AND pwd='$password';";
    $recup = mysqli_query($connect,$sql) or die(mysqli_error($connect));

    if(mysqli_num_rows($recup)){
        return mysqli_fetch_assoc($recup);
    }else{
        return false;
    }

}