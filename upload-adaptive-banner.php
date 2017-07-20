<?php
include_once('ADAPTIVEBANNER.php');

$jobNumber = $_POST['job-number'];

if (!empty($_FILES)) {
    $ds = DIRECTORY_SEPARATOR;
    $tempFile = $_FILES['file']['tmp_name'];
    $imageDimensions = getimagesize($tempFile);
    $imgWidth = $imageDimensions[0];
    $imgHeight = $imageDimensions[1];
    $fileName = $jobNumber . '_' . $imgWidth . 'x'. $imgHeight . '.jpg';
    $targetPath = ADAPTIVEBANNER::createDirectory($jobNumber);

    $targetFile =  $targetPath . 'images' . $ds . $fileName;
echo "TARGET FILE is : " . $targetFile;
    if(move_uploaded_file($tempFile,$targetFile)){
        echo "success";
    } else{
        echo "Fail";
    };
}
