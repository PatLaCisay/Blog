<?php

//Auteur = BARREAU Lucas
//Lancemnt de la session


session_start();

// Connexion à la base de données
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=bdd_blog;charset=utf8', 'root', '');
}
catch(Exception $e) // Gère une éventuelle erreur lors de l'ouverture de la BDD
{
        die('Erreur : '.$e->getMessage());
}

//Initialisation des variables de connexion

$erreur=""; // initialisation d'une variable qui affiche les erreurs à l'écran
$refresh=false; // valide ou non le rafraichissement de la page

if (isset($_POST['Confirmer'])) //si le bouton Valider est enfoncé
{ 

	//on récupère les valeurs du formulaire
	$pseudo=htmlspecialchars($_POST["pseudo"]); //htmlspecialchars empêche user entrer HTML dans input
	$mdp=htmlspecialchars($_POST["mdp"]);
	$mdp2=htmlspecialchars($_POST["mdp2"]);

	
	if(!empty($_POST['pseudo'])AND !empty($_POST['mdp'])AND !empty($_POST['mdp2'])) //on vérifie que les champs sont remplis

	{
		$reqprofil=$bdd->prepare("SELECT pseudo FROM profil WHERE pseudo=? ");
		$reqprofil-> execute(array($pseudo));
		$profilexist=$reqprofil->rowCount(); //compte le nombre d'occurence de ce profil dans la BDD

		if($profilexist>=1) //si vrai alors compte existe déjà 
		{ 
			$erreur="Ce pseudo est déjà utilisé :(";

		}
		else //on créer le compte
		{
		 	if($mdp2==$mdp)
		 	{
				
				$addprofil=$bdd->prepare("INSERT INTO profil(pseudo,mdp,admin) VALUES(?,?,?)");
				$addprofil->execute(array($pseudo,$mdp,0));
				$refresh=true;

			}
			else
			{
				$erreur="Les mots de passe sont différents.";
			}	
		}
	}
	else
	{
		$erreur="Remplissez tous les champs svp.";
	}

}
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Inscription - Les poissons c'est cool</title>
	<h2><strong>Inscription</strong></h2>
	<link rel="stylesheet" href="style.css" />
</head>
<body>
	<form action="inscription.php" method="post">
		<label>Pseudo : </label><input type="text" name="pseudo" placeholder="Pseudo"> </br>
		<label>Mot de passe : </label><input type="password" name="mdp" placeholder="Mot de passe"> </br>
		<label>Confirmer le mot de passe : </label><input type="password" name="mdp2" placeholder="Confirmer"> </br>
		<input type="submit" name= "Confirmer">
	</form>
</body>
<?php 
echo '<label><font color="red">'. $erreur.'</font></label></br>'; 

if($refresh)
{
	echo'<font color="green">Compte créé, vous allez être redirigé vers la page de connexion dans 5 secondes.</font><meta http-equiv="refresh" content="5;url=http://localhost/blog_si/connexion.php">';
}


?>
</html>