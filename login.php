<?php
require_once "pdoConc.php";
session_start();
// session_destroy();
if (isset($_POST['Cancel'])){
  //Redirect the Browser to index.php
  header("Location: index.php");
  return;
}
$salt =  'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';  // Pw is php123

// $failure = false;//if we have no POST SDO_DAS_DataObject

//check.. if we have POST data then do the processing
date_default_timezone_set('Europe/Berlin');
if ( isset($_POST['email']) && isset($_POST['pass']) ){

      $sql = "SELECT name FROM users
          WHERE email = :em AND password = :pw";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
          ':em' => $_POST['email'],
          ':pw' => $_POST['pass']));
  $_SESSION['email'] = $_POST['email'];
  $_SESSION['pass'] =  $_POST['pass'];
    if ( strlen( $_POST['email'])< 1 || strlen( $_POST['pass']) < 1 ){
      $_SESSION['error'] = "email and Password are required";
      header("Location: login.php");
      return;
      // $failure = "email and Password are required";
    } else {
      $at = "@";
      $checkIfemail = strpos($_POST['email'],$at);
      if ($checkIfemail < 1 ){
        $_SESSION['error'] = "email must have an at-sign (@)";
        header("Location: login.php");
        return;
        // $failure = "email must have an at-sign (@)";
      }else{
        $check = hash('md5',$salt.$_POST['pass']);
           if ( $check != $stored_hash){
             //redirect the browser to game.php
          error_log("Login fail ".$_POST['email']);
          $_SESSION['error'] = "Incorrect password";
          header("Location: login.php");
          return;
        } else{
            error_log("Login success".$_POST['email']." "."$check");
            $_SESSION['success'] = "Login success";
            header("Location: view.php");
            return;

          }
    }
     }
}
// Fall through into the View
?>

<!DOCTYPE html>
<html>
<head>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<title>Amer Alhafid's Login Page</title>
</head>
<body>
<div class="container">
<h1>Please Log In</h1>
<?php
if (isset($_SESSION['error']) ) {
  echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
  unset($_SESSION['error']);
}
?>
<form method="POST">
<label for="nam">User Name</label>
<input type="text" name="email" id="nam"><br/>
<label for="id_1723">Password</label>
<input type="text" name="pass" id="id_1723"><br/>
<input type="submit" value="Log In">
<input type="submit" name="cancel" value="Cancel">
</form>
<p>
For a password hint, view source and find a password hint
in the HTML comments.
<!-- Hint: The password is the three character name of the
programming language used in this class (all lower case)
followed by 123. -->
</p>
</div>
</body>
</html>
