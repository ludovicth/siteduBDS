<?php

function printLoginForm($askedpage){
    echo<<<FIN
    <form action="index.php?todo=login&page=$askedpage" method="POST">
        <input type="text" name="login" placeholder="login">
        <input type="password" name="mdp" placeholder="mot de passe">
        <input type="submit" value="login">
        <a href="index.php?&page=register">M'incrire!</a>
    </form>
FIN;
}

function printLogoutForm($askedpage){
    echo<<<FIN
    <a href="index.php?todo=logout&page=$askedpage">Logout</a>
FIN;
}

?>