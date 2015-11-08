<?php
// On récupère les infos sur les résultats
require_once('scripts/utilsBD.php');
$dbh = Database::connect();
$requete = "SELECT * FROM games,resultats WHERE games.sport = 'boxe' AND games.id = resultats.id ORDER BY games.dateDebut DESC";
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
<?php

// On affiche içi les derniers résultats.
// Affichage du type (compet/match), du sport, de la date, si il y a eu victoire, et le commentaire (avec le score à l'intérieur)
echo "<br>";
foreach ($matchPasse as $element) {
    if ($element['vainqueur'] === "oui") {
        echo "<li><em style='color: #36e74b; font-weight: bold; font-style: normal'> Victoire : </em>" . " <b>" . $element['title'] . " " . $element['sport'] . "</b> vs. " . deformaterTexte($element['adversaire']) . " du " . date("d/m", $element['start']) . "<br>";
        // Le deformater texte n'est necessaire que pour le titre de l'adversaire pour traiter les noms avec des apostrophes
    }
    if ($element['vainqueur'] === "non") {
        echo "<li><em style='color: #8e8e8e; font-weight: bold; font-style: normal'> Défaite : </em>" . " <b>" . $element['title'] . " " . $element['sport'] . "</b> vs. " . deformaterTexte($element['adversaire']) . " du " . date("d/m", $element['start']) . "<br>";
    }
    if ($element['commentaire'] !== "") {
        echo "<em>" . $element['commentaire'] . "</em><br />";
    }
    echo "</li>";
}
?>