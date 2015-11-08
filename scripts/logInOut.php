<?php
class Log {
// pour se connecter
function logIn(){

    if (array_key_exists('mail', $_POST)&& array_key_exists('mail', $_POST)){
        $user = User::getUtilisateur(mysql_real_escape_string(htmlspecialchars($_POST['mail']))); //évite les injections sql
        if (! $user==NULL && $user->testerMDP(htmlspecialchars($_POST['mdp']))){ //pas d'injection sql possible ici puisque la requete a deja ete effectuée via getUtilisateur
            $_SESSION['loggedIn'] = true;
            $_SESSION['mail'] = $user->mail;
            $_SESSION['nom'] = $user->nom;
            $_SESSION['prenom'] = $user->prenom;
            $_SESSION['promo'] = $user->promo;
            $_SESSION['section'] = $user->section;
            $_SESSION['estCapitaine'] = $user->estCapitaine;
            $_SESSION['estRespoSport'] = $user->estRespoSport;
            return true;
        }
    }
    else{ 
        return false;
    }
}


// pour se deconnecter
function logOut(){   
    $_SESSION['loggedIn'] = false;
    unset($_SESSION['mail']);
    unset($_SESSION['nom']);
    unset($_SESSION['prenom']);
    unset($_SESSION['promo']);
    unset($_SESSION['section']);
    unset($_SESSION['estCapitaine']);
    unset($_SESSION['estRespoSport']);
}
}
?>
