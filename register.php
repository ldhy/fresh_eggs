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


if(isset($_POST['forminscription']))
{
  if(!empty($_POST['pseudo']) AND !empty($_POST['email']) AND !empty($_POST['emailconfirm']) AND !empty($_POST['password']) AND !empty($_POST['passwordconfirm']))
  {
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $email = htmlspecialchars($_POST['email']);
    $emailconfirm = htmlspecialchars($_POST['emailconfirm']);
    $password = ($_POST['password']);
    $passwordconfirm = ($_POST['passwordconfirm']);

    $pseudolength = strlen($pseudo);
    if($pseudolength <= 255)
    {
      if($email == $emailconfirm)
      {
          if($password == $passwordconfirm)
          {
            try
            {
            $insertmbr = $bdd->prepare('INSERT INTO users(pseudo, email, password) VALUES(:pseudo, :email, :password)');
            $insertmbr->execute(array(
              'pseudo' => $pseudo,
              'email' => $email,
              'password' => $password,
            ));
            $message = "Votre compte a bien été créé";
            }
            catch(PDOException $e)
            {
                    die('Erreur : '.$e->getMessage());
                    $bdd = null;
            }
          }
          else
          {
            $message = "Vos mots de passe de correspondent pas";
          }
      }
      else
      {
        $message = "Vos adresses email ne correspondent pas";
      }
    }
    else
    {
      $message = "Votre pseudo ne doit pas dépasser 255 caractères";
    }
  }
  else
  {
    $message = "Tous les champs doivent être complétés";
  }
}
?>


<h1>S'inscrire</h1>

<form action="" method="POST">
  <table>
    <tr>
      <td align="right">
        <label for="pseudo">Pseudo : </label>
      </td>
      <td>
        <input type="text" name="pseudo" />
      </td>
      </tr>
      <tr>
        <td align="right">
          <label for="email">Email : </label>
        </td>
        <td>
          <input type="email" name="email" />
        </td>
      </tr>
      <tr>
        <td align="right">
          <label for="emailconfirm">Confirmez votre email : </label>
        </td>
        <td>
          <input type="email" name="emailconfirm" />
        </td>
      </tr>
      <tr>
        <td align="right">
          <label for="password">Mot de passe : </label>
        </td>
        <td>
          <input type="password" name="password" />
        </td>
      </tr>
      <tr>
        <td>
          <label for="passwordconfirm">Confirmez votre mote de passe : </label>
        </td>
        <td>
          <input type="password" name="passwordconfirm" />
        </td>
      </tr>
    </table>
  <input type="submit" value="M'inscrire" name="forminscription"/>
</form>

<?php
  if(isset($message))
  {
    echo $message;
  }
?>
