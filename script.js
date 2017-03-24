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



    // create textarea to edit items
    $(document).ready(function(){
        var isEditing = false;
        $("h2,h3,p").click(function () {
            // if(!isEditing) {
                startEdit(this);
            // }
        });
        function startEdit(elementClicked) {

            var textArea = "<br> <textarea name='text_change'></textarea> <br>";
            var confirmBtn = "<br> <input type='button' name='confirm_btn' value='Confirm Changes'> <br>";
            var cancelBtn = "<br> <input type='button' name='cancel_btn' value='Cancel'> <br>";

                if(!isEditing) {
                    isEditing = true;
                    $(elementClicked).after("<div id='editor'></div>");
                    $("#editor").html(textArea+confirmBtn+cancelBtn);
                    $("[name='text_change']").val($(elementClicked).text());
                }else{
                    reset();
                }
                $("[name='confirm_btn']").click(function () {
                    isEditing = false;
                });
                $("[name='cancel_btn']").click(function () {
                    reset();
                });

                $("#nav").click(function () {
                    // alert(isEditing);
                })

        }

        function reset() {
            isEditing = false;
            $("#editor").remove();
        }


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




