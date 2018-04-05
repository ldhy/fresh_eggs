<?php
session_start();

try
{
	$bdd = new PDO('mysql:host=localhost;dbname=fresheggs;charset=utf8', 'root', 'simplonco');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(isset($_POST['formconnection']))
{
  $emailconnect = htmlspecialchars($_POST['emailconnect']);
  $passwordconnect = ($_POST['passwordconnect']);
  if(!empty($emailconnect) AND !empty($passwordconnect))
  {
			$user = $bdd->prepare('SELECT * FROM users WHERE email = :email AND password = :password');
			$user->execute(array(
				'email' => $emailconnect,
				'password' => $passwordconnect));
			$userexist = $user->rowCount();
			if($userexist == 1)
			{
				$userinfo = $user->fetch();
				$_SESSION['id'] = $userinfo['id'];
				$_SESSION['pseudo'] = $userinfo['pseudo'];
				$_SESSION['email'] = $userinfo['email'];
				header('location: profil.php?id='. $_SESSION['id']);
			}
			else
			{
				$message = "Mauvais email ou mot de passe";
			}

  }
  else
  {
    	$message = "Tous les champs doivent être complétés";
  }
}
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Fresh Eggs</title>
    </head>

    <body>

      <h1>Fresh Eggs</h1>
      <h2>Mes oeufs sont-ils frais, archi-frais ?</h2>

      <form action="" method="post">
        <p>
          <input type="email" placeholder="votre email" name="emailconnect" />
          <input type="password" placeholder="votre mot de passe" name="passwordconnect"  />
          <input type="submit" value="ok" name="formconnection"/>
        </p>
      </form>
      <a href="register.php">S'inscrire</a>
			</br>

<?php
	if(isset($message))
		{
			echo $message;
		}
?>

      <h3>Je veux connaître :</h3>

      <h4>La date max en extra frais de mes oeufs :</h4>
        <form action="" method="post">
          <label>Je rentre la DCR de mes oeufs :</label>
          <input type="date" placeholder="jj/mm/aaaa" name="dcr" />
					<input type="submit" value="ok" name="formdcr">
        </form>
			</br>

<?php
	if(isset($_POST['formdcr']))
	{
			$dcr1 = $_POST['dcr'];

			$clutch1 = date('Y-m-d', strtotime($dcr1 . "- 27 days"));
			$extrafresh1 = date('Y-m-d', strtotime($dcr1 . "- 19 days"));
			$fresh = date('Y-m-d', strtotime($dcr1 . "- 18 days"));
			$deadline1 = date('Y-m-d', strtotime($dcr1));

			echo "Mes oeufs sont extra frais du " . date('d/m/Y', strtotime($clutch1)) . " au " . date('d/m/Y', strtotime($extrafresh1)) . '</br>';
			echo "Mes oeufs sont frais du " . date('d/m/Y', strtotime($fresh)) . " au " . date('d/m/Y', strtotime($deadline1)) . '</br>';
			echo "La date maximale de consommation de mes oeufs est le " . date('d/m/Y', strtotime($deadline1));

	}

	if(isset($_POST['formdcr']))
	{
			 $recettes = $bdd->query('SELECT * FROM recipes ORDER BY rand() LIMIT 1');
			 while ($reqrecipes = $recettes->fetch())
			 {
?>
				<h1><?php echo $reqrecipes['title']; ?></h1>
				<p><?php echo $reqrecipes['content']; ?><p>

				<form action="" method="post">
					<input type="submit" value="Voir la recette" name="formdisplay"/>
				</form>
<?php
			 }
	}
?>

      <h4>La DCR max à choisir pour des oeufs extra frais :</h4>
          <form action="" method="post">
            <label>Je rentre la date limite pour laquelle je veux des oeufs extra frais :</label>
            <input type="date" placeholder="jj/mm/aaa" name="extrafresh" />
						<input type="submit" value="ok" name="formextrafresh">
          </form>
			</br>

<?php
	if(isset($_POST['formextrafresh']))
	{
		$dcr2 = $_POST['extrafresh'];

		$extrafreshmax = date('Y-m-d', strtotime($dcr2 . "+ 19 days"));
		$fresh2 = date('Y-m-d', strtotime($dcr2 . "+ 1 day"));
		$clutch2 = date('Y-m-d',strtotime($dcr2 . "- 8 days"));
		$deadline2 = date('Y-m-d', strtotime($dcr2));

		echo "Je choisis une DCR maximale au " . date('d/m/Y', strtotime($extrafreshmax)) . '</br>';
		echo "Mes oeufs sont extra frais du " . date('d/m/Y', strtotime($clutch2)) . " au " . date('d/m/Y', strtotime($deadline2)) . " maximum" . '</br>';
		echo "Mes oeufs sont frais du " . date('d/m/Y', strtotime($fresh2)) . " au " . date('d/m/Y', strtotime($extrafreshmax)) .'</br>';
		echo "Mes oeufs ne sont plus consommables après le " . date('d/m/Y', strtotime($extrafreshmax));
	}
	if(isset($_POST['formextrafresh']))
	{
			 $recettes = $bdd->query('SELECT * FROM recipes ORDER BY rand() LIMIT 1');
			 while ($reqrecipes = $recettes->fetch())
			 {
?>
				<h1><?php echo $reqrecipes['title']; ?></h1>
				<p><?php echo $reqrecipes['content']; ?></p>
				<?php $id_recette = $reqrecipes['id']?>;

				<form action="recettesselectionnee.php" method="POST">
	         <input type="submit" value="Voir la recette" name="formdisplay"/>
	      </form>
<?php
			 }
	}


?>


    </body>
</html>
