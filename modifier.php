<?php

//Lancement de la session
//Auteur = BARREAU Lucas
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
try //on essaie de voir si une session utilisateur est lancée
{
	if(!array_key_exists('titre', $_POST)) //si la clé admin n'a pas été créée
	{
		throw new Exception(""); // on envoie une exception 
	}else{
		$message_correspondant=$_POST['titre'];  //on met a jour en fonction du titre
	}
}
catch(Exception $e) // Attrape l'exception
{
 //continuer le code
}
//recuperation du message
$reqpost=$bdd->prepare('SELECT * FROM message WHERE titre = ? ');
$reqpost->execute(array($message_correspondant));
$element=$reqpost->fetch(); 
$titre=$element['titre'];
$id_message=$element['id_message'];
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="style.css" />
	<title>Gestion des messages - Les poissons c'est cool</title>
</head>
<body>
	<form action="maj.php" method="post">
		<label>Titre : <?php echo $titre;?></label></br>
		<textarea name='contenu' rows='12' cols='100'>
<?php echo $element['contenu']; ?>
		</textarea></br>
		<input type="hidden" name="id" value=<?php echo $id_message; ?> >		
		<input type="submit" name="Modifier" value="Modifier">	
	</form>

	<form action="suppr.php" method="post" >
		<input type="hidden" name="id" value=<?php echo $id_message; ?> >
		<input type="submit" value="Supprimer">
	</form>
</body>
</html>
