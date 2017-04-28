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

        document.getElementById("navLinks").innerHTML = "<span > Skip To: <a href='#Top'> Top </a>";
        // show loading message
        $("#loadingMsg").text($("#apiSelector option:selected").text() + " loading...");
        $("#loadingMsg").removeClass();
        $("#loadingMsg").addClass("text-warning");


        $.post("FileEditor.php", {nav: apiUrl}, function (result) {
            var jObj = JSON.parse(result);

            // create nav anchor links
            for (var x in jObj) {
                document.getElementById("navLinks").innerHTML += "<a href=" + '#'.concat(x) + ">" + x + "</a>" + "\t\t";
                navLinks.push(x);
            }


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
            document.getElementById("navLinks").innerHTML += "<a href='#Bottom'> Bottom </a></span>";
        });


    }
}

