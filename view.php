<?php
require_once "pdoConc.php";
session_start();
if ( !isset($_SESSION['email']) || strlen($_SESSION['email']) < 1) {
  die("Not logged in");
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
  <h1>Tracking Autos for
  <?php
  if ( isset($_SESSION['email']) ) {
      echo htmlentities($_SESSION['email']);
      echo "</h1>\n";
  }
  if ( isset($_SESSION['success']) ) {
    echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
    unset($_SESSION['success']);
  }
  ?>

  <h2>Automobiles</h2>
  <ul>
  <?php
  $stmt = $pdo->query("SELECT make,year,mileage FROM autos");
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
    echo"<p><li>";
    echo htmlentities($row['year']." ");
    echo htmlentities($row['make']);
    echo htmlentities(" / ".$row['mileage']);
    echo"</p></li>";
  }
  ?>
  </ul>
    <p>
    <a href="add.php">Add New</a> |
    <a href="logout.php">Logout</a>
    </p>
  </div>
</body>
</html>
