<?php

if(isset($_POST['formdisplay']))
{
if(isset($_POST['$id_recette']) AND !empty($_GET['id']))
{
$update_id = htmlspecialchars($_POST['$id_recette']);
$update_recipes = $bdd->prepare('SELECT * FROM recipes WHERE id = ?');
$update_recipes->execute(array($update_id));
}

if($update_recipes->rowCount() == 1)
{
  $update_recipes = $update_recipes->fetch();
  echo $update_recipes['title'];
}
else
{
  die("La recette n'existe pas");
}
}


?>
