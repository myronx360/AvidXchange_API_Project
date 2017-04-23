/**
 * Created by mxw13 on 3/26/2017.
 */

//get selected json file
function setFile(apiUrl, newAPISelected) {
    $("#newName").val("");
    // show loading message
    // $(document).ajaxStart(function () {
        $("#loadingMsg").text($("#apiSelector option:selected").text() + " loading...");
    // });
    $.post("FileEditor.php", {suggest: apiUrl, newAPISelected: newAPISelected}, function(result){

        $("#displayJson").html(result);
        $(document).ajaxSuccess(function () {

            if(newAPISelected) {
                $("#loadingMsg").text($("#apiSelector option:selected").text() + " loaded"); // display the status of the loaded json file
                newAPISelected = false;
            }
            if($("#apiSelector option:selected").text() == "Select an API:") {
                $("#loadingMsg").text("");
            }
            setUpEditor();
        });

    });
}

