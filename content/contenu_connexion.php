<h2>Connexion</h2>

<?php
$erreur = "";
$ok = FALSE;
$tentative = FALSE;
if (isset($_POST['mail']) && !$_POST['mail']=="" && isset($_POST['mdp'])){
    $tentative = TRUE;
    $ok= Log::logIn();
}

    if ($ok){
        header("location:index.php?page=content/contenu_accueil"); // redirige vers la page d'accueil si connexion réussie
    }
    else{
        if($tentative){
            echo "Utilisateur ou mot de passe erroné!";

        }
    }


echo<<<FIN
<form action='index.php?page=content/contenu_connexion' method='POST'>
        <input type='text' name='mail' placeholder='adresse mail'><br><br>
        <input type='password' name ='mdp' placeholder='mot de passe'><br>
        <a href="index.php?page=content/contenu_mdp_oublie" class="button small ">mot de passe oublié?</a><br>
        <br><input class="btn btn-sm btn-success" type='submit' action='valider'>
</form>


FIN;
?>