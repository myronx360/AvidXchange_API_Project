<?php
/**
 * InClass # HW #
 * API_Editor.
 * User: Myron Williams
 * Date: 3/26/2017
 * Time: 1:28 PM
 */
/**
 * Modes 	Description
r 	Open a file for read only. File pointer starts at the beginning of the file
w 	Open a file for write only. Erases the contents of the file or creates a new file if it doesn't exist. File pointer starts at the beginning of the file
a 	Open a file for write only. The existing data in file is preserved. File pointer starts at the end of the file. Creates a new file if the file doesn't exist
x 	Creates a new file for write only. Returns FALSE and an error if file already exists
r+ 	Open a file for read/write. File pointer starts at the beginning of the file
w+ 	Open a file for read/write. Erases the contents of the file or creates a new file if it doesn't exist. File pointer starts at the beginning of the file
a+ 	Open a file for read/write. The existing data in file is preserved. File pointer starts at the end of the file. Creates a new file if the file doesn't exist
x+ 	Creates a new file for read/write. Returns FALSE and an error if file already exists
 */

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$contents = $_SESSION["finalContent"];
$path = $_SESSION["path"];
$dir = $_SESSION["dir"];

$newName = filter_input(INPUT_POST, "newName");
$save = filter_input(INPUT_POST, "saveBtn");

if(isset($save)){ // save
    $path = preg_replace('/TEMP./', ".", $path);//preg_replace($pattern, $replacement, $string);
}

if (isset($newName)){// save as

    if(strpos($newName,".json") === false){
        $path = $dir.$newName.".json";
    }else{
        $path = $dir.$newName;
    }


}
$myfile = fopen($path, "w") or die("Unable to open file!");
fwrite($myfile,$contents);//fwrite(file,string,length)
fclose($myfile);


?>



