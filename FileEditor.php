<?php
/**
 * InClass # HW #
 * API_Editor.
 * User: Myron Williams
 * Date: 4/14/2017
 * Time: 11:37 PM
 */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$editStarted = filter_input(INPUT_POST, 'editStarted');
if(isset($editStarted)){
    $_SESSION["beginEditing"] = $editStarted;
}
$newAPISelected = filter_input(INPUT_POST, 'newAPISelected');

if(isset($_SESSION["beginEditing"])  && isset($newAPISelected) && $newAPISelected == true){
    if(isset($_SESSION["finalContent"]) && isset($_SESSION["path"]) && file_exists($_SESSION["path"])){
        unlink($_SESSION["path"]); // delete TEMP file of the prev api when a different api is selected w/o saving the changes of the prev api
        unset($_SESSION["finalContent"]);
        unset($_SESSION["path"]);
        unset($_SESSION["beginEditing"]);
    }
}

$path = filter_input(INPUT_POST, 'suggest');
$navPath = filter_input(INPUT_POST, 'nav');
$navWords = filter_input(INPUT_POST, 'navWords');

static $totalIdNums = 0;
static $content = "";
$findLineHashMap = array(); // holds an idNum as a key and a line of text as a value
$finalContent = "";
$navWordsArray = array();
if(isset($path) && $path != ""){
    $path = $path . ".json";
    if(substr_count($path, ".json") > 1) {
        $path = preg_replace('/.json/', "", $path);
        $path = $path . ".json";
    }

    setUpJsonText($path);

}
if(isset($navPath)) {
    $navPath = $navPath . ".json";
    if(substr_count($navPath, ".json") > 1) {
        $navPath = preg_replace('/.json/', "", $navPath);
        $navPath = $navPath . ".json";
    }

    setUpNavLinks($navPath);
}
if (isset($navWords)){
    global $navWords;
}

function setUpJsonText($path){
    global $findLineHashMap;
    static $content;
    global $totalIdNums;
    global $navWords;
    $navWordsArray= str_getcsv($navWords);

    $myfile = fopen($path, "r") or die("Unable to open file!");

    $_SESSION["path"] = $path;
    $idNum = 0;
    $formattedContent = "";
    $lineLengthLeft = 0;
    $lineLengthRight = 0;




    $findStringPosHashMap = array(); // Each line is added as a key and its location (in bytes/chars) in the file is stored as a value.
    //  Made so that lines with the same text could be changed without conflict


    while (!feof($myfile)) { // Loop until the end of the file
        $line = fgets($myfile);     // capture the current line for displaying/editing

        $content.= $line;          // content holds the original contents of the file

        // patterns and preg_replace remove special characters from the line to be displayed and stored in $formattedLine
//        $patterns = '/(^{\n|: {\n|": \[\n|},\n| ],\n|",\n|,\n)/';
        $patterns = '/(^{\n|: {\n|: \[\n|},\n| ],\n|,\n|,$|,\n )/';
        $formattedLine = preg_replace($patterns, " ", $line);
        $patterns = '/(",)/';
        $formattedLine = preg_replace($patterns, '"', $formattedLine);// slows things down b/c of other types of json
        if(strstr($formattedLine, "[]") === false) {
            $patterns = '/(": \[|": {)/';
            $formattedLine = preg_replace($patterns, '":', $formattedLine);// slows things down b/c of other types of json
        }


        $formattedLine = trim($formattedLine);
        if($formattedLine == '{' || $formattedLine == '['|| $formattedLine == '}'|| $formattedLine == ']'||
           $formattedLine == '},'|| $formattedLine == '],'){
            $formattedLine = "";
        }


        if (str_word_count($formattedLine) > 0 || is_numeric($formattedLine) || strlen($formattedLine) > 0) {// if something is there after formatting

            /*************** start left side *********************/
            // $currLineLeft holds the sub-string that is left of ':' in the $formattedLine
            $currLineLeft = strstr($formattedLine, ":", true); //strstr(string,search,before_search)
            $currLineLeft = trim($currLineLeft);


            if (strlen($currLineLeft) > 0) { // if something is there after formatting

               if (array_key_exists($currLineLeft, $findStringPosHashMap)) {//(key,array)  if the line has been added to the array already
                    // get the strpos of this line...
                    $lineLengthLeft = strpos($content, $currLineLeft, $findStringPosHashMap[$currLineLeft]+1);  //strpos(string,find,start)
                    $findStringPosHashMap[$currLineLeft] = $lineLengthLeft; // and update the value of the pos so the next instance of the same line can be found and updated
                } else { // add the line's text as a key and set its value as the strpos()
                    $findStringPosHashMap[$currLineLeft] = strpos($content, $currLineLeft);
                    $lineLengthLeft = $findStringPosHashMap[$currLineLeft];
                }

                //check if the word is part of the navigation list
                    $quote = "\"";
                    for($x = 0; $x < count($navWordsArray); $x++) {
                        $currWord = $quote.$navWordsArray[$x].$quote;
                        if($currWord == $currLineLeft){
                            $formattedContent .= "<div class='offset' id=" .$navWordsArray[$x] . "></div>" ;//add an anchor link
                        }
                    }

                // $formattedContent holds what is displayed on an HTML webpage
                $formattedContent .= "<h2>"."<span class='editArea' id=" . $idNum . ">" . $currLineLeft. "</span> : " ."</h2>". "<br>";
                $findLineHashMap[$idNum] = $lineLengthLeft; // assigns a line of text to an $idNum
                $idNum++;


            }
                            /********** Start right side **********/
            // $currLineRight holds the sub-string that is right of ':' in the $formattedLine
            $currLineRight = strstr($formattedLine, ":", false); //strstr(string,search,before_search)
            $pattern = "/(^\:)/";
            $currLineRight = preg_replace($pattern, " ", $currLineRight);
            $currLineRight = trim($currLineRight);
//
//            if($currLineRight == '{' || $currLineRight == '['){
//                $currLineRight = "";
//            }


            /********** if the line has no ':' *****************/
            if(strstr($formattedLine, ":", false) === false) {
                $formattedLine = trim($formattedLine);

                if (strlen($formattedLine) > 0) {// if something is there after formatting
                    if (array_key_exists($formattedLine, $findStringPosHashMap)) {//key,array {//(key,array)  if the line has been added to the array already
                        // get the strpos of this line...
                        $lineLength = strpos($content, $formattedLine, $findStringPosHashMap[$formattedLine]+strlen($formattedLine)); //strpos(string,find,start)
                        $findStringPosHashMap[$formattedLine] = $lineLength;// and update the value of the pos so the next instance of the same line can be found and updated
                    } else { // add the line's text as a key and set its value as the strpos()
                        $findStringPosHashMap[$formattedLine] = strpos($content, $formattedLine);
                        $lineLength = $findStringPosHashMap[$formattedLine];
                    }

                    //check if the word is part of the navigation list
                    $quote = "\"";
                    for($x = 0; $x < count($navWordsArray); $x++) {
                        $currWord = $quote.$navWordsArray[$x].$quote;
                        if($currWord == $formattedLine){
                            $formattedContent .= "<div class='offset' id=" .$navWordsArray[$x] . "></div>" ;//add an anchor link
                        }
                    }

                    // $formattedContent holds what is displayed on an HTML webpage
                    $formattedContent .= "<h2>"."<span class='editArea' id=" . $idNum . ">" . $formattedLine. "</span>" ."</h2>"."<br>";
                    $findLineHashMap[$idNum] = $lineLength; // assigns a line of text to an $idNum
                    $idNum++;
                }
            }
                        /********** Continue right side **********/
            if (strlen($currLineRight) > 0 ) {// if something is there after formatting

                    if (array_key_exists($currLineRight, $findStringPosHashMap)){
                        // get the strpos of this line...
                        $lineLengthRight = strpos($content, $currLineRight, $findStringPosHashMap[$currLineRight] + strlen($currLineRight)); //strpos(string,find,start)
                        $findStringPosHashMap[$currLineRight] = $lineLengthRight;// and update the value of the pos so the next instance of the same line can be found and updated
                    } else { // add the line's text as a key and set its value as the strpos()
                        $findStringPosHashMap[$currLineRight] = strpos($content, $currLineRight);
                        $lineLengthRight = $findStringPosHashMap[$currLineRight];
                }

                //check if the word is part of the navigation list
                $quote = "\"";
                for($x = 0; $x < count($navWordsArray); $x++) {
                    $currWord = $quote.$navWordsArray[$x].$quote;
                    if($currWord == $currLineRight){
                        $formattedContent .= "<div class='offset' id=" .$navWordsArray[$x] . "></div>";//add an anchor link
                    }
                }

                // $formattedContent holds what is displayed on an HTML webpage
                $formattedContent .= "<span class='editArea' id=" . $idNum . ">" . $currLineRight . "</span>" . "<br><br>";
                $findLineHashMap[$idNum] = $lineLengthRight; // assigns a line of text to an $idNum
                $idNum++;
            }

        }
        $totalIdNums = $idNum;
    }
    echo $formattedContent."<br>";

    $_SESSION['totIDs'] = $totalIdNums;
    $_SESSION['orgContent'] = $content;
    $_SESSION['findLineHashMap'] = $findLineHashMap;




    fclose($myfile);
}


if(isset($_POST["newText"])){
    editContent();

}

function editContent(){
    $finalContent = "";

    $newText = filter_input(INPUT_POST, 'newText');
    $originalText = filter_input(INPUT_POST, 'originalText');
    $lineID = filter_input(INPUT_POST, 'lineID');
    $totalIdNums = $_SESSION['totIDs'];
    $content = $_SESSION['orgContent'];
    $findLineHashMap = $_SESSION['findLineHashMap'];

// Edits the contents of the file with new data
    for ($i = 0; $i < $totalIdNums; $i++) {// loop through all of the ids
        if ($lineID == $i) {// if the searched line id ($i) is the same as the submitted search line id ($lindID)
            $cursorPos = $findLineHashMap[$i];
            // uses strpos the loop through the original file's contents to find the text that was changed ($originalText).
            //Returns the position of the first occurrence of a string inside another string, or FALSE if the string is not found.
            while ($cursorPos = strpos($content, $originalText, $cursorPos)) {  // strpos(string,find,start)
                if ($cursorPos == $findLineHashMap[$i]) {  // if the position of the search text is equal to the position of the $originalText original location

                    // $finalContent holds the changed string of the original file's contents.
                    // substr_replace takes the original file's contents and insert the changed text at the location of the originalText
                    $finalContent = substr_replace($content, $newText, $findLineHashMap[$i], strlen($originalText));// substr_replace(string,replacement,start,length)
                }// else update the start search position
                $cursorPos++;
            }
        }
    }

    $_SESSION["finalContent"] = $finalContent;


// create temporary file to save edits
    $filePath = strstr($_SESSION["path"],'.', true);
    if(strpos($filePath,"TEMP") === false) {
        $filePath = $filePath . "TEMP.json";// append temp to a new temporary file
    }else{
        $filePath = $filePath.".json"; // continue to use temp file
    }
    $tempFile = fopen($filePath, "w");
    fwrite($tempFile, $finalContent) or die("Unable to open file!");
    fclose($tempFile);




    echo $filePath;

}


function setUpNavLinks($path){
    echo file_get_contents($path);
}
?>
