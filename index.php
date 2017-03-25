<?php
$dir = "jsonFiles/";
$dh  = opendir($dir);
while (false !== ($filename = readdir($dh))) {
    $files[] = $filename;
}


//$jsonFile = file_get_contents("jsonFiles/UberAPI.json");
//$jsonFile = file_get_contents("jsonFiles/test.json");
//$jsonFile = file_get_contents("jsonFiles/fitbitAPI.json");
//$jsonFile = file_get_contents("jsonFiles/TwitterAPI.json");
//$jsonFile = json_encode($jsonFile);
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
Jump to:<nav id="nav"> </nav>
<h1>Getting Started</h1>
<form action="" method="post">

    Select a API:
    <select id="apiSelector" name="apiSelector" onchange="setFile(this.value)">
    <option value="">Select an API:</option>
        <?php foreach ($files as $file):?>
            <?php if(!($file == "." || $file == "..")):?> // this has a not
                <option value="<?php echo $dir.$file; ?>"> <?php echo $file; ?> </option>
            <?php endif; ?>
        <?php endforeach; ?>
    </select>

    <div id="divJson">Use recursion to access everything:</div>
    <input type="hidden" name="jsonFile" value="">

    <input type="file" name="jsonFileBox">
</form>
<!--<div ng-app="myApp" ng-controller="myCtrl">-->
<!--Select a API:-->
<!--<select id="apiSelector" name="apiSelector"  ng-model="apiViewer">-->
<!--<option value="">Select an API:</option>-->
<!--</select>-->
<!--{{apiViewer}}-->
<!--<div id="displayAPI"><b>API info will be listed here...</b></div>-->
<!--<!--    <div>{{apiViewer}}</div>-->-->
<!--</div>-->

    <p id="debug">Debug for loop:<br></p>

    <p id="stringifyJson"></p>


<footer></footer>

<script src="TransverseJSON.js" ></script>
<script src="script.js" ></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>


<script>
    //test json files
    function setFile(file) {
//        alert(file);


        apiUrl = file;
        $.ajax({url: apiUrl, async: false, success: function(result){
            transverseJSON(result);
        }});

        randomStuff();
    }


//    var app = angular.module('myApp', []);
//    app.controller('myCtrl', function($scope) {
//        $.ajax({
//            url: $scope.apiViewer, async: false, success: function (result) {
//                transverseJSON(result);
//            }
//        });
//        });

//    $.getJSON(apiUrl, function(result){
//        transverseJSON(result);
//    });
<?php
//    if (isset($_POST["apiSelector"])  && ($_POST["apiSelector"] != "")) {
//        echo "document.getElementById('debug').innerHTML+='test1';"; ?>
//       $.ajax({url:<?php //echo $_POST['apiSelector'] ?>//, async: false, success: function(result){
//            transverseJSON(result);
//        }});
//         document.getElementById('debug').innerHTML+='test2';
//
//
//        <?php // }else{
//        echo "document.getElementById('debug').innerHTML+='test3';";
//    }
//    ?>
//
//    function showAPI(apiURL) {
//        apiUrl = $("apiSelector").val();
//        $.ajax({
//            url: apiUrl, async: false, success: function (result) {
//                transverseJSON(result);
//            }
//        });
//    }




//    function showAPI(apiURL) {
//        if (apiURL=="") {
//            document.getElementById("displayAPI").innerHTML="";
//            return;
//        }
//        if (window.XMLHttpRequest) {
//            // code for IE7+, Firefox, Chrome, Opera, Safari
//            xmlhttp=new XMLHttpRequest();
//        } else {  // code for IE6, IE5
//            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
//        }
//        xmlhttp.onreadystatechange=function() {
//            if (this.readyState==4 && this.status==200) {
//                document.getElementById("displayAPI").innerHTML=this.responseText;
//            }
//        }
//        var name = getURLName(apiURL)
//        xmlhttp.open("POST","index.php",true);
//        xmlhttp.send();
//    }



//    var obj = JSON.parse(<?php //echo $jsonFile; ?>//);






</script>
</body>
</html>