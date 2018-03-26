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

if(isset($_GET['id']) AND $_GET['id'] > 0 )
{
  $getid = intval($_GET['id']); /* vérifie que id est un nombre */
  $requser = $bdd->prepare('SELECT * FROM users WHERE id = :id');
  $requser->execute(array(
    'id' => $getid
  ));
  $userinfo = $requser->fetch();
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
      <h2>Mes oeufs sont-ils frais, archi frais ?</h2>

      <h1>Bienvenue <?php echo $userinfo['pseudo']; ?></h1>
      <p><a href="recipes.php">Voir les recettes</a></p>
      <p><a href="add.php">Partager une recette</a></p>

    </body>
</html>
