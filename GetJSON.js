/**
 * Created by mxw13 on 3/26/2017.
 */

//get selected json file
function setFile(apiUrl) {

    // show loading message
    $(document).ajaxStart(function () {
        $("#loadingMsg").text("Loading...");
    });
    $.getJSON(apiUrl, function(result,status){

        traverseJSON(result); // show json file on the web-page
        // $("#debug").text(JSON.stringify(result));
        $(document).ajaxComplete(function () {
            // ptions(this.selectedIndex)
            $("#loadingMsg").text($("#apiSelector option:selected").text() + " loaded: " + status); // display the status of the loaded json file

        });

    });

}
