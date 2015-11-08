<?php
    session_name("nom_de_session");
    session_start();
?>
<?php 
    require("scripts/utils.php");
    require("scripts/printForms.php");
    require("scripts/logInOut.php");
    require("scripts/user.php");
    require("scripts/utilsBD.php");
?>
<?php
    if (array_key_exists('page',$_GET) && isset($_GET['page'])){
        $askedPage = $_GET['page'];
    }
    else {
        $askedPage = "accueil";        
    }
    $authorized = checkPage($askedPage);
    $titrePage = getPageTitle($askedPage);
?>
<?php
        generateHTMLHeader($titrePage);
?>

    <div class="container">

      <div class="masthead">
        <?php
        if(!isset($_SESSION['loggedIn'])||(!$_SESSION['loggedIn'])) echo '<a href="index.php?page=content/contenu_connexion" class="btn btn-lg btn-warning" style="float:right">Connexion</a>';
        if(!isset($_SESSION['loggedIn'])||(!$_SESSION['loggedIn'])) echo '<a href="index.php?page=content/contenu_register" class="btn btn-lg btn-warning" style="float:right ; margin-right: 15px">Inscription</a>';
        if(isset($_SESSION['loggedIn'])&&($_SESSION['loggedIn'])) echo '<a href="index.php?page=content/contenu_logout" class="btn btn-lg btn-warning" style="float:right">Déconnexion</a>';
        if(isset($_SESSION['loggedIn'])&&($_SESSION['loggedIn'])) echo '<a href="index.php?page=content/contenu_mon_compte" class="btn btn-lg btn-warning" style="float:right ; margin-right: 15px">Mon compte</a>';
        ?>
        
        <!--<h3 class="text-muted">Bureau des Sports de l'Ecole Polytechnique</h3>-->
        <img src="images/logo-BDS-sous-titre-petit.png" alt="Bureau des Sports de l'Ecole Polytechnique" width="60%">
        <br>
        <ul class="nav nav-justified">
            <?php
                generateMenu($askedPage);
        ?>
        </ul>
        </div>
        <div id="centre">
            <div id="content">
                <?php 
                        if (!$authorized) {
                            echo "<br>Cette page n'existe pas ou ne vous est pas accessible.";
                        }
                        else {
                            require("$askedPage.php");}
                ?>
            </div>
        
            
       
        </div>
        <footer class='footer'>
            <p>© Les loulous du modal web</p>
        </footer>

<?php 
    generateHTMLFooter();
?>
