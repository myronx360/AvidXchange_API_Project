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


//document.getElementById("myTextarea").style.height = "100px";
    //document.getElementById("myTextarea").rows = "10";

    $(document).ready(function(){

        var isEditing = false;
        $(".editArea").click(function () {
            reset();// so that only set of edit elements shows up
            startEdit(this);
        });
        function startEdit(elementClicked) {
            // create text-area and buttons to edit items
            var textArea = "<br> <textarea class='form-control form-group'  name='newText' autofocus></textarea> <br>";

            // var textArea = "<br> <input type='text' class='form-control' class='input-lg' class='form-group-lg'  name='newText' autofocus> <br>";
            var originalText = "<input type='hidden' name='originalText' id='origText'>";
            var confirmBtn = "<br> <input type='button' onclick='confirmChanges()' name='confirm_btn' value='Confirm Changes'>";
            var cancelBtn = "<input  type='button' name='cancel_btn' value='Close'> <br>";
            var lineID = "<input type='hidden' name='lineID' id='lineID'>";

            if(!isEditing) {

                isEditing = true;
                $(elementClicked).after("<div id='editor'></div>");
                $("#editor").html("<h5><form action='FileEditor.php' method='post' id='editForm'>"+textArea+originalText+confirmBtn+cancelBtn+lineID+"</form></h5>");
                $("[name='newText']").val($(elementClicked).text());
                $("[name='originalText']").val($(elementClicked).text());
                $("[name='lineID']").val($(elementClicked).attr("id"));
                $("[name='newText']").select();

            }else{
                reset();
            }
            $("[name='confirm_btn']").click(function () {

                var newText = $("[name='newText']").val();
                var originalText = $("[name='originalText']").val();
                var quote = "\"";



                // if the originalText had quotes re-add quotes to newText if missing
                if(originalText.charAt(0) == '"' && originalText.charAt(originalText.length - 1) == '"') {

                    if (newText.charAt(0) !== '"' && newText.charAt(newText.length - 1) !== '"') {
                        $("[name='newText']").val(quote.concat(newText).concat(quote));
                    } else if (newText.charAt(0) !== '"') {
                        $("[name='newText']").val(quote.concat(newText));
                    } else if (newText.charAt(newText.length - 1) !== '"') {
                        $("[name='newText']").val((newText).concat(quote));
                    }

                    // handles what happens when the new data is empty
                    if(newText == "" || newText == "\"\""){
                        $("[name='newText']").val(quote.concat("[]").concat(quote));
                    }
                }else{
                    // handles what happens when the new data is empty
                    if(newText == "" || newText == "\"\""){
                        $("[name='newText']").val("[]");
                    }
                }

                    var form = $("#editForm");

                $.ajax({
                    type: form.attr('method'),
                    url: form.attr('action'),
                    data: form.serialize() // serializes the form's elements.
                }).done(function(tempApiUrl) {
                    // Optionally alert the user of success here...
                    // alert messages
                    $("#loadingMsg").text($("#apiSelector option:selected").text() + " editing");
                    $("#loadingMsg").removeClass();
                    $("#loadingMsg").addClass("text-warning");
                    $("#saveMsg").text("");
                    $("#saveErrMsg").text($("#apiSelector option:selected").text() + " editing");

                    //insert new nav links
                    $("#navLinks").val("");

                    document.getElementById("navLinks").innerHTML = "<span> Skip To: <a href='#Top'> Top </a>" ;
                    // alert(result);
                    $.post("FileEditor.php", {nav: tempApiUrl}, function(jsonString) {

                        var jObj = JSON.parse(jsonString);

                        // create nav anchor links
                        for (var x in jObj) {
                            document.getElementById("navLinks").innerHTML += "<a href=" + '#'.concat(x) + ">" + x + "</a>" + "\t\t";
                            navLinks.push(x);
                        }

                    $.post("FileEditor.php", {suggest: tempApiUrl, editStarted: true, navWords: navLinks.toString()}, function(result) {
                        $("#displayJson").html(result);
                        $("#loadingMsg").text($("#apiSelector option:selected").text() + " edited");
                        $("#loadingMsg").removeClass();
                        $("#loadingMsg").addClass("text-success");
                        $("#saveErrMsg").text("");
                        $("#saveMsg").text($("#apiSelector option:selected").text() + " edited");
                    });
                        document.getElementById("navLinks").innerHTML += "<a href='#Bottom'> Bottom </a></span>";
                    });

                });

            });


            // close editor
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
            $(this).css("cursor","pointer");
        }, function(){
            $(this).css("background-color", "transparent");
        });





    });


}







/**
 *
 * TODO:
 *
 *
 *
 * saving a file with the same name overwrites file. feature?
 * handle what happens when a folder is in the list
 * // pressing enter on a textarea
 * dyanamically change the size of the textarea
 * AvidXchange css stuff
 *
 *
 **/




