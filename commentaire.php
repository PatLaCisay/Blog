<?php
//Lancemnt de la session

session_start();
try //on essaie de voir si une session utilisateur est lancée
{
	if(array_key_exists('pseudo', $_SESSION)) //si la clé pseudo n'a pas été créée
	{
		$pseudo=$_SESSION['pseudo'];
		
	}else{
		throw new Exception(""); // on envoie une exception  
	}
}
catch(Exception $e) // Attrape l'exception
{
 	header('Location:connexion.php'); //invite l'user à se conneceter
}

try //on essaie de voir si on a reçu la clé id_message
{
	if(!array_key_exists('message', $_GET)) //si la clé id_message n'est pas reçue
	{
		throw new Exception(""); // on envoie une exception 
	}else{
		$_SESSION['message']=$_GET['message'];  //on met a jour en fonction de ce qu'on a reçu
	}
}
catch(Exception $e) // Attrape l'exception
{
	//on continue le programme	
}

$message=$_SESSION['message'];
$erreur="";
$refresh=false;

// Connexion à la base de données
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=bdd_blog;charset=utf8', 'root', '');
}
catch(Exception $e) // Gère une éventuelle erreur lors de l'ouverture de la BDD
{
        die('Erreur : '.$e->getMessage());
}

//on récupère dans un array les infos du message
$disppost=$bdd->prepare("SELECT * FROM message WHERE id_message=?");
$disppost-> execute(array($message));
$element=$disppost->fetch();
if (isset($_POST['Publier'])) //si le bouton Publier est enfoncé
{ 

	//on récupère les valeurs du formulaire
	$contenu=htmlspecialchars($_POST["comm"]);

	echo $contenu;

	
	if(!empty($_POST['comm'])) //on vérifie que le champ est rempli

	{

		$reqcomm=$bdd->prepare("SELECT comm FROM commentaire WHERE contenu=?");
		$reqcomm-> execute(array($contenu));
		$commexist=$reqcomm->rowCount(); //compte le nombre d'occurence de ce commentaire dans la BDD		
		

		if($commexist>=2) //si vrai alors commentaire spam 
		{ 
			$erreur="Commentaire déjà dit 2 fois, halte au spam !";

		}
		else //on crée le commentaire
		{
			
			$addcomm=$bdd->prepare("INSERT INTO `bdd_blog`.`commentaire` (`id_commentaire`, `id_message`, `pseudo_comm`, `comm`) VALUES (?,?,?,?)");
			$addcomm->execute (array(null,$message,$pseudo,$contenu));
			$refresh=true; //donne l'ordre de revenir à la main page
		}
	}
	else
	{
		$erreur="Remplissez le champ svp.";
	}

}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Nouveau commentaire - Les poissons c'est cool !</title>
	<link rel="stylesheet" href="style.css" />
</head>
<body>
	<h3><strong><?php echo $element['titre']; ?></strong></h3>

	<textarea readonly name="message" rows="12" cols="100"><?php echo $element['contenu'] ; ?></textarea></br>

	<form action="commentaire.php" method="post">
		<label>Votre commentaire :</label> </br><textarea name="comm" rows="8" cols="45">Entrez le ici</textarea></br>
		<input type="submit" name="Publier">	
		</form>
</body>
<?php 
echo '<label><font color="red">'. $erreur.'</font></label></br>'; 

if($refresh)
{
	echo'<font color="green">Commentaire créé, vous allez être redirigé vers la page de connexion dans 2 secondes.</font><meta http-equiv="refresh" content="2;url=http://localhost/blog_si/main.php">';
}


?>
</html>
