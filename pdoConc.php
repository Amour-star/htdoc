<?php
// $servername = "localhost";
// $user = "d0335c62";
// $pw = "HDssazeeTY88m6oQ";
// $dbname = "d0335c62";
// $dsn = 'mysql:host='.$servername.';dbname='.$dbname;
// $pdo = new PDO($dsn, $user, $pw);
$pdo = new PDO('mysql:host=localhost;port=3307;dbname=misc', 'fred', 'zap');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
