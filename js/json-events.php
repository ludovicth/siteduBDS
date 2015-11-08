<?php
        require_once('../scripts/utilsBD.php');
        $dbh = Database::connect();
        
        // on réunit d'abord tous les matchs et compétitions
        $requete = "SELECT * FROM games WHERE dateDebut > ? ORDER BY 'dateDebut' ASC";
        $sth = $dbh->prepare($requete);
        $sth->setFetchMode(PDO::FETCH_CLASS,'games');
        // Rentrer ici la date à partir de laquelle les évènements s'affichent. Rentrer time() pour la date actuelle'
        $sth->execute(array(time()-60*60*24*7*30*3));
        $reponse = null;
        $resultatJson = array();
        while ($reponse = $sth->fetch()){
            $id = $reponse['id'];
            $type = $reponse['type'];
            $dateDebut = $reponse['dateDebut'];
            $dateFin = $reponse['dateFin'];
            $lieu = $reponse['lieu'];
            $sport = $reponse['sport'];
            if ($reponse['equipe']==="NULL") {
                $equipe = "";
            }
            if ($reponse['equipe']!=="NULL") {
                $equipe = $reponse['equipe'];  
            }
            if (($reponse['adversaire']==="NULL")||($reponse['adversaire']==="")) {
                $adversaire = "?";
            }
            else if ($reponse['adversaire']!=="NULL") {
                $adversaire = $reponse['adversaire'];  
            }
            if (($reponse['joueurs']==="NULL")||($reponse['joueurs']==="")) {
                $joueurs = "non renseigné";
            }
            else if ($reponse['joueurs']!=="NULL") {
                $joueurs = $reponse['joueurs'];  
            }
            if (($reponse['pub']==="NULL")||($reponse['pub']==="")){
                $pub = "";
            }
            else if ($reponse['pub']!=="NULL") {
                $pub = $reponse['pub'];  
            }
            
            $value = array(
                'id' => "$id",
                'type' => "$type",
                'title' => "$type de $equipe $sport",
                'start' => "$dateDebut",
                'end' => "$dateFin",
                'lieu' => "$lieu",
                'allDay' => false,
                'adversaire' => "$adversaire",
                'joueurs' => "$joueurs",
                'pub' => "$pub",
                );
            
            array_push($resultatJson, $value);
        }
        //$sth->closeCursor();
        
        //on réunit ensuite tous les événements marquants, grands tournois, etc
        $requete = "SELECT * FROM events WHERE dateDebut > ? ORDER BY 'dateDebut' ASC";
        $sth = $dbh->prepare($requete);
        $sth->setFetchMode(PDO::FETCH_CLASS,'events');
        // Rentrer ici la date à partir de laquelle les évènements s'affichent. Rentrer time() pour la date actuelle'
        $sth->execute(array(time()-60*60*24*7*30*3)); // ici, les événements depuis trois mois
        $reponse = null;
        while ($reponse = $sth->fetch()){
            $id = $reponse['id'];
            $title = $reponse['title'];
            $dateDebut = $reponse['dateDebut'];
            $dateFin = $reponse['dateFin'];
            if ($reponse['allDay']==="oui") {
                $allDay = true;
            }
            if ($reponse['allDay']==="non") {
                $allDay = false;
            }
            if (($reponse['descriptif']==="NULL")||($reponse['descriptif']==="")){
                $descriptif = "";
            }
            else if ($reponse['descriptif']!=="NULL") {
                $descriptif = $reponse['descriptif'];  
            }
            
            $value = array(
                'id' => "$id",
                'type' => "événement",
                'title' => "$title",
                'start' => "$dateDebut",
                'end' => "$dateFin",
                'allDay' => $allDay,
                'descriptif' => "$descriptif",
                'color' => '#f7d200',
                );
            
            array_push($resultatJson, $value);
        }
        
        $sth->closeCursor();
        $dbh = null;

        echo json_encode($resultatJson);
        
	/*Un petit test hors base de données :
          
         echo json_encode(array(
            
            array(
                'title' => "Match de volley",
                'start' => "1396699200",
                'end' => "1396706400",
                'allDay' => false,
            ),
	
	));*/

?>
