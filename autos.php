<?php
require_once "pdoConc.php";

if ( !isset($_GET['email']) || strlen($_GET['email']) < 1) {
  die("Name parameter missing");
}
if (isset($_POST['logout'])){
  //Redirect the Browser to index.php
  header("Location: index.php");
  return;
}
$failure = false;//if we have no POST SDO_DAS_DataObject
$insrt = False;
if (isset($_POST['make']) || isset($_POST['year']) || isset($_POST['mileage'])){
  if (!isset ($_POST['make']) || strlen($_POST['make']) < 1){
    $failure = "Make is required";

  }
  else {
    if (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])){
      $failure = "Mileage and year must be numeric";
    }
  }

    if ($failure == false){
      $stmt = $pdo->prepare('INSERT INTO autos
      (make, year, mileage) VALUES ( :mk, :yr, :mi)');
      $stmt->execute(array(
        ':mk' => $_POST['make'],
        ':yr' => $_POST['year'],
        ':mi' => $_POST['mileage'])
      );
      $insrt = "Record inserted";
    }
}






?>

<DOCTYPE html>
<html>
<head>
<title>Amer Alhafid's Automobile Tracker</title>
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

</head>
<body>
  <div class="container">
  <h1>Tracking Autos for
  <?php
  if ( isset($_REQUEST['name']) ) {
      echo htmlentities($_REQUEST['name']);
      echo "</h1>\n";
  }
  // Note triple not equals and think how badly double
  // not equals would work here...
  if ($failure !== false){
    echo('<p style="color: red;">'.$failure."</p>\n");
  }else{
    if ($insrt !== False){
      echo('<p style="color: green;">'.$insrt."</p>\n");

    }
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
  <input type="submit" name="logout" value="Logout">
  </form>
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
  </div>
  <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
</body>
</html>
