
<form action='index.php?page=content/galerie/contenu_upload_img' method="post" enctype="multipart/form-data">
    <br><br>
    <input type="file" name="fichier" required=""/><br><br>
    Date (au format jj/mm/aaaa): <input type="date" name="date" required=""/><br><br>
    Sport: <select name="sport" required="">
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
        <option value="autre">Autre</option>
            </select>
        <br><br>    
    <input class="btn btn-sm btn-success" type='submit' action='Envoyer'/>
</form>

<?php
if (!empty($_FILES['fichier']['tmp_name'])&& is_uploaded_file($_FILES['fichier']['tmp_name'])){
    list($larg,$haut,$type,$attribut)=getimagesize($_FILES['fichier']['tmp_name']);
    if ($type==2){//image jpg->OK
        $dbh = Database::connect();
        
        $sport = mysql_real_escape_string($_POST['sport']);
        $date = mysql_real_escape_string($_POST['date']);
        $sth = $dbh->prepare("INSERT INTO Images(date, sport) VALUE(?,?)");
        $sth->execute(array($date,$sport));

        $id = $dbh->lastInsertId();
        $sourcenormal = "images/upload/image$id.jpg";
        if (move_uploaded_file($_FILES['fichier']['tmp_name'], $sourcenormal)){
            echo "copie réussie";

        }
    }

}

?>