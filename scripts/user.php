<?php

/**
 * Description of user
 * Regroupe les fonctions qui ont trait à la table Utilisateur
 * 
 * @ Aude Durand & Ludovic Thea
 */
class User {
    public $login;
    public $mail;
    public $mdp;
    public $nom;
    public $prenom;
    public $promo;
    public $section;
    public $estCapitaine;
    public $estRespoSport;
    
    //_toString sert à l'affichage
    public function __toString() {
        return "[".$this->login."] ".$this->prenom." ".$this->nom;
    }
    
    public static function getUtilisateur($mail){
        require_once('utilsBD.php');
        $dbh = Database::connect();
        $requete = "SELECT * FROM Users WHERE mail = ?";
        $sth = $dbh->prepare($requete);
        $sth->setFetchMode(PDO::FETCH_CLASS,'User');
        $sth->execute(array($mail));
        $reponse = null;
        if ($sth->rowCount()>0){
            $reponse = $sth->fetch();
        }
        $sth->closeCursor();
        $dbh = null;
        return $reponse;
    }
    
    // insère un utilisateur dans la base de données. Par défaut, il n'est ni capitaine ni respo sport
    
    public static function insererUtilisateur($login,$mdp,$prenom,$nom,$promo,$section,$estCapitaine = 'non',$estRespoSport = 'non'){
        require_once('utilsBD.php');
        
        $dbh = Database::connect();
        if (User::getUtilisateur($login)==NULL){
            $query = "INSERT INTO Users(mail,mdp,prenom,nom,promo,section,estCapitaine,estRespoSport) VALUES (?,SHA1(?),?,?,?,?,?,?)";
            $sth = $dbh->prepare($query);
            $sth->execute(array($login."@polytechnique.edu",$mdp,$prenom,$nom,$promo,$section,$estCapitaine,$estRespoSport));
            return ($sth->rowCount()>0);
        }
        else{
            return false;
        }
    }
    
    public function testerMDP($mdp){
        return $this->mdp == sha1($mdp);
    }
    
    public function updateMDP($mdp,$mail){
        $dbh = Database::connect();
        $sth = $dbh->prepare("UPDATE Users SET mdp=sha1(?) WHERE mail=?");
        $sth->execute(array($mdp,$mail));
    }
    
    function genererMDP ($longueur){
    // initialiser la variable $mdp
    $mdp = "";
 
    // Définir tout les caractères possibles dans le mot de passe,
    // Il est possible de rajouter des voyelles ou bien des caractères spéciaux
    $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";
 
    // obtenir le nombre de caractères dans la chaîne précédente
    // cette valeur sera utilisé plus tard
    $longueurMax = strlen($possible);
 
    if ($longueur > $longueurMax) {
        $longueur = $longueurMax;
    }
 
    // initialiser le compteur
    $i = 0;
 
    // ajouter un caractère aléatoire à $mdp jusqu'à ce que $longueur soit atteint
    while ($i < $longueur) {
        // prendre un caractère aléatoire
        $caractere = substr($possible, mt_rand(0, $longueurMax-1), 1);
 
        // vérifier si le caractère est déjà utilisé dans $mdp
        if (!strstr($mdp, $caractere)) {
            // Si non, ajouter le caractère à $mdp et augmenter le compteur
            $mdp .= $caractere;
            $i++;
        }
    }
 
    // retourner le résultat final
    return $mdp;
}

}
