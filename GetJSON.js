/**
 * Created by mxw13 on 3/26/2017.
 */
var navLinks = [];
//get selected json file
function setFile(apiUrl, newAPISelected) {
    $("#newName").val("");
    $("#navLinks").val("");

    document.getElementById("navLinks").innerHTML = "<span > Skip To: <a href='#Top'> Top </a>" ;
//<span style='color:blue;margin-left:30px;'>
    // show loading message
    // $(document).ajaxStart(function () {
        $("#loadingMsg").text($("#apiSelector option:selected").text() + " loading...");
    // });

    $.post("FileEditor.php", {nav: apiUrl}, function(result) {
        var jObj = JSON.parse(result);

        // create nav anchor links
        for (var x in jObj) {
            document.getElementById("navLinks").innerHTML += "<a href="+'#'.concat(x)+">" +x+"</a>" + "\t\t";
            navLinks.push(x);
        }


        $.post("FileEditor.php", {suggest: apiUrl, newAPISelected: newAPISelected, navWords: navLinks.toString()}, function(result){

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
        document.getElementById("navLinks").innerHTML += "<a href='#Bottom'> Bottom </a></span>";
        // var offset = $(':target').offset();
        // var scrollto = offset.top - 60; // minus fixed header height
        // $('html, body').animate({scrollTop:scrollto}, 0);
        // $("#navLinks").addClass("page-header");
    });



}

