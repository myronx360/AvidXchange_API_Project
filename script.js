/**
 * Created by mxw13 on 3/7/2017.
 */

// Check for the various File API support.
if (window.File && window.FileReader && window.FileList && window.Blob) {
    // Great success! All the File APIs are supported.
   // alert('Success');
} else {
    alert('The File APIs are not fully supported in this browser.');
}

var text, obj, stringifyObj;
//    document.getElementById("h").innerHTML = "TESP";
//    text = localStorage.getItem("test.json");
//    obj = { "name":"John", "age":31, "city":"New York" };
// text = <?php echo $jsonFile; ?>;
obj = JSON.parse(text);
stringifyObj = (obj);
//
for (var a in obj) {
    document.getElementById("loop").innerHTML += a.concat(", ");
}

for (var b in obj) {
    document.getElementById("loop2").innerHTML += obj[b] + "<br>";
}


for(var c in obj){
//        if(obj[c].toString().search("[object Object]") >= 0){
//            document.getElementById("debug").innerHTML += c+", "+obj[c];
//        }
    if(obj[c] == "[object Object]"){
        document.getElementById("loop3").innerHTML += "<h1>"+ c +"</h1>"
            + loopMore(JSON.stringify(obj[c])) + "<br>";

    }else{
        document.getElementById("loop3").innerHTML += "<h1>"+ c +"</h1>" + obj[c]
            + "<br>";
    }
}
function loopMore(objText) {
    var json = JSON.parse(objText);
    var str = " ";
    for(var c in json){
        if(json[c] == "[object Object]"){
            str += loopMore(JSON.stringify(json[c])) + " ";
        }else{
            if(true) {// <--- FIXEME json[c].toString().search("[{") >= 0
                str += "<br><h3>" + c + "</h3><br> " + json[c];
            } else {
                str += "<br><h3>" + c + "</h3><br> " + JSON.stringify(json[c]);
            }
        }
    }
    return str;
}

document.getElementById("h").innerHTML += obj.definitions.Error.properties.code.format;
document.getElementById("stringifyJson").innerHTML = JSON.stringify(obj);



