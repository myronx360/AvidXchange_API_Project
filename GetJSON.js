/**
 * Created by mxw13 on 3/26/2017.
 */

//get selected json file
function setFile(apiUrl) {

    // show loading message
    $(document).ajaxStart(function () {
        $("#loadingMsg").text("Loading...");
    });
    $.post("FileEditor.php", {suggest: apiUrl}, function(result,status){
        $("#displayJson").html(result);
        $(document).ajaxComplete(function () {
            if($("#apiSelector option:selected").text() != "Select an API:") {
                $("#loadingMsg").text($("#apiSelector option:selected").text() + " loaded: " + status); // display the status of the loaded json file
                setUpEditor();
            }else{
                $("#loadingMsg").text("");

            }
        });

    });
}

