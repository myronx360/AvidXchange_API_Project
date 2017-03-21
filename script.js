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

function randomStuff() {
    // for(var x in obj){
    //     // document.getElementById("debug").innerHTML +=  x + "1: "+obj[x]+"<br>";
    //     document.getElementById("debug").innerHTML += x+"<br> ";
    //     for(var y in obj[x]){
    //         // document.getElementById("debug").innerHTML += y + "2: " + x + "2: "+obj[x][y]+", "+"<br>";
    //         for(var z in obj[x][y]){
    //             // document.getElementById("debug").innerHTML += x+", "+y+", "+z+", " + "3: " + x + "3: "+obj[x]+". "+obj[x][y]+". "+obj[x][y][z]+", "+"<br>";
    //             document.getElementById("debug").innerHTML += z+"<br>" + "<br>"+obj[x][y][z]+"<br>";
    //
    //         }
    //     }
    // }
    // create nav anchor links
    id = "#";
    for (var x in obj) {
        document.getElementById("nav").innerHTML += "<a href="+id.concat(x)+">" +x+"</a>" + "\t";
    }


    // create textarea to edit items
    $(document).ready(function(){
        $("h2").click(function () {
            $(this).after("<br> <textarea name='text_change'> </textarea> <br>");
            $(this).after("<br> <input type='submit' value='Save Changes'> <br>");
        });

        // color hierarchy
        $("h2").css("color", "purple");
        $("h3").css("color", "blue");
        $("p").css("color", "green");




    });


}






/**
 *
 * TODO:   1. click on element show a submit button that says edit/add/remove /  cancel button
 *         2. display something(i.e alert box, text box/area) to enter text to edit the text
 *         3. submit button updates changes
 *         4. AvidXchange css stuff
 *         5. add API test file to remote server and get from server
 *         6. process to add and modify APIs
 *
 *
 *
 *
 **/




