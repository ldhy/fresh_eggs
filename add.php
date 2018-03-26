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


if(isset($_POST['formaddrecipes']))
{
  if(!empty($_POST['title']) AND !empty($_POST['content']))
  {
    $title = htmlspecialchars($_POST['title']);
    $content = htmlspecialchars($_POST['content']);

    $titlelength = strlen($title);
    if($titlelength <= 255)
    {
        $insertrecipes = $bdd->prepare('INSERT INTO recipes(title, content) VALUES(:title, :content)');
        $insertrecipes->execute(array(
            'title' => $title,
            'content' => $content,
            ));
        $message = "Votre recette a bien été ajoutée";
    }
		else
		{
			$message = "Votre titre ne doit pas contenir plus de 255 caractères";
		}
  }
	else
	{
		$message = "Veuillez compléter tous les champs";
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

      <h1>Partager une recette</h1>
      <form action="" method="post">
        <table>
          <tr>
            <td>
              <input type="text" placeholder="Titre de votre recette" name="title" />
            </td>
          </tr>
          <tr>
            <td>
              <textarea type="text" placeholder="Tapez votre recette" rows="16" cols="45" name="content" /></textarea>
            </td>
          </tr>
        </table>
					<input type="hidden" name="user_id"/>
          <input type="submit" value="partager" name="formaddrecipes"/>
      </form></br>
<?php
	if(isset($message))
	{
		echo $message;
	}
?>
			<p><a href="recipes.php">Voir les recettes</a></p>


    </body>
</html>
