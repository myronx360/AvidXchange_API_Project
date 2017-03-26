/**
 * Created by mxw13 on 3/26/2017.
 */

//get selected json file
function setFile(apiUrl,fileName) {

    // show loading message
    $(document).ajaxStart(function () {
        $("#loadingMsg").text("Loading...");
    });

    $.getJSON(apiUrl, function(result,status){;
        transverseJSON(result); // show json file on the webpage
        $(document).ajaxComplete(function () {

            $("#loadingMsg").text(fileName+" loaded " + status); // display the status of the loaded json file

        });

    });

}
