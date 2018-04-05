<?php
session_start();
//if $_SESSION['id'] == $reqrecipes['id'];
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=fresheggs;charset=utf8', 'root', 'simplonco');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


if(isset($_POST['formdelete']))
{
    $delete_id = htmlspecialchars($_GET['id']);
    $delete = $bdd->prepare('DELETE FROM recipes WHERE id = :id');
    $delete->execute(array(
      'id' => $delete_id
    ));
    $message = "La recette a bien été supprimée";
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

      <h1>Supprimer la recette</h1>

      <form action="" method="post">
          <input type="submit" value="Supprimer la recette" name="formdelete"/>
      </form></br>

<?php
if(isset($message))
{
  echo $message;
}
?>

      <p><a href="add.php">Partager une recette</a></p>

    </body>
</html>
