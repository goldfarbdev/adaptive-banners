<?php

/**
 * Created by PhpStorm.
 * User: Greg.Goldfarb
 * Date: 6/27/17
 * Time: 7:18 PM
 */
class ADAPTIVEBANNER
{

    public static function createDirectory($storeFolder)
    {
        $ds = DIRECTORY_SEPARATOR;
        $dir = dirname(__FILE__) . $ds . $storeFolder . $ds;  //4
        $imageDir = $dir . $ds .'images' . $ds;

        if (!file_exists($dir)) {
            mkdir($storeFolder, 0777);
        }
        if (!file_exists($imageDir)) {
            mkdir($imageDir, 0777);
        }
        return $dir;
    }

    public static function createHTMLFile($dir, $output)
    {

        fopen($dir, "w+");
        file_put_contents($dir, $output);
    }

    /**
     * Add files and sub-directories in a folder to zip file.
     * @param string $folder
     * @param ZipArchive $zipFile
     * @param int $exclusiveLength Number of text to be exclusived from the file path.
     */
    private static function folderToZip($folder, &$zipFile, $exclusiveLength)
    {
        $handle = opendir($folder);
        while (false !== $f = readdir($handle)) {
            if ($f != '.' && $f != '..') {
                $filePath = "$folder/$f";
                // Remove prefix from file path before add to zip.
                $localPath = substr($filePath, $exclusiveLength);
                if (is_file($filePath)) {
                    $zipFile->addFile($filePath, $localPath);
                } elseif (is_dir($filePath)) {
                    // Add sub-directory.
                    $zipFile->addEmptyDir($localPath);
                    self::folderToZip($filePath, $zipFile, $exclusiveLength);
                }
            }
        }
        closedir($handle);
    }

    /* Zip a folder (include itself).
     * Usage:
     *   HZip::zipDir('/path/to/sourceDir', '/path/to/out.zip');
     *
     * @param string $sourcePath Path of directory to be zip.
     * @param string $outZipPath Path of output zip file.
     */
    public static function zipDir($sourcePath, $outZipPath)
    {
        $pathInfo = pathInfo($sourcePath);
        $parentPath = $pathInfo['dirname'];
        $dirName = $pathInfo['basename'];

        $z = new ZipArchive();
        $z->open($outZipPath, ZIPARCHIVE::CREATE);
        $z->addEmptyDir($dirName);
        self::folderToZip($sourcePath, $z, strlen("$parentPath/"));
        $z->close();
        header('Location: http://'.$_SERVER['HTTP_HOST'].'/agency-dev/coupon-page/'.$outZipPath);
    }
}
