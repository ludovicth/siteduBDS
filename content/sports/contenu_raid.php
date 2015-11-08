<script type='text/javascript'> // script mettant en oeuvre l'affichage ou non des formulaires
    $(document).ready(function() {
        $(".formulaire").hide();
        $(".ajoutFormulaire").click(function() {
            $("#formulaire" + $(this).attr("id")).slideToggle("slow");
        });
    })
            ;
</script>

<h2>Raid</h2>


<!-- Code pour requérir les matchs de la semaine de ce sport -->
<?php
require_once('scripts/utilsBD.php');
$dbh = Database::connect();
$requete = "SELECT * FROM games WHERE dateDebut > ? AND dateDebut < ? AND sport = ? ORDER BY dateDebut ASC";
$sth = $dbh->prepare($requete);
$sth->setFetchMode(PDO::FETCH_CLASS, 'games');
// Rentrer ici la date à partir de laquelle les évènements s'affichent. Rentrer time() pour la date actuelle, mktime(0, 0, 0, date('m'), date('d'), date('Y')) pour la date sans heure'
$sth->execute(array(mktime(0, 0, 0, date('n'), date('j'), date('Y')) - ((date('N') - 1) * 3600 * 24), mktime(0, 0, 0, date('n'), date('j'), date('Y')) - ((date('N') - 1) * 3600 * 24) + 7 * 24 * 3600, 'raid'));
$reponse = null;
$matchsSemaine = array();
while ($reponse = $sth->fetch()) {
    $id = $reponse['id'];
    $type = $reponse['type'];
    $dateDebut = $reponse['dateDebut'];
    $dateFin = $reponse['dateFin'];
    $lieu = $reponse['lieu'];
    $sport = $reponse['sport'];
    if ($reponse['equipe'] === "NULL") {
        $equipe = "";
    }
    if ($reponse['equipe'] !== "NULL") {
        $equipe = $reponse['equipe'];
    }
    if ($reponse['adversaire'] === "NULL") {
        $adversaire = "inconnu";
    }
    if ($reponse['adversaire'] !== "NULL") {
        $adversaire = $reponse['adversaire'];
    }
    if ($reponse['joueurs'] === "NULL") {
        $joueurs = "non renseigné";
    }
    if ($reponse['joueurs'] !== "NULL") {
        $joueurs = $reponse['joueurs'];
    }
    if ($reponse['pub'] === "NULL") {
        $pub = "";
    }
    if ($reponse['pub'] !== "NULL") {
        $pub = $reponse['pub'];
    }

    $value = array(
        'id' => "$id",
        'title' => "$type de $equipe",
        'sport' => "$sport",
        'start' => "$dateDebut",
        'end' => "$dateFin",
        'lieu' => "$lieu",
        'allDay' => false,
        'adversaire' => "$adversaire",
        'joueurs' => "$joueurs",
        'pub' => "$pub"
    );

    array_push($matchsSemaine, $value);
}

$sth->closeCursor();
$dbh = null;
?>

<!--Affichage des résultats -->
<?php
require_once('scripts/utilsBD.php');
$dbh = Database::connect();
$requete = "SELECT * FROM games,resultats WHERE games.sport = 'raid' AND games.id = resultats.id ORDER BY games.dateDebut DESC";
// Requete sur les tables games et resultats. L'id commun du match fait la jointure entre les 2 tables
$sth = $dbh->prepare($requete);
$sth->setFetchMode(PDO::FETCH_CLASS, 'games');
$sth->execute(array());
$reponse = null;
$matchPasse = array(); //Matchs ou compétitions passés
while ($reponse = $sth->fetch()) {
    $id = $reponse['id'];
    $type = $reponse['type'];
    $dateDebut = $reponse['dateDebut'];
    $dateFin = $reponse['dateFin'];
    $lieu = $reponse['lieu'];
    $sport = $reponse['sport'];
    $vainqueur = $reponse['vainqueur'];
    $commentaire = $reponse['commentaire'];
    if ($reponse['equipe'] === "NULL") {
        $equipe = "";
    }
    if ($reponse['equipe'] !== "NULL") {
        $equipe = $reponse['equipe'];
    }
    if ($reponse['adversaire'] === "NULL") {
        $adversaire = "inconnu";
    }
    if ($reponse['adversaire'] !== "NULL") {
        $adversaire = $reponse['adversaire'];
    }
    if ($reponse['joueurs'] === "NULL") {
        $joueurs = "non renseigné";
    }
    if ($reponse['joueurs'] !== "NULL") {
        $joueurs = $reponse['joueurs'];
    }
    if ($reponse['pub'] === "NULL") {
        $pub = "";
    }
    if ($reponse['pub'] !== "NULL") {
        $pub = $reponse['pub'];
    }

    $value = array(
        'id' => "$id",
        'title' => "$type de $equipe",
        'sport' => "$sport",
        'start' => "$dateDebut",
        'end' => "$dateFin",
        'lieu' => "$lieu",
        'allDay' => false,
        'adversaire' => "$adversaire",
        'joueurs' => "$joueurs",
        'pub' => "$pub",
        'commentaire' => "$commentaire",
        'vainqueur' => "$vainqueur"
    );

    array_push($matchPasse, $value);
}
$sth->closeCursor();
$dbh = null;
?>


<div class="row">

    <!-- Bloc qui flote à droite, avec les deux panneaux d'affichage (matchs et résultats) -->
    <div class="col-lg-6" style="float: right">
        <div class="panel panel-accueil" style="padding-left: 0px; padding-right: 0px;">
            <div class="panel-heading">
                <h3 class="panel-title" style="font-weight: bolder; font-size: x-large;"><center>Matchs de la semaine</center></h3>
            </div>
            <div class="panel-body">
                <p>
                    <?php
                    // On affiche içi les matchs à voir cette semaine
                    $joursem = array("Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"); //permettra d'afficher le jour de la semaine
                    foreach ($matchsSemaine as $element) {
                        echo "<li><b>" . $element['title'] . " " . $element['sport'] . ", " . $joursem[date("w", $element['start'])] . " à " . date("H:i", $element['start']) . "</b>, lieu : " . deformaterTexte($element['lieu']) . "<br />";
                        if ($element['pub'] !== "") {
                            echo "<em>" . deformaterTexte($element['pub']) . "</em><br />";
                        }
                        echo "</li>";
                    }
                    ?>
                </p>
                <p style="text-align: center; font-size: bigger; font-weight: bolder">Pour le planning complet c'est par <a href="index.php?page=content/contenu_planning">ici</a></p>
            </div>
        </div>
        <br>
        <div class="panel panel-accueil" style="padding-left: 0px; padding-right: 0px;">
            <div class="panel-heading">
                <h3 class="panel-title" style="font-weight: bolder; font-size: x-large;"><center>Derniers résultats</center></h3>
            </div>
            <div class="panel-body">
                    <?php
                    // On affiche içi les derniers résultats.
                    // Affichage du type (compet/match), du sport, de la date, si il y a eu victoire, et le commentaire (avec le score à l'intérieur)
                    foreach ($matchPasse as $element) {
                        if ($element['vainqueur'] === "oui") {
                            echo "<li><em style='color: #36e74b; font-weight: bold; font-style: normal'> Victoire : </em>" . " <b>" . $element['title'] . " " . $element['sport'] . "</b> vs. " . deformaterTexte($element['adversaire']) . " du " . date("d/m", $element['start']) . "<br>";
                        }
                        if ($element['vainqueur'] === "non") {
                            echo "<li><em style='color: #8e8e8e; font-weight: bold; font-style: normal'> Défaite : </em>" . " <b>" . $element['title'] . " " . $element['sport'] . "</b> vs. " . deformaterTexte($element['adversaire']) . " du " . date("d/m", $element['start']) . "<br>";
                        }
                        if ($element['commentaire'] !== "") {
                            echo "<em>" . deformaterTexte($element['commentaire']) . "</em><br />";
                        }
                        echo "</li>";
                    }
                    ?>
                <p style="text-align: center; font-size: bigger; font-weight: bolder">Pour tous les résultats du Raid, c'est par <a href="index.php?page=content/resultats/raid">ici</a></p>
            </div>
        </div>
    </div>

    <p>La section Raid regroupe les meilleurs coureurs de l'Ecole Polytechnique. Elle organise chaque année le raid de l'X au mois de Juin</p>

    <p><?php
                    $dbh = Database::connect();
                    $query = "SELECT * FROM `teams` WHERE sport LIKE 'raid'";
                    $sth = $dbh->prepare($query);
                    $sth->setFetchMode(PDO::FETCH_ASSOC);
                    $sth->execute();
                    while ($equipe = $sth->fetch()) {

                        echo '<h5><b>' . $equipe['nomEquipe'] . ' :</b></h5>';
                        echo '<em>Capitaine :</em> ' . $equipe['capitaine'] . '<br><em>Equipe composée de :</em><br> ' . deformaterTexte($equipe["listeJoueurs"]);
                    }
                    ?>
    </p>



<?php
// Donner un résultat, possible si on est respo sport OU si on est capitaine d'une des équipes de ce sport
if (isset($_SESSION['estRespoSport']) && ($_SESSION['estRespoSport'] == "oui" || ($_SESSION['estCapitaine'] === "oui" && $_SESSION['section'] === "raid")))
    echo '<br><br><p><button class="ajoutFormulaire btn btn-warning" id="1">Donner le résultat de vos derniers événements</button></p>';
?>
    <div class="formulaire" id="formulaire1">
        <form action='index.php?page=content/sports/contenu_raid' method='post'>
            Identifiant de l'événement : <input type="number" name="id" size="8"/> <em>Pour le connaître, cliquez sur votre événement dans le planning</em>
            <br><br>
            Avez-vous gagné ? <select name="vainqueur" placeholder="oui">
                <option value="oui">Oui</option>
                <option value="non">Non</option>
            </select> <em>NB : si duel entre polytechniciens, mettez oui !</em><br><br>
            Détaillez brièvement votre résultat :
            <br><br>
            <textarea name='commentaire' placeholder="Score ? Podium ? Chrono ? N'hésitez pas à ajouter des commentaires sur votre match/compétition!" cols="70" rows='2'></textarea>
            <br>
            <br>
            <input type='submit' class="btn btn-warning" action='Valider'> <br><br>
        </form>
    </div>

<?php
// Ajouter une équipe
if (isset($_SESSION['estRespoSport']) && $_SESSION['estRespoSport'] == "oui")
    echo '<p><button class="ajoutFormulaire btn btn-warning" id="2">Ajouter une équipe</button></p>';
?>
    <div class="formulaire" id="formulaire2">
        <form action='index.php?page=content/sports/contenu_raid' method='post'>
            Nom de l'équipe: <input type="text" name="nomEquipe" placeholder="Nom de l'équipe"> (Précisez M ou F si la section est mixte !)<br><br>
            Capitaine de l'équipe : <input type="text" name="capitaine" placeholder="nom du capitaine"> et son adresse mail pour qu'il puisse ajouter ses matchs sur ce site : <input type="text" name="mailCapitaine"> @polytcehnique.edu<br><br> 
            Liste des joueurs (dont capitaine) : <textarea name ="listeJoueurs" placeholder="Liste des joueurs" cols="70" rows='3'></textarea><br>
            <input type='submit' class="btn btn-warning" action='Valider'><br><br>
        </form>
    </div>


    <?php
// Supprimer une équipe
    if (isset($_SESSION['estRespoSport']) && $_SESSION['estRespoSport'] == "oui")
        echo '<p><button class="ajoutFormulaire btn btn-warning" id="3">Supprimer une équipe</button></p>';
    ?>
    <div class="formulaire" id="formulaire3">
        <form action='index.php?page=content/sports/contenu_raid' method='post'>
            Nom de l'équipe à supprimer: <input type="text" name="name" placeholder="Nom de l'équipe"><br><br>
            <input type="radio" name="oui"> Je veux supprimer définitivement cette équipe <br><br>
            <input type='submit' class="btn btn-warning" action='Valider'><br><br>
        </form>
    </div>
</div>

<?php
$id = "";
if (array_key_exists('id', $_POST)) {
    $id = mysql_real_escape_string($_POST['id']);
}
$vainqueur = "";
if (array_key_exists('vainqueur', $_POST)) {
    $vainqueur = mysql_real_escape_string($_POST['vainqueur']);
}
$commentaire = "";
if (array_key_exists('commentaire', $_POST)) {
    $commentaire = mysql_real_escape_string($_POST['commentaire']);
}
//insère un résultat dans la bdd si un identifiant a été rentré
if (array_key_exists('id', $_POST) && $_POST['id'] !== NULL) {
    require_once('scripts/utilsBD.php');
    $dbh = Database::connect();
    $query = "INSERT INTO resultats(id,vainqueur,commentaire) VALUES (?,?,?)";
    $sth = $dbh->prepare($query);
    $sth->execute(array($id, $vainqueur, $commentaire));
    $sth->closeCursor();
    $dbh = null;
}


$nomEquipe = "";
if (array_key_exists('nomEquipe', $_POST)) {
    $nomEquipe = mysql_real_escape_string(htmlspecialchars($_POST['nomEquipe']));
}
$capitaine = "";
if (array_key_exists('capitaine', $_POST)) {
    $capitaine = mysql_real_escape_string(htmlspecialchars($_POST['capitaine']));
}
$mailCapitaine = "";
if (array_key_exists('mailCapitaine', $_POST)) {
    $mailCapitaine = mysql_real_escape_string(htmlspecialchars($_POST['mailCapitaine'] . "@polytechnique.edu"));
}
$listeJoueurs = "";
if (array_key_exists('listeJoueurs', $_POST)) {
    $listeJoueurs = mysql_real_escape_string(htmlspecialchars($_POST['listeJoueurs']));
}
$sport = "raid";

//insère une équipe dans la bdd si un nom d'équipe a été rentré
if (array_key_exists('nomEquipe', $_POST) && $_POST['nomEquipe'] !== NULL) {
    require_once('scripts/utilsBD.php');
    $dbh = Database::connect();
    $query = "INSERT INTO teams(nomEquipe,sport,capitaine,listeJoueurs) VALUES (?,?,?,?)";
    $sth = $dbh->prepare($query);
    $sth->execute(array($nomEquipe, $sport, $capitaine, $listeJoueurs));
    //la requête suivante donne les droits au capitaine pour ajouter ses matchs et résultats
    $query = "UPDATE users SET estCapitaine =  'oui' WHERE  `users`.`mail` =  (?)";
    $sth = $dbh->prepare($query);
    $sth->execute(array($mailCapitaine));
    $sth->closeCursor();
    $dbh = null;
}

$name = "";
if (array_key_exists('name', $_POST)) {
    $name = mysql_real_escape_string(htmlspecialchars($_POST['name']));
}
$oui = "";
if (array_key_exists('name', $_POST)) {
    $oui = $_POST['oui'];
}

//Supprime une équipe
if (array_key_exists('oui', $_POST) && $_POST['name'] !== NULL) {
    require_once('scripts/utilsBD.php');
    $dbh = Database::connect();
    $query = "DELETE FROM teams WHERE nomEquipe='$name' AND sport ='$sport'";
    $dbh->query($query);
    $dbh = null;
}