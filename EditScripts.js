/**
 * Created by myron on 3/7/2017.
 */

// Check for the various File API support.
if (window.File && window.FileReader && window.FileList && window.Blob) {
    // Great success! All the File APIs are supported.
    // alert('Success');
} else {
    alert('The File APIs are not fully supported in this browser.');
}

function setUpEditor() {



    // create text-area and buttons to edit items
    $(document).ready(function(){

        var isEditing = false;
        $(".editArea").click(function () {
            startEdit(this);
        });
        function startEdit(elementClicked) {
            var prev =  $(elementClicked).prev().text();
            // alert("PRev: "+$("p").prev("p")+", "+prev);
            var next =  $(elementClicked).next().text();

            // alert("Next: "+$("p").next("p")+", "+next);
            var textArea = "<br> <textarea name='text_change'></textarea> <br>";
            var originalText = "<input type='hidden' name='originalText' id='origText'>";
            var confirmBtn = "<br> <input type='submit' name='confirm_btn' value='Confirm Changes'> <br>";
            var cancelBtn = "<br> <input type='button' name='cancel_btn' value='Cancel'> <br>";
            // var newText = "<input type='hidden' name='newText' id='newText'>";
            var prevText = "<input type='hidden' name='prevText' id='prevText'>";
            var afterText = "<input type='hidden' name='afterText' id='afterText'>";
            var lineID = "<input type='hidden' name='lineID' id='lineID'>";

            if(!isEditing) {
                isEditing = true;
                $(elementClicked).after("<div id='editor'></div>");
                $("#editor").html("<form action='FileHandler.php' method='post'>"+textArea+originalText+lineID+prevText+afterText+confirmBtn+cancelBtn+"</form>");
                $("#origText").val($(elementClicked).text());

                $("[name='text_change']").val($(elementClicked).text());
                $("[name='prevText']").val($(elementClicked).prev().text());
                $("[name='afterText']").val($(elementClicked).next().text());
                $("[name='lineID']").val($(elementClicked).attr("id"));
                alert($(elementClicked).attr("id"));
            }else{
                reset();
            }
            // $("[name='confirm_btn']").click(function () {
            //     isEditing = false;
            // });
            $("[name='cancel_btn']").click(function () {
                reset();
            });

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
 * TODO:   1. click on element show a submit button that says edit/add/remove /  cancel button, delete could break things for child objects
 *         2. display something(i.e alert box, text box/area) to enter text to edit the text
 *         3. submit button updates changes
 *         4. AvidXchange css stuff
 *         5. add API test file to remote server and get from server
 *         6. process to add and modify APIs
 *         7. a way to view/open plain text file of json
 *         8. After a file is uploaded display it on success may with a link to the index page with json file auto loaded
 *
 *
 *
 *
 **/




