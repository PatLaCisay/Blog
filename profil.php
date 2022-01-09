<?php

/*/

Page d'affichage et gestion du profil. Cette page permet à l'utilisateur de modifier son
mot de passe. Cependant, la gestion du nouveau mot de passe ne fonctionne pas très bien.
En fait, j'ai un problème avec les boutons submit des formulaires.
Pour envoyer le nouveau mot de passe il faut appuyer sur envoyer les nouvelles infos.

Auteur = BARREAU Lucas
/*/
//Lancement de la session

session_start();
$admin=false; //permet d'accéder à la gestion des posts
$modif=false; //permet de lancer la procédure de modification profil
$modif_valid=false; //valide la modification après test du mdp
$erreur="";
// Connexion à la base de données
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=bdd_blog;charset=utf8', 'root', '');
}
catch(Exception $e) // Gère une éventuelle erreur lors de l'ouverture de la BDD
{
        die('Erreur : '.$e->getMessage());
}

//Appel des données de la table message
$reqpost=$bdd->prepare("SELECT * FROM message");
$reqpost->execute();
$liste_titre=array();
$compteur=0;

while($element=$reqpost->fetch())			
{
	$liste_titre[$compteur]=$element['titre'];
	$compteur+=1;
		
}

				


if(intval($_SESSION["admin"])==1)
{
	echo "<h3><font color='white'><strong> Vous êtes connecté en tant qu'administrateur. </strong></font></h3></br>";
	$admin=true;
}
try //on essaie de voir si une session utilisateur est lancée
{
	if(!array_key_exists('Confirmer', $_POST)) //si la clé confirmer n'a pas été créée
	{
		throw new Exception(""); // on envoie une exception 
	}elseif ((array_key_exists('Confirmer', $_POST))AND !empty($_POST['mdp_test']) AND $_POST['mdp_test']==$_SESSION['mdp'] ) {
		$modif=true;  //on met a jour en fonction de l'user
		$_SESSION['modif']=$modif;
		$erreur="Remplissez correctement le formulaire.";
	}
}
catch(Exception $e)
{
	$modif=false;
}

try //on essaie de voir si une session utilisateur est lancée
{
	if(!array_key_exists('modif', $_SESSION)) //si la clé modif n'a pas été créée
	{
		throw new Exception(""); // on envoie une exception 
	}else{
		//on continue le programme
	}
}
catch(Exception $e)
{
	$_SESSION['modif']=false;
}
try //on essaie de voir si une session utilisateur est lancée
{
	if(!array_key_exists('new_mdp', $_POST)) //si la clé modif n'a pas été créée
	{
		throw new Exception(""); // on envoie une exception 
	}else{
		$_SESSION['new_mdp']=$_POST['new_mdp'];
	}
}
catch(Exception $e)
{

}


?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Profil - Les poissons c'est cool</title>
	<h1><strong>Profil de <?php echo $_SESSION['pseudo']?></strong></h1>
	<link rel="stylesheet" href="style.css" />
</head>
<body>

	<?php if ($admin)
	{ ?>
		<h2>Modifier ou supprimer une publication</h2>

		<form action="modifier.php" method="post">
			<input list="titre-choice" id="titre" name="titre" />
				<datalist id="titre-choice">
				<?php
					foreach ($liste_titre as $value) 
					{
						echo "<option value=".$value."></br>";
					}
				?>
				</datalist>
			<input type="submit" name="ok" value="Modifier / Supprimer">
		</form>

	<?php }
	?>
		<h2>Modifier mon profil</h2>
		
		<form action="profil.php" method="post">
			<label>Rentrez votre mot de passe : </label><input type="password" name="mdp_test">
			<input type="submit" name="Confirmer" value="Confirmer">
		</form>
		<?php if ($modif OR $_SESSION['modif'])
		{?>		
			<form action="profil.php" method="post">
				<label>Nouveau mot de passe : </label><input type="text" name="new_mdp" placeholder="Mot de passe"> </br>
				<label>Confirmer le mot de passe : </label><input type="text" name="new_mdp2" placeholder="Confirmer"> </br>
				<?php if(empty($_SESSION["POST"])OR array_key_exists('new_mdp', $_POST)){?><input type="submit" name="Envoyer" value='Confirmer'><?php }?>
				
			</form>	
				<?php
			try{
				if(array_key_exists('Envoyer', $_POST)){
					if($_POST['Envoyer']){

						 if(isset($_POST['new_mdp'])AND isset($_POST['new_mdp2']))
						{
							if($_POST['new_mdp']==$_POST['new_mdp2'])
							{
								echo '<form action="modifier_profil.php" method="post"><input type="hidden" value='.$_SESSION['pseudo'].'><input type="hidden" value='.$_SESSION['new_mdp'].'><input type="submit" name="Envoyer2" value="Envoyer les nouvelles informations	"></form>';		 
							}
							else
							{
								$erreur="Mots de passe différents.";
							}
						}
						else
						{
							$erreur="Remplissez les champs.";
						}
						
					}
				}else{
					throw new Exception("");
				}
			}catch(Exception $exept){
				//poursuivre programme

			}?>
			

	<?php }

	?>	
		<form action="modifier_profil.php" method="post">
			<label>Se connecter en tant qu'admin : </label><input type="password" name="admin" >
			<input type="submit" name="ok" value="ok">
		</form>
</body>
</html>
<?php echo "<a href='http://localhost/blog_si/main.php'>Se rendre sur le site.</a>"; 
$value=array(); //reinitiailsation de la liste
echo '<label><font color="red">'. $erreur.'</font></label></br>'; 
?>