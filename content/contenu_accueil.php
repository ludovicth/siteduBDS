<!-- Code pour requérir les matchs du jour -->
<?php
require_once('scripts/utilsBD.php');
$dbh = Database::connect();
$requete = "SELECT * FROM games WHERE dateDebut > ? AND dateDebut < ? ORDER BY dateDebut ASC";
$sth = $dbh->prepare($requete);
$sth->setFetchMode(PDO::FETCH_CLASS, 'games');
// Rentrer ici la date à partir de laquelle les évènements s'affichent. Rentrer time() pour la date actuelle, mktime(0, 0, 0, date('m'), date('d'), date('Y')) pour la date sans heure'
$sth->execute(array(mktime(0, 0, 0, date('n'), date('j'), date('Y')) - ((date('N') - 1) * 3600 * 24), mktime(0, 0, 0, date('n'), date('j'), date('Y')) - ((date('N') - 1) * 3600 * 24) + 7 * 24 * 3600));
$reponse = null;
$matchsAJD = array();
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

    array_push($matchsAJD, $value);
}

$sth->closeCursor();
$dbh = null;
?>

<!-- Code pour réquérir les résultats de la semaine passée -->

<?php
require_once('scripts/utilsBD.php');
$dbh = Database::connect();
$requete = "SELECT * FROM games,resultats WHERE games.id = resultats.id ORDER BY games.dateDebut DESC";
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

<br>
<!-- Slideshow - NB : attention aux formats des images à insérer. Pour ws_images : 960x360 pixels, et pour ws_bullets : 128x48px -->
<div id="wowslider-container1">
    <div class="ws_images"><ul>
            <li><img src="slideshow/data/images/logobds8.png" alt="Bienvenue !" title="Bienvenue !" id="wows1_0"/>Découvrez le nouveau site du BDS</li>
            <li><img src="slideshow/data/images/453tsged2014.jpg" alt="Le volley féminin remporte le TSGED !" title="Le volley féminin remporte le TSGED !" id="wows1_1"/>Un 4e titre consécutif pour l'équipe</li>
            <li><a href="index.php?page=content/contenu_events"><img src="slideshow/data/images/toss_2014.jpg" alt="Le TOSS 2014 approche" title="Le TOSS 2014 approche" id="wows1_2"/></a>Renseignements sur la page événements</li>
        </ul></div>
    <div class="ws_bullets"><div>
            <a href="#" title="Bienvenue !"><img src="slideshow/data/tooltips/logobds8.png" alt="Bienvenue !"/>1</a>
            <a href="#" title="Le volley féminin remporte le TSGED !"><img src="slideshow/data/tooltips/453tsged2014.jpg" alt="Le volley féminin remporte le TSGED !"/>2</a>
            <a href="#" title="Le TOSS 2014 approche"><img src="slideshow/data/tooltips/toss_2014.jpg" alt="Le TOSS 2014 approche"/>3</a>
        </div></div>
    <div class="ws_shadow"></div>
</div>
<script type="text/javascript" src="slideshow/engine/wowslider.js"></script>
<script type="text/javascript" src="slideshow/engine/script.js"></script>
<br>

<!-- Colonnes sous le slideshow -->
<div class="row">
    <div class="col-lg-6">
        <div class="panel panel-accueil" style="padding-left: 0px; padding-right: 0px;">
        <div class="panel-heading">
            <h3 class="panel-title" style="font-weight: bolder; font-size: x-large;"><center>Derniers résultats</center></h3>
        </div>
        <div class="panel-body">
            <p>
                <?php
                // On affiche içi les derniers résultats.
                // Affichage du type (compet/match), du sport, de la date, si il y a eu victoire, et le commentaire (avec le score à l'intérieur)
                echo "<em style='color: #36e74b; font-weight: bold; font-style: normal'>VICTOIRES</em><br>";
                foreach ($matchPasse as $element) {
                    if ($element['vainqueur'] === "oui") {
                        echo "<li><b>" . $element['title'] . " <a href = 'index.php?page=content/sports/contenu_".$element['sport']."'>" . $element['sport'] . "</a> vs. " . deformaterTexte($element['adversaire']) . "</b> " . " du " . date("d/m", $element['start']) . "<br>";
                        if ($element['commentaire'] !== "") {
                            echo "<em>" . deformaterTexte($element['commentaire']) . "</em><br />";
                        }
                        echo "</li>";
                    }
                }
                echo "<br><em style='color: #8e8e8e; font-weight: bold; font-style: normal'>DEFAITES</em><br>";
                foreach ($matchPasse as $element) {
                    if ($element['vainqueur'] === "non") {
                        echo "<li><b>" . $element['title'] . " <a href = 'index.php?page=content/sports/contenu_".$element['sport']."'>" . $element['sport'] . "</a> vs. " . deformaterTexte($element['adversaire']) . "</b> " . " du " . date("d/m", $element['start']) . "<br>";
                        if ($element['commentaire'] !== "") {
                            echo "<em>" . deformaterTexte($element['commentaire']) . "</em><br />";
                        }
                        echo "</li>";
                    }
                }
                ?>
            </p>
        </div>
        </div>
        <div class="panel panel-accueil" style="padding-left: 0px; padding-right: 0px; float: left">
        <div class="panel-heading">
            <h3 class="panel-title" style="font-weight: bolder; font-size: x-large;"><center>Chronique du Kessier Sport</center></h3>
        </div>
        <div class="panel-body">
        La chronique sportive que vous retrouvez chaque semaine dans l'IK sera aussi visible ici !    
        </div>
    </div>
    </div>
    
    <div class="col-lg-5 panel panel-accueil" style="padding-left: 0px; padding-right: 0px; float: right">
        <div class="panel-heading">
            <h3 class="panel-title" style="font-weight: bolder; font-size: x-large;"><center>Matchs à voir aujourd'hui</center></h3>
        </div>
        <div class="panel-body">
            <p>
                <?php
                // affichage des matchs à voir auj, avec le sport, le lieu, l'heure et la pub éventuelle
                foreach ($matchsAJD as $element) {
                    echo "<li>".$element['title']." <b><a href = 'index.php?page=content/sports/contenu_".$element['sport']."'>".$element['sport']."</b></a> à <b>".date("H:i", $element['start'])."</b>, lieu : ".deformaterTexte($element['lieu'])."<br />";
                    if ($element['pub']!=="") {
                        echo "<em>".deformaterTexte($element['pub'])."</em><br />";
                    }
                    echo "</li>";
                }
                ?>
            </p>
            <p><a class="btn btn-warning" href="index.php?page=content/contenu_planning" role="button">Voir le planning complet &raquo;</a></p>
        </div>
    </div>
    <br>
</div>

