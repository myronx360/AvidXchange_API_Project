/**
 * Created by mxw13 on 4/16/2017.
 */

$(document).ready(function(){
    $("#saveAsForm").hide();
    $("#saveAsFormBtn").click(function() {
        $("#saveAsForm").fadeToggle("fast");
    });

    $("#saveAsBtn").click(function () {
        $.post("FileWriter.php", {newName: $("#newName").val()}, function(result){
            alert(result);
        });
    });

    $("#saveBtn").click(function () {
        $.post("FileWriter.php", {saveBtn: "true"}, function(result){
            alert(result);
        });
    });
});