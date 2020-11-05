<?php
require_once "pdoConc.php";
session_start();
if ( !isset($_SESSION['email']) || strlen($_SESSION['email']) < 1) {
  die("Not logged in");
}
if (isset($_POST['Cancel'])){
  //Redirect the Browser to index.php
  header("Location: view.php");
  return;
}

if (isset($_POST['make']) || isset($_POST['year']) || isset($_POST['mileage'])){
  if (!isset ($_POST['make']) || strlen($_POST['make']) < 1){
    $_SESSION['error'] = "Make is required";
    header("Location: add.php");
    return;
   }else {
    if (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])){
      $_SESSION['error'] = "Mileage and year must be numeric";
      header("Location: add.php");
      return;
    }
  }

    if (!isset($_SESSION['error'])){
      $stmt = $pdo->prepare('INSERT INTO autos
      (make, year, mileage) VALUES ( :mk, :yr, :mi)');
      $stmt->execute(array(
        ':mk' => $_POST['make'],
        ':yr' => $_POST['year'],
        ':mi' => $_POST['mileage'])
      );
      $_SESSION['success'] = "Record inserted";
      header("Location: view.php");
      return;
    }
}







?>

<DOCTYPE html>
<html>
<head>
<title> Amer Alhafid's Automobile Tracker</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

</head>
<body>
  <div class="container">
  <h1>Tracking Automobiles for
  <?php
  if ( isset($_SESSION['email']) ) {
      echo htmlentities($_SESSION['email']);
      echo "</h1>\n";
  }
  // Note triple not equals and think how badly double
  // not equals would work here...
  if ( isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
  }
  ?>
  <form method="post">
  <p>Make:
  <input type="text" name="make" size="60"/></p>
  <p>Year:
  <input type="text" name="year"/></p>
  <p>Mileage:
  <input type="text" name="mileage"/></p>
  <input type="submit" value="Add">
  <input type="submit" name="cancel" value="Cancel">
  </form>
  </ul>
  </div>
  <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script></body>
  </html>
