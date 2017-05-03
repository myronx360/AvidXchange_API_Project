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
        $failMsg .= "Sorry, file already exists.<br>";
        $uploadOk = 0;
    }

// Allow certain file formats
    if ($APIFileType != "json") {
        $failMsg .=  "Sorry, only JSON files are allowed.<br>";
        $uploadOk = 0;
    }

// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $failMsg .=  "Sorry, your file was not uploaded.<br>";
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $successMsg .= "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.<br>";
        } else {
            $failMsg .=  "Sorry, there was an error uploading your file.<br>";
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
<!--<header class="page-header">-->
<!--    <div class="navbar-fixed-top">-->
<header id="navi" class="navbar-fixed-top nav-blocks main-container panel-heading panel-primary"><! axc-subnav axc-toolbar axc-toobar-header page-header-->
    <span class="navbar-header">
        <nav id="nav">
             <img src="https://2udm7l4frjjz47k5wg248qz0-wpengine.netdna-ssl.com/wp-content/uploads/avidxchange-logo.svg" width="192" height="31" style="height:31px; overflow:hidden;">
            &nbsp&nbsp&nbsp
        <a href="index.php"><input type="button" value="API Editor"></a><br>
        </nav>
    </span>
</header>

<br><br><br><br><br><br><br><br>
<div class = 'container'>
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
                echo "<span class='text-success'>".$successMsg."</span>";
                ?>
                <div class="text-success" id = "dateTime"></div>
                <?php
            } else {
                echo "<span class='text-danger'>". $failMsg."</span>";
                ?>
                <div class="text-danger" id = "dateTime"></div>
                <?php
            }
        }
        ?>
    </div>
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

