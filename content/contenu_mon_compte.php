<script type='text/javascript' src='js/fullcalendar.min.js'></script>
<script type='text/javascript' src='js/code_calendar.js'></script>

<script type='text/javascript'> // script mettant en oeuvre l'affichage ou non du formulaire d'ajout ou de retrait
    $(document).ready(function(){
        $(".formulaire").hide();
        $(".ajoutFormulaire").click(function() {
            $("#formulaire" + $(this).attr("id")).slideToggle("slow");
        });
    })
    ;
</script>

<div class ="bloc">
    <p> <b>Adresse mail:</b> 
        
        
        <?php
            if(!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
                header("location:index.php?page=content/contenu_connexion"); // redirection vers la page connexion si pas connecté
            }

            if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) echo $_SESSION['mail']; // affiche l'email
            //suppression du compte
            $mail=$_SESSION['mail'];
            if (isset($_POST['oui'])) {
                require_once('scripts/utilsBD.php');
                $dbh = Database::connect();
                $query = "DELETE FROM users WHERE mail='$mail'";
                $dbh->query($query);
                $dbh = null;
                Log::logOut();
                header("location:index.php?page=content/contenu_accueil");
            }
            //suppression du compte
            
            //changement de mdp
            if(isset($_POST['oldpwd']) && isset($_POST['newpwd1']) && isset($_POST['newpwd2']) && htmlspecialchars($_POST['newpwd1'])==htmlspecialchars($_POST['newpwd2'])){ // on vérifie que les nouveaux mdp sont identiques
                if((User::getUtilisateur($_SESSION['mail'])->mdp)== sha1(htmlspecialchars($_POST['oldpwd']))){ //on vérifie que le mdp entré est le bon
                    if(preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", htmlspecialchars($_POST['newpwd1']))){ //le nouveau mdp doit etre suffisamment fort
                        User::updateMDP(htmlspecialchars($_POST['newpwd1']),$_SESSION['mail']); //on change le mdp
                    }
                    else echo "Pour votre sécurité, votre nouveau mot de passe doit contenir au moins 8 caractères, 1 lettre majuscule, 1 chiffre et un symbole";
                }
                else{
                    echo "Mauvais mot de passe!";
                }
                
            //utiliser htmlspecialchars pour empecher une injection sql   
            }
            else if(isset($_POST['newpwd1']) && isset($_POST['newpwd2']) && htmlspecialchars($_POST['newpwd1'])!=htmlspecialchars($_POST['newpwd2'])){
                echo "Les mots de passe ne sont pas les mêmes !";
            }
            //changement de mdp

        ?>
    </p>
</div>  

<button class="ajoutFormulaire btn btn-warning" id="3">Supprimer mon compte</button><br>
<div class="formulaire" id="formulaire3">

    <p> Attention, vous allez supprimer votre compte et toutes les données qui y sont liées. Voulez vous réellement continuer? </p>
    <form action = 'index.php?page=content/contenu_mon_compte' method='POST'>    
        <input type="radio" name='oui' > Je veux supprimer mon compte et toutes mes données liées à ce site.
        <input class="btn btn-warning" type="submit" name='supprimer' value='Supprimer'><br><br> 
    </form>
</div>

<br>
<button class="ajoutFormulaire btn btn-warning" id="4">Changer mon mot de passe</button>
<div class="formulaire" id="formulaire4">
    <form action='index.php?page=content/contenu_mon_compte' method='POST'>
        Entrez l'ancien mot de passe: <input type ='password' name =' oldpwd' placeholder="Ancien mot de passe"><br><br>
        Entrez votre nouveau mot de passe: <input type='password' name="newpwd1" placeholder="Nouveau mot de passe" maxlength="20"><br><br>
        Confirmez votre nouveau mot de passe: <input type="password" name="newpwd2" placeholder="Confirmation" maxlength="20"><br><br>
        <input class="btn btn-warning" type ="submit" name ="changer" value="Changer de mot de passe"><br><br>
    </form>
</div>