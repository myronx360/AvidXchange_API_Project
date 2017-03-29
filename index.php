<?php
$dir = "jsonFiles/";
$dh  = opendir($dir);
while (false !== ($filename = readdir($dh))) {
    $files[] = $filename;
}
if(isset($_POST['text_change'])) {
    $file = filter_input(INPUT_POST,'text_change');

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>JSON Editor</title>
    <link rel="stylesheet" type="text/css" href="bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
</head>
<body>
<header class="page-header">
    <div class="navbar-fixed-top">
        <a href="upload.php">Add New API</a>|<a href="">Save</a>|<a href="">Save As</a>
        <br><br>
        <nav id="nav"> </nav>
    </div>
</header>

<h1 class="h1"> Getting Started</h1>
<form action="." method="post">

    Select a API:
<!--    <select id="apiSelector" name="apiSelector" onchange="setFile(this.value, this.options(this.selectedIndex).text)"> // Only worked in IE 11-->
    <select id="apiSelector" name="apiSelector" onchange="setFile(this.value)">
    <option value="">Select an API:</option>
        <?php foreach ($files as $file):?>
            <?php if(!($file == "." || $file == "..")):?> // this has a not
                <option value="<?php echo $dir.$file; ?>"><?php echo $file; ?></option>
            <?php endif; ?>
        <?php endforeach; ?>
    </select>
    <span id="loadingMsg"></span>
    <div id="displayJson"></div>
</form>
<form action="upload.php" method="post" enctype="multipart/form-data">
    Select API to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload API" name="submit">
</form>

<!--<div ng-app="myApp" ng-controller="myCtrl">-->
<!--Select a API:-->
<!--<select id="apiSelector" name="apiSelector"  ng-model="apiViewer">-->
<!--<option value="">Select an API:</option>-->
<!--</select>-->
<!--{{apiViewer}}-->
<!--<div id="displayAPI"><b>API info will be listed here...</b></div>-->
<!--    <div>{{apiViewer}}</div>-->
<!--</div>-->

    <p id="debug">Debug for loop:<br></p>

    <p id="stringifyJson"></p>


<footer></footer>

<script src="GetJSON.js" ></script>
<script src="TransverseJSON.js" ></script>
<script src="EditScripts.js" ></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script>



//    var app = angular.module('myApp', []);
//    app.controller('myCtrl', function($scope) {
//        $.ajax({
//            url: $scope.apiViewer, async: false, success: function (result) {
//                transverseJSON(result);
//            }
//        });
//        });

//    $.ajax({url: apiUrl, async: false, success: function(result){
//        transverseJSON(result);
//    }});

//    $.getJSON(apiUrl, function(result){
//        transverseJSON(result);
//    });
</script>
</body>
</html>