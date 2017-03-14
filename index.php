<?php

$jsonFile = file_get_contents("UberAPI.json");
//$jsonFile = file_get_contents("test.json");
//$jsonFile = file_get_contents("fitbitAPI.json");
$jsonFile = json_encode($jsonFile);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>JSON Parser</title>
    <link rel="stylesheet" type="text/css" href="bootstrap.css">
</head>
<body>
<header></header>

<p id="loop">All of the top properties in a JSON object: <br> </p>
<p id="loop2">The first value of the top properties: <br> </p>
<p id="loop3">Use nested for loop to access everything: <br> </p>

<p id="debug">Debug for loop: <br> </p>

<p id="loop4">Use nested for loop to access everything: <br> </p>

<p id="h">  obj.info.description: <br> </p>
<p id="stringifyJson"> </p>

<footer></footer>

<script src="script.js" ></script>
<script>
    var text, obj, stringifyObj;
    //    text = localStorage.getItem("test.json");
    //    obj = { "name":"John", "age":31, "city":"New York" };
     text = <?php echo $jsonFile; ?>;
    obj = JSON.parse(text);
    stringifyObj = (obj);

    for (var a in obj) {
        document.getElementById("loop").innerHTML += a.concat(", ");
    }

    for (var b in obj) {
        document.getElementById("loop2").innerHTML += obj[b] + "<br>";
    }

    // prints top level headings
    for(var c in obj){
        if(obj[c] == "[object Object]"|| Array.isArray(obj[c])){
            // start transversing the JSON object array
            document.getElementById("loop3").innerHTML += "<h1>"+ c +"</h1>" + loopMore(JSON.stringify(obj[c])) + "<br>";
        }else{
            // show the value of the JSON object
            document.getElementById("loop3").innerHTML += "<h1>"+ c +"</h1>" + obj[c] + "<br>";
        }
    }

    // prints lower level headings and transverses the JSON object array
    function loopMore(objText) {
        var json = JSON.parse(objText);
        var str = " ";
        for (var c in json) {
            if (json[c] == "[object Object]" || Array.isArray(json[c])) {
                // transverse further through the JSON object array
                str += "<br><h3>" + c + "</h3> " + loopMore(JSON.stringify(json[c])) + " ";
            } else {
                // show the value of the JSON object
                str += "<br><h3>" + c + "</h3><br> " + json[c];
            }
        }
        return str;
    }

    document.getElementById("h").innerHTML += obj.definitions.Error.properties.code.format;
    document.getElementById("stringifyJson").innerHTML = JSON.stringify(obj);

</script>
</body>
</html>