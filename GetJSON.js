/**
 * Created by mxw13 on 3/26/2017.
 */
var navLinks = [];
//get selected json file
function setFile(apiUrl, newAPISelected) {
    $("#newName").val("");
    $("#navLinks").val("");
    if(apiUrl == ""){// if "Select an API:" is selected
        location.reload(true);
        $("#loadingMsg").text("");
    }else{

        // show loading message
        $("#loadingMsg").text($("#apiSelector option:selected").text() + " loading...");
        $("#loadingMsg").removeClass();
        $("#loadingMsg").addClass("text-warning");


        $.post("FileEditor.php", {nav: apiUrl}, function (result) {// list-inline
            var jObj = JSON.parse(result);

            // create nav anchor links
            document.getElementById("navLinks").innerHTML = "<span class='nav-tabs nav-divider pager pagination'><li class='lead'>Skip to: &nbsp</li><li><a href='#Top'> Top </a></li></span>";

            for (var x in jObj) {
                document.getElementById("navLinks").innerHTML += "<span class='nav-tabs  pager pagination'><li><a class='' href=" + '#'.concat(x) + ">" + x + "</a></li></span>";

                navLinks.push(x);
            }

            document.getElementById("navLinks").innerHTML += "<span class='nav-tabs  pager pagination'> <li><a href='#Bottom'> Bottom </a></li><li></li></span>";

            $.post("FileEditor.php", {
                suggest: apiUrl,
                newAPISelected: newAPISelected,
                navWords: navLinks.toString()
            }, function (result) {

                $("#displayJson").html(result);
                $(document).ajaxSuccess(function () {
                    if (newAPISelected) {
                        // loaded message
                        $("#saveMsg").text("");
                        $("#saveErrMsg").text("");
                        $("#loadingMsg").text($("#apiSelector option:selected").text() + " loaded"); // display the status of the loaded json file
                        $("#loadingMsg").removeClass();
                        $("#loadingMsg").addClass("text-success");
                        newAPISelected = false;
                    }

                    setUpEditor();
                });

            });
         });


    }
}

