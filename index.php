<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>API Editor</title>
    <link rel="stylesheet" type="text/css" href="bootstrap.css">

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>

</head>
<?php
/**
 * InClass # HW #
 * API_Editor.
 * User: Myron Williams
 * Date: 3/26/2017
 * Time: 1:28 PM
 */

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

//$baseUrl = "http://".$_SERVER['SERVER_NAME']."/JSONParser/";
$dir = "jsonFiles/";
$dh  = opendir($dir);

// $baseUrl = "https://avid-api-mxw13.c9users.io/";
//$baseUrl = "https://".$_SERVER['SERVER_NAME']."/";
//$dir = "jsonFiles/";
//$dh  = opendir($dir);
while (false !== ($filename = readdir($dh))) {
    $files[] = $filename;
}


$_SESSION["dir"] = $dir;
?>




<body class="panel-body">
<header class="page-header">
    <div class="navbar-fixed-top">
        <nav id="nav">
        <a href="upload.php"><input type="button" value="Add New API"></a>
        <a id="saveBtn"><input type="button" value="Save"></a>
        <a id="saveAsFormBtn"> <input type="button" value="Save As"></a>
        <span id='saveAsForm'> <input type='text' id="newName" name='name' value="" placeholder='Enter Name'><input type='button' id="saveAsBtn" name="saveAsBtn" value='Save'></span>
        <br><br>
         </nav>
    </div>
</header>
<h1 class="h1">Getting Started</h1>
<br><br>
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
    <br><br>
    <div id="displayJson"></div>

    <br><br>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        Select API to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload API" name="submit">
    </form>


</main>
<footer></footer>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="GetJSON.js"></script>
<script src="EditScripts.js" ></script>
<script src="SaveScripts.js" ></script>
<script>




</script>

</body>
</html>