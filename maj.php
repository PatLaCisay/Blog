<?php session_start();

// Connexion à la base de données
//Auteur = BARREAU Lucas
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=bdd_blog;charset=utf8', 'root', '');
}
catch(Exception $e) // Gère une éventuelle erreur lors de l'ouverture de la BDD
{
        die('Erreur : '.$e->getMessage());
}

$id=$_POST['id'];
$contenu=$_POST['contenu'];

$setpost=$bdd->prepare("UPDATE message SET contenu=? WHERE id_message=?");
$setpost->execute((array($contenu,$id)));
header("Location:main.php");

?>