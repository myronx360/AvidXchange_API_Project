/**
 * Created by mxw13 on 4/16/2017.
 */

$(document).ready(function(){
    $("#saveAsForm").hide();
    $("#saveAsFormBtn").click(function() {
        $("#saveAsForm").fadeToggle("fast");

    });

    $("#saveAsBtn").click(function () {
        if($("#newName").val() == ""){
            $("#loadingMsg").text("Enter a name");
            $("#saveErrMsg").text("Enter a name");
            // alert("Enter a name");
        }else {
            $.post("FileWriter.php", {newName: $("#newName").val()}, function (result) {
                $(document).ajaxSuccess(function () {
                    var saveAs = $("#newName").val() + " saving";

                    if(result.trim() == saveAs.trim()) {
                        // alert(result.toString());
                        $("#saveErrMsg").text("");
                        $("#loadingMsg").text(result);
                        $("#saveMsg").text(result);

                        location.reload(true, function (result) {
                            $("#saveMsg").text("Saved");
                        });
                    }
                    if(result.trim() == "No changes were made".trim()){
                        $("#saveErrMsg").text(result);
                    }
                });
            });
        }
    });

    $("#saveBtn").click(function () {
        $.post("FileWriter.php", {saveBtn: "true"}, function(result){
            $(document).ajaxSuccess(function () {
                var save = $("#apiSelector option:selected").text()  + " saving";

                if(result.trim() == save.trim()) {
                    $("#saveErrMsg").text("");
                    $("#loadingMsg").text(result);
                    $("#saveMsg").text(result);
                    // alert(result.toString());
                    location.reload(true, function (result) {
                        $("#saveMsg").text("Saved");
                    });
                }
                if(result.trim() == "No changes were made".trim()){
                    $("#saveErrMsg").text(result);
                }
            });
        });
    });
});