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




    $(document).ready(function(){

        var isEditing = false;
        $(".editArea").click(function () {
            reset();// so that only set of edit elements shows up
            startEdit(this);
        });
        function startEdit(elementClicked) {
            // create text-area and buttons to edit items
            var textArea = "<br> <textarea name='newText'></textarea> <br>";
            var originalText = "<input type='hidden' name='originalText' id='origText'>";
            var confirmBtn = "<br> <input type='button' onclick='confirmChanges()' name='confirm_btn' value='Confirm Changes'>";
            var cancelBtn = "<input type='button' name='cancel_btn' value='Close'> <br>";
            var lineID = "<input type='hidden' name='lineID' id='lineID'>";

            if(!isEditing) {

                isEditing = true;
                $(elementClicked).after("<div id='editor'></div>");
                $("#editor").html("<form action='FileEditor.php' method='post' id='editForm'>"+textArea+originalText+confirmBtn+cancelBtn+lineID+"</form>");
                $("[name='newText']").val($(elementClicked).text());
                $("[name='originalText']").val($(elementClicked).text());
                $("[name='lineID']").val($(elementClicked).attr("id"));

            }else{
                reset();
            }
            $("[name='confirm_btn']").click(function () {

                        var form = $("#editForm");

                        $.ajax({
                            type: form.attr('method'),
                            url: form.attr('action'),
                            data: form.serialize() // serializes the form's elements.
                        }).done(function(result) {
                            // Optionally alert the user of success here...
                            // alert(result);
                            $.post("FileEditor.php", {suggest: result}, function(result) {
                                // alert(result);
                                $("#displayJson").html(result);
                            });
                            // $("#displayJson").html(result);
                            // alert(result);
                        }).fail(function(result) {
                            // Optionally alert the user of an error here...
                        });

            });
            $("[name='cancel_btn']").click(function () {
                reset();
            });

        }

        function reset() {
            isEditing = false;
            $("#editor").remove();
        }


        // highlight editable text
        $(".editArea").hover(function(){
            $(this).css("background-color", "yellow");
        }, function(){
            $(this).css("background-color", "transparent");
        });

        $("[name='originalText']").hover(function () {
           alert("mess");
        });



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
 *header location this #@edit
 * linefinder
 * destroy sessions variables when selected file changes or save
 * txt box proction with savas
 *
 *
 **/




