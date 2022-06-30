<?php
// CALLING MODEL
require_once "../model/public/connect.public.model.php";

// si on essaye de se connecter
if (isset($_GET['page']) && $_GET['page'] == "connect") {

    // si le formulaire est envoyé
    if (isset($_POST['pseudo'], $_POST['pwd'])) {
        // traitement des données
        $pseudo = htmlspecialchars(strip_tags(trim($_POST['pseudo'])), ENT_QUOTES);
        $password = htmlspecialchars(strip_tags(trim($_POST['pwd'])), ENT_QUOTES);

        $connect = connectUser($db, $pseudo, $password);

        // connexion réussie
        if ($connect) {

            // création de la session
            //var_dump($connect);
            $_SESSION = $connect; // on mets les variables récupérées via SQL de type tableau associatif dans le tableau de session
            $_SESSION['identifiant'] = session_id();

            // redirection
            header("Location: ?admin=home");
            exit();
        } else {
             echo "<h1>Login ou mot de passe incorrect</h1>";
              // view
       
        }
    }
        
   
}
require_once "../view/public/connect.public.view.php";