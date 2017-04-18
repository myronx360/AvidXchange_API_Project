<?php


if(isset($_POST["submit"])) {
    $target_dir = "jsonFiles/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $APIFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    $successMsg = "";
    $failMsg = "";




// Check if file already exists
    if (file_exists($target_file)) {
        $failMsg .= "Sorry, file already exists.\n";
        $uploadOk = 0;
    }

// Allow certain file formats
    if ($APIFileType != "json") {
        $failMsg .=  "Sorry, only JSON files are allowed.\n";
        $uploadOk = 0;
    }

// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $failMsg .=  "Sorry, your file was not uploaded.\n";
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $successMsg .= "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.\n";
        } else {
            $failMsg .=  "Sorry, there was an error uploading your file.\n";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>API Uploader</title>
    <link rel="stylesheet" type="text/css" href="bootstrap.css">
</head>




<body class="panel-body">
<header class="page-header">
    <div class="navbar-fixed-top">
        <a href="index.php"><input type="button" value="API Editor"></a><br>
    </div>
</header>
<h1 class="h1">Getting Started</h1>

<form action="upload.php" method="post" enctype="multipart/form-data">
    Select API to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input class="btn-success" type="submit" value="Upload API" name="submit">
</form>
<div class="has-error" id="uploadMessage">
<?php
if(isset($_POST["submit"])) {
    if (!empty($successMsg)) {
        echo $successMsg;
?>
    <div id = "dateTime"></div>
<?php
    } else {
        echo $failMsg;
?>
    <div id = "dateTime"></div>
<?php
    }
}
?>
</div>

<footer></footer>
<script>
    var date = new Date();
    var localDate = date.toLocaleDateString();
    var time = date.toLocaleTimeString();
    var dt = localDate + "  " + time;

    document.getElementById("dateTime").innerHTML += dt;

</script>
</body>

</html>

