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
$newText = filter_input(INPUT_POST,'text_change');
echo "1: ".$newText."<br>";
$originalText = filter_input(INPUT_POST, 'originalText');
echo "2: ".$originalText."<br>";
$lineID = filter_input(INPUT_POST, 'lineID');
echo "3: ".$lineID."<br>";
$cursorPos = 0;
$path = "jsonFiles/test.json";
$myfile = fopen($path, "r") or die("Unable to open file!");

$quote = "\"";
$debug = "";
$idNum = 0;
$totalIdNums = 0;
$lineLengthLeft = 0;
$lineLengthRight = 0;
$totalLineLength = 0;
$formattedContent = "";
$content = "";
$finalContent = "";
$docHTML = new DOMDocument();
$findLineHashMap = array();
$findStringPosHashMap = array();
while(!feof($myfile)) {
    $line = fgets($myfile);
    $content .= $line;

    $patterns = '/[\{\}\[\]\n\r]/';
    $formattedLine = preg_replace($patterns," ",$line);
    $patterns = '/(^\'|\'$|^, |, $|^,|,$)/';
    $formattedLine = preg_replace($patterns," ",$formattedLine);
    $patterns = "/\r\n|\r|\n/";
    $formattedLine = preg_replace($patterns," ",$formattedLine);
    $formattedLine = trim($formattedLine);
    if(str_word_count($formattedLine) > 0 || is_numeric($formattedLine) || strlen($formattedLine) > 0) {

        $currLineLeft = strstr($formattedLine, ":", true);
        $pattern = "/(^\"|\"$)/";
        $currLineLeft = preg_replace($pattern, " ", $currLineLeft);
        $currLineLeft = trim($currLineLeft);


        $currLineRight = strstr($formattedLine, ":", false);
        $pattern = "/(^\"|\"$|^\:)/";
        $currLineRight = preg_replace($pattern, " ", $currLineRight);
        $currLineRight = trim($currLineRight);
//        $formattedContent .= "<p id=".$idNum.">".$formattedLine."</p>"."<br>";

        //strpos($content, $originalText, $cursorPos)
//        $lineLengthLeft = strlen(strstr($line, ":", true));
//        $lineLengthRight = strlen(strstr($line, ":", false));




        $totalLineLength =$lineLengthLeft;
        if (strlen($currLineLeft) > 0) {
            if(array_key_exists($currLineLeft,$findStringPosHashMap)){//key,array
                $lineLengthLeft = strpos($content, $currLineLeft, $findStringPosHashMap[$currLineLeft]);
                $findStringPosHashMap[$currLineLeft] = $lineLengthLeft + 1;
            }else{
                $findStringPosHashMap[$currLineLeft] = strpos($content, $currLineLeft);
                $lineLengthLeft = $findStringPosHashMap[$currLineLeft];
            }




            $formattedContent .= "<span class='editArea' id=" . $idNum . ">" .$currLineLeft . "</span> : "."<br>";
            $findLineHashMap[$idNum] = $lineLengthLeft;
            $idNum++;

        }else{
            $debug .= $idNum."-".$currLineLeft."--".strlen($currLineLeft)."<br>";
        }
        $totalLineLength=$lineLengthRight;
        if (strlen($currLineRight) > 0) {
//            $lineLengthRight = strpos($content, $currLineRight);
            if(array_key_exists($currLineRight,$findStringPosHashMap)){//key,array
                $lineLengthRight = strpos($content, $currLineRight, $findStringPosHashMap[$currLineRight]);
                $findStringPosHashMap[$currLineRight] = $lineLengthRight + 1;
            }else{
                $findStringPosHashMap[$currLineRight] = strpos($content, $currLineRight);
                $lineLengthRight = $findStringPosHashMap[$currLineRight];
            }
            $formattedContent .= "<span class='editArea' id=" . $idNum . ">" .$currLineRight . "</span>" . "<br>";
            $findLineHashMap[$idNum] = $lineLengthRight;
            $idNum++;
        }else{
            $debug .= $idNum."-".$currLineRight."--".strlen($currLineRight)."<br>";
        }
    }else{

        $debug .= $idNum."-".$formattedLine."--".strlen($formattedLine)."<br>";
    }
    $totalIdNums = $idNum;
}
$strhtml = $formattedContent;
$docHTML->loadHTML($strhtml);
echo "DOC: ";
for($i = 0;$i < $totalIdNums; $i++) {
    echo $i."-".$findLineHashMap[$i]."<br>  ";
}

// loop through content append id-nums; find and replace selceted string with id; remove ids from multi select
$cursorPos = 0;
$helperContent = "";
$start = 0;
$size = strlen($content);

while ($start< $size){

    $start++;
}
while($cursorPos = strpos($content, $originalText, $cursorPos)){
echo $cursorPos."-".$originalText."<br>";
    substr_replace($content,$cursorPos,-1,0);
$cursorPos++;
}
//echo "SUP<br>".$content."<br>";
echo "1--------------------------------------------------------<br>";

//    $i = 0;
//    $searchElm = $docHTML->getElementById($lineID);
//    echo "$searchElm: " . $searchElm;
// Check the rest of the string for $find
// while($cursorPos = strpos($fileContent, $find, $cursorPos)){
// echo $cursorPos."CP<br>";
for($i = 0;$i < $totalIdNums; $i++) {
    $currentElm = $docHTML->getElementById($findLineHashMap[$i]);
//    echo "currentElm: ".$i."--".$findLineHashMap[$i]."<br>";
//    print_r($currentElm);

//    $nodeValue = $currentElm->nodeValue;
//    $textContent = $currentElm->textContent;
//    echo "NODE: ". $nodeValue.",  content->".$textContent."<br>";
    if($lineID == $i){
        $cursorPos = 0;
        // Check the rest of the string for $find
    while($cursorPos = strpos($content, $originalText, $cursorPos)){
        echo $cursorPos."CP ".$findLineHashMap[$i]."<br>";
        if($cursorPos == $findLineHashMap[$i]) {
            echo "Found ";

//            substr_replace(string,replacement,start,length)
           $finalContent = substr_replace($content,$newText,$findLineHashMap[$i],strlen($originalText));
//            substr_replace($originalText,$newText,$findLineHashMap[$i]);
        }
        $cursorPos++;
    }
        //str_replace(find,replace,string,count)
//        str_replace(find,replace,string,count);
        //substr_replace(string,replacement,start,length)
        $newContent = substr_replace($originalText,$newText,$findLineHashMap[$i]);
        echo "NEW: ".$newContent."<br>";
//        echo "EDIT THIS With: ". $newText."<br>";
//        $currentElm->textContent = $newText;
//        echo "new: ".$currentElm->textContent;
    }

//    print_r($currentElm);
}
// Check the rest of the string for $find
//    while($cursorPos = strpos($content, $find, $cursorPos)){
//       echo $cursorPos."CP<br>";
//       if($cursorPos == 22) {
////           //original string, replacement string, starting point) and one that's optional (length)
////           $newContents = str_replace($content, $find, $cursorPos);
////           echo $newContents."<br>";
//        fseek($myfile,$cursorPos);
//        echo fpassthru($myfile)."<br><br>";
//       }
////
//
//        $cursorPos++;
//
//}
//print_r(file($path));

//fclose($myfile);
//-------------------------------------------------------------------
//$myfile = fopen($path, "r") or die("Unable to open file!");
//$content = fread($myfile, filesize($path));
//fclose($myfile);
//echo $content;

echo "<br>2--------------------------------------------------------<br>";
//str_replace(find,replace,string,count)

function editContent($find,$lineID, $replace, $fileContent, $docHTML, $myfile){
    // str_replace(find,replace,searched,count)
    str_replace($find, $replace, $fileContent, $count);
    echo "count: " . $count . "<br>";
    if ($count == 1) {
        return str_replace($find, $replace, $fileContent, $count);
    } else {// more than one occurrence of the $find string
        // get the element with id="dv1"

// create a unformmatted string
        //add ids with stringlen || bytyes || currsorPos
        //use unformattd str to find and replace new conent
        // overwrite save file
//        $cursorPos = 0;
//        ftell($myfile);
        // First check if there is a $find at position 0.
//    if(strpos($fileContent, $find) == 0){
//        echo $cursorPos."<br>";
//        $cursorPos++;
//    }

        $i = 0;
        $searchElm = $docHTML->getElementById($lineID);
        echo "$searchElm: ".$searchElm;
    // Check the rest of the string for $find
   // while($cursorPos = strpos($fileContent, $find, $cursorPos)){
      // echo $cursorPos."CP<br>";

        $currentElm = $docHTML->getElementById($i);
        echo "$currentElm: ".$currentElm;
        if($currentElm === $searchElm){
            $cnt = $searchElm->nodeValue;
                //original string, replacement string, starting point) and one that's optional (length)

    //            $newContents = substr_replace($fileContent, $replace, $cursorPos);
//           echo $newContents."<br>";
        }
          // if($cursorPos == 22) {
               // get the  content

//           //original string, replacement string, starting point) and one that's optional (length)
//           $newContents = str_replace($content, $find, $cursorPos);
//           echo $newContents."<br>";
//        fseek($myfile,$cursorPos);
//        echo fpassthru($myfile)."<br><br>";
       //}
//

//        $cursorPos++;

}
    //}

}


//$find = "links";
//$searchArea = "";
//$replace = "link";
//$cursorPos = 0;
//str_replace($find,$replace, $content, $count);
//echo "count: ".$count."<br>";
//if($count == 1) {
//$content =  str_replace($find,$replace, $content,$count);
//}else {// more than one occurrence of the $find string
//    $searchArea = fpassthru($content);
    //    strpos(string,find,start)
//    $lastPos = strrpos($content, $find, $cursorPos);
//    echo "Last Pos ".$lastPos."<br>";
//    while ($cursorPos <= $lastPos){
////        echo $cursorPos." cpf<br>";
////print a str from tjhis pos
//        $cursorPos = strpos($content, $find, $cursorPos) + 1;
//        echo $cursorPos." cps<br>";
//    }

//while(!feof($myfile)) {
//    echo fgets($myfile) . "1<br>";
//}
//    // First check if there is a $find at position 0.
//    if(strpos($content, $find) == 0){
//        echo $cursorPos."<br>";
//        $cursorPos++;
//    }
//
//// Check the rest of the string for $find
//    while($cursorPos = strpos($content, $find, $cursorPos)){
//       echo $cursorPos."CP<br>";
//       if($cursorPos == 22) {
////           //original string, replacement string, starting point) and one that's optional (length)
////           $newContents = str_replace($content, $find, $cursorPos);
////           echo $newContents."<br>";
//        fseek($myfile,$cursorPos);
//        echo fpassthru($myfile)."<br><br>";
//       }
////
//
//        $cursorPos++;
//
//}
//echo $count."<br>";
//echo ftell($myfile)."<br>";
//echo fseek($myfile,0)."<br>";
//echo ftell($myfile)."<br>";
//echo $content."<br>".filesize($path);

//$myfile = fopen($path, "w") or die("Unable to open file!");
////fwrite(file,string,length)
//fwrite($myfile,$content);
//fclose($myfile);
// widen search until unique
// keep orginal dind/replace string same
// make sure ending string has 1 space if nessary


//// Output one line until end-of-file
//while(!feof($myfile)) {
//    echo fgets($myfile) . "<br>";
//}
//
//fclose($myfile);

//$myfile = file($path);
//foreach ($myfile as $line){
//    echo $line."<br>";
//}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>JSON Uploader</title>
    <link rel="stylesheet" type="text/css" href="bootstrap.css">


</head>
<body class="panel-body">
<header class="page-header">

</header>
<h1 class="h1">Getting Started</h1>
<main>

<?php echo $formattedContent; ?>

</main>
<?php //echo $debug; ?>
<footer></footer>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="GetJSON.js" ></script>
<script src="TransverseJSON.js" ></script>
<script src="EditScripts.js" ></script>
<script>setUpEditor();</script>
</body>
</html>


