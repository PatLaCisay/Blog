<?php

//Auteur = BARREAU Lucas
//Lancement de la session
session_start();
$_SESSION=array(); //on s'assure que toutes les données de la session sont effacées
session_destroy(); //detruit la session
header("Location: main.php");
?>