<h2>Galerie</h2>
<?php
if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) echo '<a href="index.php?page=content/galerie/contenu_upload_img" class="btn btn-lg btn-warning" style="float:right">Partagez vos photos!</a>';
?>
<div id="gallery">
        <a href='index.php?page=content/galerie/galerie_aviron'><img src="images/aviron.png" alt="aviron" height="84" width="102" /> </a>
        <a href='index.php?page=content/galerie/galerie_badminton'><img src="images/badminton.png" alt="badminton" height="84" width="102" /> </a>
        <a href='index.php?page=content/galerie/galerie_basket'><img src="images/basket.png" alt="basket" height="84" width="102" /> </a>
        <a href='index.php?page=content/galerie/galerie_boxe'><img src="images/boxe.png" alt="boxe" height="84" width="102" /> </a>
        <a href='index.php?page=content/galerie/galerie_equitation'><img src="images/equitation.png" alt="equitation" height="84" width="102" /> </a>
        <a href='index.php?page=content/galerie/galerie_escalade'><img src="images/escalade.png" alt="escalade" height="84" width="102" /> </a>
        <a href='index.php?page=content/galerie/galerie_escrime'><img src="images/escrime.png" alt="escrime" height="84" width="102" /> </a>
        <a href='index.php?page=content/galerie/galerie_foot'><img src="images/foot.png" alt="foot" height="84" width="102" /> </a>
        <a href='index.php?page=content/galerie/galerie_hand'><img src="images/hand.png" alt="hand" height="84" width="102" /> </a>
        <a href='index.php?page=content/galerie/galerie_judo'><img src="images/judo.png" alt="judo" height="84" width="102" /> </a>
        <a href='index.php?page=content/galerie/galerie_natation'><img src="images/natation.png" alt="natation" height="84" width="102" /> </a>
        <a href='index.php?page=content/galerie/galerie_raid'><img src="images/raid.png" alt="raid" height="84" width="102" /> </a>
        <a href='index.php?page=content/galerie/galerie_rugby'><img src="images/rugby.png" alt="rugby" height="84" width="102" /> </a>
        <a href='index.php?page=content/galerie/galerie_tennis'><img src="images/tennis.png" alt="tennis" height="84" width="102" /> </a>
        <a href='index.php?page=content/galerie/galerie_volley'><img src="images/volley.png" alt="volley" height="84" width="102" /> </a>
        <a href='index.php?page=content/galerie/galerie_autre'><img src="images/autre.png" alt="autre" height="84" width="102" /> </a>
</div>