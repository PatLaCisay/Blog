<?php
/*/
 

Page de création des publications

Auteur = BARREAU Lucas

/*/
//Lancement de la session
session_start();
$refresh=false; //sert à rafraichir la page
$erreur=""; // sert à stocker les message d'erreur
$pseudo=$_SESSION['pseudo']; //stock le speudo de l'admin correspondant
$numero=0; //numéro de publication (s'incrémente pdt l'ajout d'une publication)

// Connexion à la base de données
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=bdd_blog;charset=utf8', 'root', '');
}
catch(Exception $e) // Gère une éventuelle erreur lors de l'ouverture de la BDD
{
        die('Erreur : '.$e->getMessage());
}
if (isset($_POST['Publier'])) //si le bouton Publier est enfoncé
{ 

	//on récupère les valeurs du formulaire
	$titre=htmlspecialchars($_POST["titre"]); //htmlspecialchars empêche user entrer HTML dans input
	$contenu=htmlspecialchars($_POST["contenu"]);

	
	if(!empty($_POST['contenu']) AND !empty($_POST['titre'])) //on vérifie que les champs sont remplis

	{
		$reqpost=$bdd->prepare("SELECT * FROM message WHERE titre=? AND contenu=? ");
		$reqpost-> execute(array($titre,$contenu));
		$postexist=$reqpost->rowCount(); //compte le nombre d'occurence de ce post dans la BDD

		$reqtitre=$bdd->prepare("SELECT titre FROM message WHERE titre=?");
		$reqtitre-> execute(array($titre));
		$titreexist=$reqtitre->rowCount(); //compte le nombre d'occurence de ce titre dans la BDD

		$reqcont=$bdd->prepare("SELECT contenu FROM message WHERE contenu=?");
		$reqcont-> execute(array($contenu));
		$contexist=$reqcont->rowCount(); //compte le nombre d'occurence de cette histoire dans la BDD		
		

		if($postexist>=1) //si vrai alors publi existe déjà 
		{ 
			$erreur="Ce post est déjà publié :(";

		}
		elseif($titreexist>=1)
		{
			$erreur="Ce titre est déjà utilisé :(";

		}
		elseif($contexist>=1)
		{
			$erreur="Cette histoire est déjà publiée :(";

		}
		else //on crée la publi
		{
			
			$addpost=$bdd->prepare("INSERT INTO message(pseudo,titre,contenu) VALUES(?,?,?)");
			$addpost->execute(array($pseudo,$titre,$contenu));
			$refresh=true; //donne l'ordre de revenir à la main page
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
	<title>Nouvelle publication - Les poissons c'est cool !</title>
	<link rel="stylesheet" href="style.css" />
</head>
<body>
	<h3><strong>Nouvelle publication</strong></h3>
	<form action="publication.php" method="post">
		<label>Titre de la publication :</label></br><input type="text" name="titre" placeholder="Titre de votre publication"></br>
		<label>Corps de la publication :</label> </br><textarea name="contenu" rows="8" cols="45">Corps de la publication...</textarea></br>
		
		<input type="submit" name="Publier">	

	</form>
</body>
</html>
<?php if($refresh)
{
	echo'<font color="green">Publication créée, vous allez être redirigé vers la page principale dans 5 secondes.</font><meta http-equiv="refresh" content="5;url=http://localhost/blog_si/main.php">';
}
echo '<label><font color="red">'. $erreur.'</font></label></br>'; 

?>