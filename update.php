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

if(isset($_GET['id']) AND !empty($_GET['id']))
{
	$update_id = htmlspecialchars($_GET['id']);
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

if(isset($_POST['formupdate']))
{
  if(!empty($_POST['title']) AND !empty($_POST['content']))
  {
    $update_id = htmlspecialchars($_GET['id']);
    $update_title = htmlspecialchars($_POST['title']);
    $update_content = htmlspecialchars($_POST['content']);
    $update = $bdd->prepare('UPDATE recipes SET id = :id, title = :title, content = :content WHERE id = :id');
    $update->execute(array(
      'id' => $update_id,
      'title' => $update_title,
      'content' => $update_content
    ));
    $message = "La recette a bien été modifiée";
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
      <h2>Mes oeufs sont-ils frais, archi frais ?</h2>

      <h1>Modifier la recette</h1>

      <form action="" method="post">
        <table>
          <tr>
            <td>
              <input type="text" value="<?php echo $update_recipes['title']; ?>" name="title" />
            </td>
          </tr>
          <tr>
            <td>
              <input type="text" value="<?php echo $update_recipes['content']; ?>" rows="16" cols="45" name="content" /></textarea>
            </td>
          </tr>
        </table>
          <input type="submit" value="Modifier la recette" name="formupdate"/>
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
