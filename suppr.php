<?php session_start();

// Connexion à la base de données
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=bdd_blog;charset=utf8', 'root', '');
}
catch(Exception $e) // Gère une éventuelle erreur lors de l'ouverture de la BDD
{
        die('Erreur : '.$e->getMessage());
}

$id=$_POST['id'];

$delpost=$bdd->prepare("DELETE FROM message WHERE id_message=?");
$delpost->execute((array($id)));
header("Location:profil.php");

?>