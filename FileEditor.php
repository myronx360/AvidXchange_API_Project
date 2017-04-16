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
$path = filter_input(INPUT_POST, 'suggest');




static $totalIdNums = 0;
static $content = "";
$findLineHashMap = array(); // holds an idNum as a key and a line of text as a value
$finalContent = "";
if(isset($path) && $path != "") setUpJsonText($path);
function setUpJsonText($path){
    global $findLineHashMap;
    static $content;
    global $totalIdNums;


    $myfile = fopen($path, "r") or die("Unable to open file!");
    $idNum = 0;
    $formattedContent = "";
    $lineLengthLeft = 0;
    $lineLengthRight = 0;




    $findStringPosHashMap = array(); // Each line is added as a key and its location (in bytes/chars) in the file is stored as a value.
    //  Made so that lines with the same text could be changed without conflict

    /**  */
    while (!feof($myfile)) { // Loop until the end of the file
        $line = fgets($myfile);     // capture the current line for displaying/editing

        $content.= $line;          // content holds the original contents of the file

        // patterns and preg_replace remove special characters from the line to be displayed and stored in $formattedLine
        $patterns = '/[\{\}\[\]\n\r]/';
        $formattedLine = preg_replace($patterns, " ", $line);
        $patterns = '/(^\'|\'$|^, |, $|^,|,$)/';
        $formattedLine = preg_replace($patterns, " ", $formattedLine);
        $patterns = "/\r\n|\r|\n/";
        $formattedLine = preg_replace($patterns, " ", $formattedLine);
        $formattedLine = trim($formattedLine);


        if (str_word_count($formattedLine) > 0 || is_numeric($formattedLine) || strlen($formattedLine) > 0) {// if something is there after formatting

            // $currLineLeft holds the sub-string that is left of ':' in the $formattedLine
            $currLineLeft = strstr($formattedLine, ":", true); //strstr(string,search,before_search)
            $pattern = "/(^\"|\"$)/";
            $currLineLeft = preg_replace($pattern, " ", $currLineLeft);
            $currLineLeft = trim($currLineLeft);


            if (strlen($currLineLeft) > 0) { // if something is there after formatting
                if (array_key_exists($currLineLeft, $findStringPosHashMap)) {//(key,array)  if the line has been added to the array already
                    // get the strpos of this line...
                    $lineLengthLeft = strpos($content, $currLineLeft, $findStringPosHashMap[$currLineLeft]);  //strpos(string,find,start)
                    $findStringPosHashMap[$currLineLeft] = $lineLengthLeft + 1; // and update the value of the pos so the next instance of the same line can be found and updated
                } else { // add the line's text as a key and set its value as the strpos()
                    $findStringPosHashMap[$currLineLeft] = strpos($content, $currLineLeft);
                    $lineLengthLeft = $findStringPosHashMap[$currLineLeft];
                }

                // $formattedContent holds what is displayed on an HTML webpage
                $formattedContent .= "<span class='editArea' id=" . $idNum . ">" . $currLineLeft . "</span> : " . "<br>";
                $findLineHashMap[$idNum] = $lineLengthLeft; // assigns a line of text to an $idNum
                $idNum++;
            }

            // $currLineRight holds the sub-string that is right of ':' in the $formattedLine
            $currLineRight = strstr($formattedLine, ":", false); //strstr(string,search,before_search)
            $pattern = "/(\")/";
            $currLineRight = preg_replace($pattern, " ", $currLineRight,1);
//            $pattern = '\\"';
//            $currLineRight = preg_replace($pattern, '"', $currLineRight);
            $pattern = "/(\\n)/";
            $currLineRight = preg_replace($pattern, "<br>", $currLineRight);
            $pattern = "/(^\"|\"$|^\:)/";
            $currLineRight = preg_replace($pattern, " ", $currLineRight);
            $currLineRight = trim($currLineRight);

            if (strlen($currLineRight) > 0) {// if something is there after formatting
                if (array_key_exists($currLineRight, $findStringPosHashMap)) {//key,array {//(key,array)  if the line has been added to the array already
                    // get the strpos of this line...
                    $lineLengthRight = strpos($content, $currLineRight, $findStringPosHashMap[$currLineRight]); //strpos(string,find,start)
                    $findStringPosHashMap[$currLineRight] = $lineLengthRight + 1;// and update the value of the pos so the next instance of the same line can be found and updated
                } else { // add the line's text as a key and set its value as the strpos()
                    $findStringPosHashMap[$currLineRight] = strpos($content, $currLineRight);
                    $lineLengthRight = $findStringPosHashMap[$currLineRight];
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
//    print_r($findLineHashMap);
//    $serialFindLineHashMap = json_encode($findLineHashMap);
//    echo $serialFindLineHashMap;
//    echo "<input type='hidden' name='totIDs' value='.$totalIdNums.'>";
//    $contentTag = "<input type='hidden' name='orgContent' value=".$content.">";
//    echo $contentTag;
    $_SESSION['totIDs'] = $totalIdNums;
    $_SESSION['orgContent'] = $content;
    $_SESSION['findLineHashMap'] = $findLineHashMap;
//    echo "<input type='hidden' name='findLineHashMapw' value='.$serialFindLineHashMap.'>";
//    foreach($findLineHashMap as $idx=>$value) {
//        $id=htmlentities('findLineHashMap['.$idx.']');
//        $val=htmlentities($value);
//        echo '<input type="hidden" name="'.$id.'" value="'.$val.'">';
//
//    }



//    fclose($myfile);
}

//header location this #@edit
if(isset($_POST["newText"])){
//    $newText = filter_input(INPUT_POST, 'newText');
//    $originalText = filter_input(INPUT_POST, 'originalText');
//    $lineID = filter_input(INPUT_POST, 'lineID');
//    $totalIdNums = filter_input(INPUT_POST, 'totID');
//    $content = filter_input(INPUT_POST, 'orgContents');
//    $findLineHashMap = $_SESSION['findLineHashMap'];
//    print_r( $findLineHashMap);
//    echo $content;
//    $findLineHashMap = unserialize(filter_input(INPUT_POST, '$findLineHashMapS'));
//    echo "ID: ".json_decode($_POST["$findLineHashMapS"]);
//    echo "oc: ".$_POST["$findLineHashMapS"];
//    echo $newText."--".$originalText."---".$lineID;
//    echo $totalIdNums."<br>--content<br>".$content."---<br>";
//    editContent($totalIdNums, $content,$findLineHashMap);
    editContent();

}

function editContent(){

//if(isset($newText)) {
//     $totalIdNums;
//    static $content;
//    global $findLineHashMap;
    $finalContent = "";

    $newText = filter_input(INPUT_POST, 'newText');
    $originalText = filter_input(INPUT_POST, 'originalText');
    $lineID = filter_input(INPUT_POST, 'lineID');
//    $totalIdNums = filter_input(INPUT_POST, 'totID');
//    $content = filter_input(INPUT_POST, 'orgContents');
    $totalIdNums = $_SESSION['totIDs'];
    $content = $_SESSION['orgContent'];
    $findLineHashMap = $_SESSION['findLineHashMap'];
//    echo "<br>1." . $newText . "<br>";
//    echo "2." . $originalText . "<br>";
//    echo "3." . $lineID . "<br>";
//    echo "4." . $totalIdNums . "<br>";
//    echo "5." . $content . "<br>";

// Edits the contents of the file with new data
    for ($i = 0; $i < $totalIdNums; $i++) {// loop through all of the ids
        if ($lineID == $i) {// if the searched line id ($i) is the same as the submitted search line id ($lindID)
            $cursorPos = 0;

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
    echo $finalContent;
//    global $dir;
//    global $path;
//    $myfile = fopen($path, "w") or die("Unable to open file!");
//    fwrite($myfile,$content);//fwrite(file,string,length)
//    fclose($myfile);

    $myfile = fopen("jsonFiles/newJson.json", "w") or die("Unable to open file!");
    fwrite($myfile, $finalContent);//fwrite(file,string,length)
    fclose($myfile);
//    header("location: index.php");
//    return $finalContent;
//}
}
?>
