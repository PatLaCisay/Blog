<?php
/*/

Page de connexion, ici l'utilisateur peut se connecter à son compte, les données du formulaire
de connexion sont POST(ées) directement dans la page


Auteur = BARREAU Lucas

/*/



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

if (isset($_POST['Valider'])) //si le bouton Valider est enfoncé
{ 

	//on récupère les valeurs du formulaire
	$pseudoconnect=htmlspecialchars($_POST["pseudoconnect"]); //htmlspecialchars empêche user entrer HTML dans input
	$mdpconnect=htmlspecialchars($_POST["mdpconnect"]);

	
	if(!empty($pseudoconnect) AND !empty($mdpconnect)) //on vérifie que les identifiants sont non-vides

	{
		$reqprofil=$bdd->prepare("SELECT * FROM profil WHERE pseudo=? AND mdp=?");
		$reqprofil-> execute(array($pseudoconnect,$mdpconnect));
		$profilexist=$reqprofil->rowCount(); //compte le nombre d'occurence de ce profil dans la BDD

		if($profilexist==1){
			echo '<p><font color="green">Ok !</font></p>';
			$infoprofil=$reqprofil->fetch(); //on stock les infos de l'user dans un Array
			$_SESSION['id']=$infoprofil["id"]; //on modifie les données de session de l'user
			$_SESSION['pseudo']=$infoprofil['pseudo'];
			$_SESSION['mdp']=$infoprofil['mdp'];
			$_SESSION['admin']=$infoprofil['admin'];
			header("Location: profil.php"); //on envoie vers la page de profil de l'user

		}
		else
		{
			$erreur="Utilisateur ou mot de passe incorrect(s).";
			echo "<p>Etes-vous sûr d'avoir un compte sur le site ?</p></br><a href='http://localhost/blog_si/inscription.php'>Créer un compte.</a>";   
			
		}
	}
	else
	{
		$erreur="Remplissez tous les champs svp.";
		echo "<p>Etes-vous sûr d'avoir un compte sur le site ?</p></br><a href='http://localhost/blog_si/inscription.php'>Créer un compte.</a>"; 
	}
}

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Connectez-vous - Les poissons c'est cool</title>
	<h2><strong>Connexion</strong></h2>
	<link rel="stylesheet" href="style.css" />
</head>
<body>
	<form action="connexion.php" method="post">
		<label>Pseudo : </label><input type="text" name="pseudoconnect" placeholder="Pseudo"> </br>
		<label>Mot de passe : </label><input type="password" name="mdpconnect" placeholder="Mot de passe"> </br>
		<input type="submit" name= "Valider">
	</form>
</body>
<?php 
echo '<label><font color="red">'. $erreur.'</font></label></br>'; 
?>
</html>