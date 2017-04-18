/**
 * Created by Myron on 3/18/2017.
 */

function traverseJSON(obj) {
    // resets parts the page for displaying it asynchronously
    document.getElementById("nav").innerHTML = "Jump To: ";
    document.getElementById("displayJson").innerHTML = "";
    idNum = 0;

    // create nav anchor links
    for (var x in obj) {
        document.getElementById("nav").innerHTML += "<a href="+'#'.concat(x)+">" +x+"</a>" + "\t\t";
    }

// prints top level headings
    for (var c in obj) {
        if (obj[c] == "[object Object]" || Array.isArray(obj[c])) {
            // start transversing the JSON object array
            document.getElementById("displayJson").innerHTML += "<div id="+ c +"><h2"+insertID()+">" + c + "</h2>"+"</div>" + loopMore(JSON.stringify(obj[c])) + "<br>";
        } else {
            // show the value of the JSON object
            document.getElementById("displayJson").innerHTML += "<div id="+ c +"><h2"+insertID()+">" + c + "</h2>"+"</div>" + "<p"+insertID()+">" + obj[c] + "</p>";
        }
    }

// prints lower level headings and traverses the JSON object array
    function loopMore(objText) {
        var json = JSON.parse(objText);
        var str = " ";
        for (var c in json) {
            if (json[c] == "[object Object]") { // traverse further through the JSON object array
                if (isNaN(c)) {
                    str += "<br><h3"+insertID()+">" + c + "</h3> " + loopMore(JSON.stringify(json[c])) + " ";
                    // document.getElementById("debug").innerHTML += "THIS: " + c+" : "+json[c]+"  --  "+json+"<br>";
                }else {// is the start of an array of [objects Objects]
                    // $("#debug").text($("#debug").text()+"THIS: " + c+" : "+json[c]+"  --  "+json+"<br>");
                    // document.getElementById("debug").innerHTML += "THIS: " + c+" : "+json[c]+"  --  "+json+"<br>";
                    for(var x in json[c]){
                       str += "<br><h3"+insertID()+">" + x + "</h3> "; // show the property name
                        // document.getElementById("debug").innerHTML += "THIS: " + c+" : "+json[c]+"  --  "+json+"  =   "+x+"<br>";
                        for(var y in json[c][x]){
                            // document.getElementById("debug").innerHTML += "THIS: " + c+" : "+json[c]+"  --  "+json+"  =   "+x+"  :   "+y+" :  "+json[c][x]+" : "+json[c][x][y]+"<br>";

                            if (json[c][x] == "[object Object]") {
                                str += loopMore(JSON.stringify(json[c][x])); // recurse further through the object
                            }else{
                                str += "<p"+insertID()+">" + json[c][x]+"</p>"; // show the property value of the JSON object
                                break;
                            }

                        }
                    }
                }
            } else if (Array.isArray(json[c])) {
                //  show the property name and traverse further through the JSON object array
                str += "<br><h3"+insertID()+">" + c + "</h3> " + loopMore(JSON.stringify(json[c])) + " ";
                // document.getElementById("debug").innerHTML += "THIS: " + c+" : "+json[c]+"  --  "+json+"<br>";
            } else {
                if (isNaN(c)) {
                    // show the property name and property value of the JSON object
                    str += "<br><h3"+insertID()+">" + c + "</h3><br> " + "<p"+insertID()+">" + json[c] + "</p>";
                    // document.getElementById("debug").innerHTML += "THIS: " + c+" : "+json[c]+"  --  "+json+"<br>";
                } else {
                    // show the property value of the JSON object
                    str += "<p"+insertID()+">" + json[c] + "</p>";// skips printing an array index
                    // document.getElementById("debug").innerHTML += "THIS: " + c+" : "+json[c]+"  --  "+json+"<br>";
                }
            }
        }
        return str;
    }
    setUpEditor();// set up editor
}

//
// var lineIDVar = 0;
// function insertLineID() {
//     var inputTag = "<input type='hidden' name='lineID' id='lineID'>";
//     $("#lineID").val(lineIDVar);
//     // alert($("#lineID").val());
//     // document.getElementById("lineID").value = lineIDVar;
//     lineIDVar++;
//     return inputTag;
// }

var idNum = 0;

function insertID() {
    var id = " id="+ idNum;
    // alert(id);
    idNum++;
    return id;
}
// function insertID2(count) {
//     var threshold = 6;
//     idNum = idNum + count +  threshold;
//     var id = " id="+ idNum;
//     // alert(id);
//
//     return id;
// }