<?php
/**
 * InClass # HW #
 * API_Editor.
 * User: Myron Williams
 * Date: 3/26/2017
 * Time: 1:28 PM
 */



//$baseUrl = "http://".$_SERVER['SERVER_NAME']."/";
$dir = "jsonFiles/";
$dh  = opendir($dir);
while (false !== ($filename = readdir($dh))) {
    $files[] = $filename;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>API Editor</title>
    <link rel="stylesheet" type="text/css" href="bootstrap.css">

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>

</head>
<body class="panel-body">
<header class="page-header">
    <div class="navbar-fixed-top">
        <a href="upload.php">Add New API</a>|<a href="">Save</a>|<a href="">Save As</a>
        <br><br>
        <nav id="nav"> </nav>
    </div>
</header>
<h1 class="h1">Getting Started</h1>
<main>
    <form action="." method="post">

        Select a API:
        <select id="apiSelector" name="apiSelector" onchange="setFile(this.value)">
            <option value="" selected>Select an API:</option>
            <?php foreach ($files as $file):?>
                <?php if(!($file == "." || $file == "..")):?> // this has a not
                    <option value="<?php echo $dir.$file; ?>"><?php echo $file; ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>

        <span id="loadingMsg"></span>
    </form>
    <div id="displayJson"></div>

    <form action="upload.php" method="post" enctype="multipart/form-data">
        Select API to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload API" name="submit">
    </form>


</main>
<footer></footer>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="EditScripts.js" ></script>
<script>
    //get selected json file
    function setFile(apiUrl) {
        <?php require_once ('FileHandler.php'); ?>
        $("#displayJson").text(apiUrl);
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
</script>

</body>
</html>