<?php

$jsonFile = file_get_contents("jsonFiles/UberAPI.json");
//$jsonFile = file_get_contents("jsonFiles/test.json");
//$jsonFile = file_get_contents("jsonFiles/fitbitAPI.json");
//$jsonFile = file_get_contents("jsonFiles/TwitterAPI.json");
$jsonFile = json_encode($jsonFile);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>JSON Parser</title>
    <link rel="stylesheet" type="text/css" href="bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
</head>
<body>
<header></header>
<nav id="nav">Jump to: </nav>
<h1>Getting Started</h1>
<form action="" method="post">
    <div id="divJson">Use recursion to access everything:</div>
</form>


    <p id="debug">Debug for loop:<br></p>

    <p id="stringifyJson"></p>


<footer></footer>

<script src="TransverseJSON.js" ></script>
<script src="script.js" ></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>


<script>
    var obj = JSON.parse(<?php echo $jsonFile; ?>);
    transverseJSON();
    randomStuff();





</script>
</body>
</html>