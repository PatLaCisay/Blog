/*/
Epreuve blog recrutement pôle SI JE

Ce fichier est le fichier principal du programme, c'est la page principale du programme.

Depuis cette dernière, on peut accéder à la création d'un compte et sa gestion si l'on est 
connecté.

On peut également y consulter l'ensemble des publications du blog et les commenter quand on
y est connecté.

En temps qu'administrateur pseudo : Lulu la Frite mdp : toto123
On peut créer des publications, en modifier et en supprimer.

L'ensemble de l'aspect graphique est très rudimentaire et mériterait plus de contenu.

Auteur = BARREAU Lucas

/*/
<?php

//Lancement de la session -> permet d'exploiter les variables SuperGlobales de SESSION
session_start();

$comm_compt=0; //sert à limiter le,nombre de comm affichés à 10

try //on essaie de voir si une session utilisateur est lancée
{
	if(!array_key_exists('admin', $_SESSION)) //si la clé admin n'a pas été créée
	{
		throw new Exception(""); // on envoie une exception 
	}else{
		$admin=$_SESSION['admin'];  //sinon on met à jour en fonction de l'user
	}
}
catch(Exception $e) // Attrape l'exception
{
        $admin=0; // initialise admin à 0<=>false en mySQL donc l'utilisateur ne peut pas créer de publications !
}

// Connexion à la base de données

try
{
	$bdd = new PDO('mysql:host=localhost;dbname=bdd_blog;charset=utf8', 'root', ''); //connexion en local
}
catch(Exception $e) // Gère une éventuelle erreur lors de l'ouverture de la BDD
{
        die('Erreur : '.$e->getMessage());
}

?>


<!DOCTYPE html>
<html>
	<div= id="background">
		<head>
			<link rel="stylesheet" href="style.css" />
			<meta charset="utf-8">
			<title>Les poissons c'est cool !</title>

		</head>
		<header class="main_head">
			<nav id="titre">
			<h1><strong>Les poissons c'est cool !</strong></h1>
			<ul>
			<?php
			// ici on contrôle les liens auxquels a accès l'user
				if(intval($admin)==1) //s'il est admin il a alors accès aux lien de création et de gestion des publis
				{
					echo "<a href='http://localhost/blog_si/publication.php'>Créer une publication</a><a href='http://localhost/blog_si/profil.php'>  Mode gestion</a></br></br>"; 
				}			
				if(!empty($_SESSION['pseudo'])) //si un pseudo est enregistré dans la session user
				{
					echo '<li><a href="http://localhost/blog_si/profil.php">'.$_SESSION['pseudo'].'</a></li><li><a href="http://localhost/blog_si/deconnexion.php">Déconnexion</a></li>'; //on affiche le lien vers le profil et la deconnexion
				}
				else //sinon on propose de créer un compte
				{
					echo '<li><a href="http://localhost/blog_si/connexion.php">Connexion</a></li><li><a href="http://localhost/blog_si/inscription.php">Créer un compte</a></li>';
				}
				

			?>
			</ul>	
			</nav>
		</header>
		<div id="espace"></div>
		<body>
			<div class="conteneur_central">
			<?php

			//AFFICHAGE DES PUBLICATIONS


				//on récupère dans un array toutes les données de la table sous forme d'un dictionnaire classé par ID de post décroissant
				$histoire = $bdd->query('SELECT * FROM message ORDER BY id_message DESC'); 

				while($element=$histoire->fetch()) //tant qu'on peut récupérer un élément de $histoire
				{
					$commentaire=$bdd->prepare('SELECT * FROM commentaire WHERE id_message=? ORDER BY id_commentaire DESC '); //prend tous les commentaires et les classe par ordre décroissant 
					$commentaire->execute(array($element['id_message']));
					$_SESSION['id_message']=$element['id_message']; //idientifie l'id du message

					//créer une zone de texte où est écrit l'histoire
					echo "<div id='conteneur_publi'></br><article><h2><strong>".$element['titre']."</h2></strong></br><textarea readonly name='contenu' rows='12' cols='100'>".$element['contenu']."</textarea></br><label>Auteur : </label>".$element['pseudo']."</br></br></article><div id='conteneur_commentaires'><h3><U>Espace commentaire :</U></h3><p>"; //affiche les histoires de pêche
					//même principe pour les commentaires associés aux publications
					while($comm=$commentaire->fetch() AND $comm_compt<10)	
					{	
						$comm_compt+=1 ;
						if(intval($element['id_message'])==intval($comm['id_message']))
						{
							echo "<strong>".$comm['pseudo_comm']." : </strong>".$comm['comm']."</br>";
						}

					}
					$comm_compt=0; //réinitialisation du compteur pour les prochains posts
					echo "</br></p><em><a href='commentaire.php?message=".$element['id_message']."'>Commenter la publication</a></em></br></div></div><div  id='miniespace'></div>"; //envoie l'id du message correspondant pour que le futur commentaire lui soit bien associé
					//on réinitialise comm
					$comm=array('');
				}
			?>
			</div>
		</body>	 
	</div>
</html>

