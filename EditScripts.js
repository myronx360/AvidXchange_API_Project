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
        $("h2,h3,p").click(function () {
            startEdit(this);
        });
        function startEdit(elementClicked) {

            var textArea = "<br> <textarea name='text_change'></textarea> <br>";
            var confirmBtn = "<br> <input type='submit' name='confirm_btn' value='Confirm Changes'> <br>";
            var cancelBtn = "<br> <input type='button' name='cancel_btn' value='Cancel'> <br>";
            // var newData = "<input type='hidden' name='newData value=''>";

            if(!isEditing) {
                isEditing = true;
                $(elementClicked).after("<div id='editor'></div>");
                $("#editor").html("<form action='FileHandler.php' method='post'>"+textArea+confirmBtn+cancelBtn+"</form>");
                $("[name='text_change']").val($(elementClicked).text());
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
 *
 *
 *
 *
 **/




