<?php session_start();

/*/

Page invisible qui sert a ubdate le mot de passe

//Auteur = BARREAU Lucas

/*/

// Connexion à la base de données
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=bdd_blog;charset=utf8', 'root', '');
}
catch(Exception $e) // Gère une éventuelle erreur lors de l'ouverture de la BDD
{
        die('Erreur : '.$e->getMessage());
}


try //on essaie de voir si une session utilisateur est lancée
{
	if(!array_key_exists('admin', $_POST)) //si la clé modif n'a pas été créée
	{
		throw new Exception(""); // on envoie une exception 
	}else{
		if($_POST['admin']=="toto123"){
			$admin=1;	
		}else{
			$admin=0;
		}
		
	}
}
catch(Exception $e)
{
	$admin=0;
}
$pseudo=$_SESSION['pseudo']; //recupère le pseudo de l'user de la session,
$new_mdp=$_SESSION['new_mdp']; //le nouveau mdp
$setprofil=$bdd->prepare("UPDATE profil SET mdp=? AND admin=? WHERE pseudo=?"); 
$setprofil->execute((array($new_mdp,$admin,$pseudo))); //modifie le mdp dans la BDD
$_SESSION['mdp']=$new_mdp; //modifie le mdp de session
$_SESSION['modif']=false; //permet de cacher le formulaire de création de nouveau mdp
$_SESSION['admin']=$admin;
header("Location:profil.php"); //renvoie au profil

?>