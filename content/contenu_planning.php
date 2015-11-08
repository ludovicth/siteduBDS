<script type='text/javascript' src='js/fullcalendar.min.js'></script>
<script type='text/javascript' src='js/code_calendar.js'></script>
<script src="js/jquery-ui-1.10.4.min.js"></script>
<script type='text/javascript'> // script mettant en oeuvre l'affichage ou non du formulaire d'ajout ou de retrait
    $(document).ready(function(){
        $(".formulaire").hide();
        $(".ajoutFormulaire").click(function() {
            $("#formulaire" + $(this).attr("id")).slideToggle("slow");
        });
    })
    ;
</script>

<h2 style="font-weight: bold; text-align: center">Planning des matchs et compétitions</h2>
<br>

<div data-role="popup" id="popupDialog" class="ui-content" data-overlay-theme="a" title="événement sélectionné :">
    <p><span id="message"></span></p>
</div>

<div id="calendar"></div>
<br>
<br>
<?php
if (isset($_SESSION['loggedIn']) && ($_SESSION['loggedIn'])) {
    if ($_SESSION['estRespoSport'] === "oui") {
        echo <<<END
<button class="ajoutFormulaire btn btn-warning" id="1">Ajouter un match/une compétion</button>
<button class="ajoutFormulaire btn btn-warning" id="2" style="float: right">Supprimer un match/une compétion</button>
<div class="formulaire" id="formulaire1">
    <br><br>
    <form method="post" action="index.php?page=content/contenu_planning">
        <label>Votre évènement est </label> <select name='type'>
            <option value="Match">un match</option>
            <option value="Compétition">une compétition</option>
        </select>
        <label> de la section : </label> 
        <select name="section">
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
        </select>
        <br><br>
        <label>Date :</label> <input type="date" name="date"/> Impérativement au format jj/mm/aaaa !
        <br><br><label>Heure de début :</label> <input type="time" name="heureDebut"/> <label>Heure de fin : </label> (approximative) <input type="time" name="heureFin"/> Impérativement au format hh:mm !
        <br><br>
        <label>Lieu : </label> <input type="text" name="lieu" placeholder="Grand gymnase, T5, HEC,..." size="40"/>
        <br><br>
        <label>Equipe engagée : </label> <input type="text" name="equipe" size="8"/>
        <label> et liste (optionnelle) des joueurs :</label> <input type="text" name="joueurs" />
        <br><br>
        <label>Adversaire :</label> <input type="text" name="adversaire" placeholder="laisser vide si compétition ou si adversaire non défini" size="55"/>
        <br><br>
        <label>Votre pub :</label>
        <br><textarea name="pub" placeholder="S'il risque d'y avoir du spectacle, attirez des supporters en décrivant pourquoi ici !" rows="2" cols="50"></textarea>    
        <br><br>
        <input class="btn btn-sm btn-warning" type='submit' action='valider'>
    </form>
</div>

<div class="formulaire" id="formulaire2">
    <br><br>
    <form method="post" action="index.php?page=content/contenu_planning">
        En cliquant sur un évènement, vous accéderez à son "identifiant" (un nombre, en fait).
        Rentrez-le ici pour supprimer l'événement : <input type="number" name="id" size="8"/>
        <input class="btn btn-sm btn-warning" type='submit' action='valider'>
    </form>
</div>
END;
    }
    else if ($_SESSION['estCapitaine'] === "oui") {
        require_once('scripts/utilsBD.php');
        $dbh = Database::connect();
        $requete = "SELECT * FROM users WHERE mail = ?";
        $sth = $dbh->prepare($requete);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'users');
        $sth->execute(array($_SESSION['mail']));
        $reponse = null;
        $reponse = $sth->fetch();
        $section = $reponse['section'];
        echo <<<END
<button class="ajoutFormulaire btn btn-warning" id="1">Ajouter un match/une compétion</button>
<button class="ajoutFormulaire btn btn-warning" id="2" style="float: right">Supprimer un match/une compétion</button>
<div class="formulaire" id="formulaire1">
    <br><br>
    <form method="post" action="index.php?page=content/contenu_planning">
        <label>Votre évènement est </label> <select name='type'>
            <option value="Match">un match</option>
            <option value="Compétition">une compétition</option>
        </select>
        <label> de la section : </label> 
        <select name="section">
            <option value="$section">$section</option>
        </select>
        <br><br>
        <label>Date :</label> <input type="date" name="date"/> Impérativement au format jj/mm/aaaa !
        <br><br><label>Heure de début :</label> <input type="time" name="heureDebut"/> <label>Heure de fin : </label> (approximative) <input type="time" name="heureFin"/> Impérativement au format hh:mm !
        <br><br>
        <label>Lieu : </label> <input type="text" name="lieu" placeholder="Grand gymnase, T5, HEC,..." size="40"/>
        <br><br>
        <label>Equipe engagée : </label> <input type="text" name="equipe" size="8"/>
        <label> et liste (optionnelle) des joueurs :</label> <input type="text" name="joueurs" />
        <br><br>
        <label>Adversaire :</label> <input type="text" name="adversaire" placeholder="laisser vide si compétition ou si adversaire non défini" size="55"/>
        <br><br>
        <label>Votre pub :</label>
        <br><textarea name="pub" placeholder="S'il risque d'y avoir du spectacle, attirez des supporters en décrivant pourquoi ici !" rows="2" cols="50"></textarea>    
        <br><br>
        <input class="btn btn-sm btn-warning" type='submit' action='valider'>
    </form>
</div>

<div class="formulaire" id="formulaire2">
    <br><br>
    <form method="post" action="index.php?page=content/contenu_planning">
        En cliquant sur un évènement, vous accéderez à son "identifiant" (un nombre, en fait).
        Rentrez-le ici pour supprimer l'événement : <input type="number" name="id" size="8"/>
        <input class="btn btn-sm btn-warning" type='submit' action='valider'>
    </form>
</div>
END;
    }
}


$type = "";
if (array_key_exists('type',$_POST)){
    $type = mysql_real_escape_string($_POST['type']);
}

$section = "";
if (array_key_exists('section',$_POST)){
    $section = mysql_real_escape_string($_POST['section']);
}

$dateDebut = "";
$dateFin = "";
if ((array_key_exists('date',$_POST))&&(array_key_exists('heureDebut', $_POST))&&(array_key_exists('heureFin', $_POST))){
    $dateDebutlong = new DateTime("".mysql_real_escape_string($_POST['date'])." ".mysql_real_escape_string($_POST['heureDebut']));
    $dateFinlong = new DateTime("".mysql_real_escape_string($_POST['date'])." ".mysql_real_escape_string($_POST['heureFin']));
    $dateDebut = $dateDebutlong->getTimestamp();
    $dateFin = $dateFinlong->getTimestamp();
}

$lieu = "";
if (array_key_exists('lieu',$_POST)){
    $lieu = mysql_real_escape_string($_POST['lieu']);
}

$equipe = "";
if (array_key_exists('equipe',$_POST)){
    $equipe = mysql_real_escape_string($_POST['equipe']);
}

$joueurs = "";
if (array_key_exists('joueurs',$_POST)){
    $joueurs = mysql_real_escape_string($_POST['joueurs']);
}

$adversaire = "";
if (array_key_exists('adversaire',$_POST)){
    $adversaire = mysql_real_escape_string($_POST['adversaire']);
}

$pub = "";
if (array_key_exists('pub',$_POST)){
    $pub = mysql_real_escape_string($_POST['pub']);
}

$identifiant = "";
if (array_key_exists('id', $_POST)){
    $identifiant = mysql_real_escape_string($_POST['id']);
}

require_once('scripts/utilsBD.php');


if (array_key_exists('type', $_POST)){
    $dbh = Database::connect();
    $query = "INSERT INTO games(type,dateDebut,dateFin,lieu,sport,equipe,adversaire,joueurs,pub) VALUES (?,?,?,?,?,?,?,?,?)";
    $sth = $dbh->prepare($query);
    $sth->execute(array($type,$dateDebut,$dateFin,$lieu,$section,$equipe,$adversaire,$joueurs,$pub));
    $sth->closeCursor();
    $dbh = null;
}
if (array_key_exists('id', $_POST)){
    $dbh = Database::connect();
    $query = "DELETE FROM games WHERE id = ?";
    $sth = $dbh->prepare($query);
    $sth->execute(array($identifiant));
    $sth->closeCursor();
    $dbh = null;
}