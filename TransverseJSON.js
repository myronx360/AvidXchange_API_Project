/**
 * Created by mxw13 on 3/18/2017.
 */

function transverseJSON() {

// prints top level headings
    for (var c in obj) {
        if (obj[c] == "[object Object]" || Array.isArray(obj[c])) {
            // start transversing the JSON object array
            document.getElementById("divJson").innerHTML += "<div id="+ c +"><h2>" + c + "</h2></div>" + loopMore(JSON.stringify(obj[c])) + "<br>";
        } else {
            // show the value of the JSON object
            document.getElementById("divJson").innerHTML += "<div id="+ c +"><h2>" + c + "</h2></div>" + "<p>" + obj[c] + "</p>";
        }
    }

// prints lower level headings and transverses the JSON object array
    function loopMore(objText) {
        var json = JSON.parse(objText);
        var str = " ";
        for (var c in json) {
            if (json[c] == "[object Object]") { // transverse further through the JSON object array
                if (isNaN(c)) {
                    str += "<br><h3>" + c + "</h3> " + loopMore(JSON.stringify(json[c])) + " ";
                }else {// is an array of objects
                    for(var x in json[c]){
                       str += "<br><h3>" + x + "</h3> ";
                        for(var y in json[c][x]){
                            if (json[c][x] == "[object Object]") {
                                str += loopMore(JSON.stringify(json[c][x]));
                            }else{
                                str += "<p>" + json[c][x]+"</p>";
                                break;
                            }

                        }
                    }
                }
            } else if (Array.isArray(json[c])) {
                // transverse further through the JSON object array
                str += "<br><h3>" + c + "</h3> " + loopMore(JSON.stringify(json[c])) + " ";
            } else {
                if (isNaN(c)) {
                    // show the value of the JSON object
                    str += "<br><h3>" + c + "</h3><br> " + "<p>" + json[c] + "</p>";
                } else {
                    // show the value of the JSON object
                    str += "<p>" + json[c] + "</p>";// skips printing an array index
                }
            }
        }
        return str;
    }
}