<h2>Formulaire d'inscription</h2>

<?php

// sert à ne pas re-rentrer toutes les données du formulaire si jamais on se trompe dans le captcha ou dans son mot de passe
$nom = "";
if (array_key_exists('nom',$_POST)){
    $nom = htmlspecialchars($_POST['nom']);
}

$prenom = "";
if (array_key_exists('prenom',$_POST)){
    $prenom = htmlspecialchars($_POST['prenom']);
}

$promo = "";
if (array_key_exists('promo',$_POST)){
    $promo = htmlspecialchars($_POST['promo']);
}

$mail = "";
if (array_key_exists('mail',$_POST)){
    $mail = htmlspecialchars($_POST['mail']);
}

$section = "";
if (array_key_exists('section',$_POST)){
    $section = htmlspecialchars($_POST['section']);
}
$oui='1'; // ce $oui servira à déterminer s'il faut générer un nouveau captcha ou pas. 

$erreur = "";
$ok = FALSE; // si $ok = TRUE, l'inscription sera ok
$tentative = FALSE; // désigne une tentative d'inscription

if (isset($_POST['code_entre']) && isset($_SESSION["captcha"])){ // verifie que le captcha est rentré
if (isset($_POST['mail']) && !$_POST['mail']=="" && isset($_POST['mdp']) && isset($_POST['mdp2']) && htmlspecialchars($_POST['mdp'])==htmlspecialchars($_POST['mdp2'])  && preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $_POST['mdp'])){
    // on a verifié que tous les champs sont remplis et non vides, et que le mdp est suffisamment fort
    $code_entre = mysql_real_escape_string(htmlspecialchars($_POST['code_entre']));

    if($code_entre == NULL){
        echo "Vous n'avez pas rentré de code!";
    }
    elseif($code_entre != $_SESSION["captcha"]){
        echo "Mauvais code!";
    }
    else{
    $tentative = TRUE;
    $mail=mysql_real_escape_string(htmlspecialchars($_POST['mail']));
    $mdp=mysql_real_escape_string(htmlspecialchars($_POST['mdp']));
    $prenom=mysql_real_escape_string(htmlspecialchars($_POST['prenom']));
    $nom=mysql_real_escape_string(htmlspecialchars($_POST['nom']));
    $promo=mysql_real_escape_string(htmlspecialchars($_POST['promo']));
    $section=mysql_real_escape_string(htmlspecialchars($_POST['section']));
    $ok= User::insererUtilisateur($mail,$mdp,$prenom,$nom,$promo,$section); //insère dans la bdd
    } 
}

if ($ok){
    echo "Votre inscription a été effectuée ! Vous pouvez désormais vous connecter!";
}
else{
    if ($tentative){
        echo "Utilisateur existant !";
    }
    if (isset($_POST['mdp']) && isset($_POST['mdp2']) && htmlspecialchars($_POST['mdp'])!=htmlspecialchars($_POST['mdp2'])){
        echo "Mots de passe différents !";

    }
    
    if(!preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $_POST['mdp'])){ // version compacte pour forcer un mdp fort
        echo "Pour votre sécurité, votre mot de passe doit contenir au moins 8 caractères, 1 lettre majuscule, 1 chiffre et un symbole";
    }
    
}
}
else{
    $oui = '0'; // il faudra donc générer un nouveau captcha

}

if($oui == '0'){
    //génération du captcha
    $code = rand('100000', '999999');
    header ('Content-type: image/png');
    $image = imagecreate('56', '20');
    $noir = imagecolorallocate($image, '0', '0', '0');
    $blanc = imagecolorallocate($image, '255', '255', '255');
    imagestring($image, '4', '4', '2', $code, $blanc);
    imagepng($image, 'images/code.png');
    header ('Content-type: text/html');
    $_SESSION['captcha']= $code;
    //La variable de session est indispensable sinon $code est perdu lorsque l'on recharge la page
}

echo<<<FIN
<form action='index.php?page=content/contenu_register' method='POST'>
    <input type='text' name='prenom' placeholder='prenom' value='$prenom' required><br><br>
    <input type='text' name='nom' placeholder='nom' value='$nom' required><br><br>
    <input type='text' name='mail' placeholder='prenom.nom' value='$mail' required>@polytechnique.edu<br><br>
    <input type='password' name='mdp' placeholder='mot de passe' required><br><br>
    <input type='password' name='mdp2' placeholder='confirmer mot de passe' required><br><br>
    Promotion : <input type='number' name='promo' value='2012' ><br><br>
        
    Section: <select name="section">
        <option value="aviron">Aviron</option>
        <option value="badminton">Badminton</option>
        <option value="basket">Basket</option>
        <option value="boxe">Boxe</option>
        <option value="escalade">Escalade</option>
        <option value="escrime">Escrime</option>
        <option value="equitation">Equitation</option>
        <option value="foot">Foot</option>
        <option value="hand">Handball</option>
        <option value="judo">Judo</option>
        <option value="natation">Natation</option>
        <option value="raid">Raid</option>
        <option value="rugby">Rugby</option>
        <option value="tennis">Tennis</option>
        <option value="volley">Volley</option>
        <option value="cadres">Cadres</option>
        
        
    </select>
        
    <br><br>    
    <p><img src="images/code.png" title="Code" alt="Code"/> <input type='text' name="code_entre" placeholder="Entrez le code" size="10" maxlength="6" />
    
    <br><br><br><input class="btn btn-sm btn-success" type='submit' action='valider'>
</form>
FIN;
    
?>