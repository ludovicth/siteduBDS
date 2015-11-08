<?php

$erreur = "";
$ok = FALSE;
$tentative = FALSE;
if (isset($_POST['mail']) && !$_POST['mail']==""){
    $tentative = TRUE;
    echo "toto";
    $mail = htmlspecialchars($_POST['mail']);
    $mdp = User::genererMDP(8); //genere un nouveau mdp aleatoire de longueur 8
    User::updateMDP($mdp,$mail);
    $message =  "Bonjour!\r\nVoici ton nouveau mot de passe: $mdp \r\nN'oublie pas de le changer au plus vite! \r\nCeci est un message automatique, merci de ne pas y répondre.";
    $ok= mail('$mail', '[Site du BDS] Changement de mot de passe', $message);
    var_dump($ok);
}

    if ($ok){
        echo "Votre mot de passe a été réinitialisé et envoyé par mail.";
    }
    else{
        if ($tentative){
            echo "Adresse mail erronée !";
        }



echo<<<FIN
<form action="index.php?page=mdp_oublie" method="post">
        <br>
        Entre ton adresse mail pour recevoir un nouveau mot de passe: <input type="text" name="mail" value="" placeholder="adresse mail" /><br><br>

            <br><input class="btn btn-sm btn-success" type='submit' action='valider'>
    </form>
FIN;
}
?>