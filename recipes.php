<?php
session_start();

try
{
	$bdd = new PDO('mysql:host=localhost;dbname=fresh_eggs;charset=utf8', 'root', 'simplonco');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


if(isset($_GET['update']) AND !empty($_GET['update']))
{
	$update_id = htmlspecialchars($_GET['update']);
	$update_recipes = $bdd->prepare('SELECT * FROM recipes WHERE id = ?');
	$update_recipes->execute(array($update_id));

	if($update_recipes->rowCount() == 1)
	{
		$update_recipes = $update_recipes->fetch();

	}
	else
	{
		die("La recette n'existe pas");
	}
}
/*
if(isset($_POST['formupdate']))
{
	header('location: update.php');
}
*/

?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Fresh Eggs</title>
    </head>

    <body>

      <h1>Fresh Eggs</h1>
      <h2>Mes oeufs sont-ils frais, archi frais ?</h2>

<?php
		$recipes = $bdd->query('SELECT * FROM recipes');
		while ($reqrecipes = $recipes->fetch())
		{
?>

			 <h1><?php echo $reqrecipes['title']; ?></h1>
			 <p><?php echo $reqrecipes['content']; ?><p>
			 <p>
			 		<a href="update.php?id=<?= $reqrecipes['id'] ?>">Modifier</a>
					<a href="delete.php?id=<?= $reqrecipes['id'] ?>">Supprimer</a>
			 </p>


<?php
			}
?>

      <p><a href="add.php">Partager une recette</a></p>

    </body>
</html>
