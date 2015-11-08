<script type="text/javascript">
<!--
var ChangeImage = function ChangeImage(Url)
{
document.getElementById('affiche-image').innerHTML = '<img src="'+Url+'" />';
}
-->
</script>

<div class="conteneur-galerie-image">
<?php
$i=1;
$dbh= Database::connect();
$query = "SELECT * FROM `images` WHERE sport LIKE 'autre'";
$sth = $dbh->prepare($query);
$sth->setFetchMode(PDO::FETCH_ASSOC);
$sth->execute();  // on va chercher les images dans la bdd
echo '<div class="scrollbar" >';
echo '<ul class="miniature-galerie-image">';
//on boucle pour l'affichage des images
while ($image = $sth->fetch()) {
    $source = "images/upload/image".$image['id'].".jpg";

     if($i==1){
            // on affiche une seule fois la grande image
            $src="images/upload/image".$image['id'].".jpg";
     }
    
    echo '<li><img src="'.$source.'"  alt="image" onmouseover="ChangeImage(\''.$source.'\');"></li>';
    // on affiche la liste des miniatures
    $i++;
} 

echo '</ul>';
echo '</div>';
echo '<div class="droite-galerie-image"><div id="affiche-image"><img src="'.$src.'" alt="photo"/></div></div>';

?> 
</div>