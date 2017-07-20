<?php
/**
 * Created by PhpStorm.
 * User: Greg.Goldfarb
 * Date: 6/27/17
 * Time: 6:15 PM
 */
include_once('ADAPTIVEBANNER.php');
$epochTimeStamp = time();
$releaseDate = $_POST['release-date'];
$jobNumber = $_POST['job-number'];
$bannerType = $_POST['banner-type'];
$bannerHeight = $_POST['banner-height'];
switch ($bannerType) {
    case 'single':
        $ctaURLSingle = $_POST['cta-url-single'];
        $singleBanner = $_POST['clickable'] !== 'true' ? '<div id="cwwbos_full_offer"></div>' : '<a href="' . $ctaURLSingle . '" id="cwwbos_full_offer"></a>';
        $adaptiveBannerHTML = <<<HTML
            <style type="text/css">
                @supportedBrowser: -webkit-, -moz-, -o-, -ms-, '';
                
                .dd-banner-container .dd-banner-inner, .dd-banner-container .dd-banner-inner div, .dd-secondary .dd-banner-inner, .dd-secondary .dd-banner-inner div {
                display: block;
                zoom: 1;
                }
                           
                .cwwbos_cre_content_$epochTimeStamp {
                position: relative;
                width: 1008px;
                height: {$bannerHeight}px;
                min-width: 1008px;
                background: none;
                margin: 0;
                overflow: hidden;
                }
                
                .cwwbos_cre_content_$epochTimeStamp #cwwbos_full_offer {
                    float: left;
                    width: 100%;
                    text-decoration: none;
                    box-sizing: border-box;
                    -moz-box-sizing: border-box;
                    -webkit-box-sizing: border-box;
                    display: block;
                    position: relative;
                    height: {$bannerHeight}px;
                    overflow: hidden;
                }
                
                .cwwbos_cre_content_$epochTimeStamp #cwwbos_full_offer {
                    background: url('/sbd/cre/products/$releaseDate/$jobNumber/images/{$jobNumber}_1008x$bannerHeight.jpg') center center no-repeat;
                }
                
                
                @media only screen and (min-width: 1260px) {
                    .cwwbos_cre_content_$epochTimeStamp {
                        width: 1260px;
                    }
                    .cwwbos_cre_content_$epochTimeStamp #cwwbos_full_offer {
                        background-image: url('/sbd/cre/products/$releaseDate/$jobNumber/images/{$jobNumber}_1260x$bannerHeight.jpg');
                    }
                }
                @media only screen and (min-width: 1512px) {
                    .cwwbos_cre_content_$epochTimeStamp {
                        width: 1512px;
                    }
                    .cwwbos_cre_content_$epochTimeStamp #cwwbos_full_offer {
                        background-image: url('/sbd/cre/products/$releaseDate/$jobNumber/images/{$jobNumber}_1512x$bannerHeight.jpg');
                    }
                }
                @media only screen and (min-width: 1764px) {
                    .cwwbos_cre_content_$epochTimeStamp {
                        width: 1764px;
                    }
                    .cwwbos_cre_content_$epochTimeStamp #cwwbos_full_offer {
                        background-image: url('/sbd/cre/products/$releaseDate/$jobNumber/images/{$jobNumber}_1764x$bannerHeight.jpg');
                    }
                }
                </style>
            <div class="cwwbos_cre_content_$epochTimeStamp">$singleBanner</div>
HTML;
        break;
    case 'double':
        $ctaURLDoubleLeft = $_POST['cta-url-double-left'];
        $ctaURLDoubleRight = $_POST['cta-url-double-right'];
        $doubleLeftBanner = $_POST['clickable'] !== 'true' ? '<div id="cwwbos_left_offer"></div>' : '<a href="'. $ctaURLDoubleLeft .'" id="cwwbos_left_offer"></a>';
        $doubleRightBanner = $_POST['clickable'] !== 'true' ? '<div id="cwwbos_right_offer"></div>' : '<a href="'. $ctaURLDoubleRight .'" id="cwwbos_right_offer"></a>';
        $adaptiveBannerHTML = <<<HTML
            <style type="text/css">
              @supportedBrowser: -webkit-, -moz-, -o-, -ms-, '';
            
              .dd-banner-container .dd-banner-inner, .dd-banner-container .dd-banner-inner div, .dd-secondary .dd-banner-inner, .dd-secondary .dd-banner-inner div {
                display: block;
                zoom: 1;
              }
            
              /* After cwwbos_cre_content append _$epochTimeStamp http://www.unixtimestamp.com/  */
              .cwwbos_double_banner_$epochTimeStamp {
                position: relative;
                width: 1008px;
                height: {$bannerHeight}px;
                min-width: 1008px;
                background: none;
                margin: 0;
                overflow: hidden;
              }
            
              .cwwbos_double_banner_$epochTimeStamp .cwwbos_offer_left {
                width: 500px;
                margin: 0 8px 0 0;
                float: left;
                overflow: hidden;
                height: {$bannerHeight}px;
              }
            
              .cwwbos_double_banner_$epochTimeStamp .cwwbos_offer_right {
                width: 500px;
                margin: 0;
                float: left;
                overflow: hidden;
                height: {$bannerHeight}px;
              }
            
              .cwwbos_double_banner_$epochTimeStamp .cwwbos_offer_left a, .cwwbos_double_banner_$epochTimeStamp .cwwbos_offer_right a {
                width: 99.5%;
                text-decoration: none;
                box-sizing: border-box;
                -moz-box-sizing: border-box;
                -webkit-box-sizing: border-box;
                display: block;
                position: relative;
                height: {$bannerHeight}px;
                overflow: hidden;
                float: left;
              }
            
              .cwwbos_double_banner_$epochTimeStamp #cwwbos_left_offer {
                background: url('/sbd/cre/products/$releaseDate/$jobNumber/images/{$jobNumber}_1008.jpg') center center no-repeat;
              }
            
              .cwwbos_double_banner_$epochTimeStamp #cwwbos_right_offer {
                background: url('/sbd/cre/products/$releaseDate/$jobNumber/images/{$jobNumber}_1008.jpg') center center no-repeat;
              }
            
            
              @media only screen and (min-width: 1260px) {
                 /* Container width */
                .cwwbos_double_banner_$epochTimeStamp {
                  width: 1260px;
                }
            
                /* Indvidual banner widths */
                .cwwbos_double_banner_$epochTimeStamp .cwwbos_offer_left, .cwwbos_double_banner_$epochTimeStamp .cwwbos_offer_right {
                    width: 624px;
                }
            
                /* Offer backgrounds */
                .cwwbos_double_banner_$epochTimeStamp #cwwbos_left_offer {
                  background-image: url('/sbd/cre/products/$releaseDate/$jobNumber/images/{$jobNumber}_1260.jpg');
                }
            
                .cwwbos_double_banner_$epochTimeStamp #cwwbos_right_offer {
                  background-image: url('/sbd/cre/products/$releaseDate/$jobNumber/images/{$jobNumber}_1260.jpg');
                }
              }
              @media only screen and (min-width: 1512px) {
                /* Container width */
                .cwwbos_double_banner_$epochTimeStamp {
                  width: 1512px;
                }
            
                /* Indvidual banner widths */
                .cwwbos_double_banner_$epochTimeStamp .cwwbos_offer_left, .cwwbos_double_banner_$epochTimeStamp .cwwbos_offer_right {
                    width: 752px;
                }
            
                /* Offer backgrounds */
                .cwwbos_double_banner_$epochTimeStamp #cwwbos_left_offer {
                  background-image: url('/sbd/cre/products/$releaseDate/$jobNumber/images/{$jobNumber}_1512.jpg');
                }
            
                .cwwbos_double_banner_$epochTimeStamp #cwwbos_right_offer {
                  background-image: url('/sbd/cre/products/$releaseDate/$jobNumber/images/{$jobNumber}_1512.jpg');
                }
              }
              @media only screen and (min-width: 1764px) {
                 /* Container width */
                .cwwbos_double_banner_$epochTimeStamp {
                  width: 1764px;
                }
            
                /* Indvidual banner widths */
                .cwwbos_double_banner_$epochTimeStamp .cwwbos_offer_left, .cwwbos_double_banner_$epochTimeStamp .cwwbos_offer_right {
                    width: 878px;
                }
            
                /* Offer backgrounds */
                .cwwbos_double_banner_$epochTimeStamp #cwwbos_left_offer {
                  background-image: url('/sbd/cre/products/$releaseDate/$jobNumber/images/{$jobNumber}_1764.jpg');
                }
            
                .cwwbos_double_banner_$epochTimeStamp #cwwbos_right_offer {
                  background-image: url('/sbd/cre/products/$releaseDate/$jobNumber/images/{$jobNumber}_1764.jpg');
                }
              }
            </style>
            
            <div class="cwwbos_double_banner_$epochTimeStamp">
            
                <!-- First offer -->
                <div class="cwwbos_offer_left">
                    $doubleLeftBanner
                </div>
            
                <!-- Second offer -->
                <div class="cwwbos_offer_right">
                    $doubleRightBanner
                </div>
            
            </div>
HTML;
        break;
    case 'triple':
        $ctaURLTripleLeft = $_POST['cta-url-triple-left'];
        $ctaURLTripleMiddle = $_POST['cta-url-triple-middle'];
        $ctaURLTripleRight = $_POST['cta-url-triple-right'];
        $tripleBannerLeft = $_POST['clickable'] !== 'true' ? '<div id="cwwbos_tri_offer_left"></div>' : '<a href="'. $ctaURLTripleLeft .'" id="cwwbos_tri_offer_left"></a>';
        $tripleBannerMiddle = $_POST['clickable'] !== 'true' ? '<div id="cwwbos_tri_offer_mid"></div>' : '<a href="'. $ctaURLTripleMiddle .'" id="cwwbos_tri_offer_mid"></a>';
        $tripleBannerRight = $_POST['clickable'] !== 'true' ? '<div id="cwwbos_tri_offer_right"></div>' : '<a href="'. $ctaURLTripleRight .'" id="cwwbos_tri_offer_right"></a>';
        $adaptiveBannerHTML = <<<HTML
            <style type="text/css">
              @supportedBrowser: -webkit-, -moz-, -o-, -ms-, '';
            
              .dd-banner-container .dd-banner-inner, .dd-banner-container .dd-banner-inner div, .dd-secondary .dd-banner-inner, .dd-secondary .dd-banner-inner div {
                display: block;
                zoom: 1;
              }
            
              /* After cwwbos_cre_content append _$epochTimeStamp http://www.unixtimestamp.com/  */
              .cwwbos_tri_banner_$epochTimeStamp {
                position: relative;
                width: 1008px;
                height: {$bannerHeight}px;
                min-width: 1008px;
                background: none;
                margin: 0;
                overflow: hidden;
              }
            
              .cwwbos_tri_banner_$epochTimeStamp .cwwbos_tri_offer {
                width: 330px;
                height: {$bannerHeight}px;
                margin: 0 8px 0 0;
                float: left;
                overflow: hidden;
                max-height: {$bannerHeight}px;
              }
              
              .cwwbos_tri_banner_$epochTimeStamp .cwwbos_tri_offer.cwwbos_tri_last {
                width: 330px;
                height: {$bannerHeight}px;
                margin: 0;
                border: none;
                float: left;
                overflow: hidden;
              }
            
              .cwwbos_tri_banner_$epochTimeStamp .cwwbos_tri_offer a {
                width: 100%;
                height: {$bannerHeight}px;
                text-decoration: none;
                display: block;
                position: relative;
                overflow: hidden;
                float: left;
              }
              
              /* Change names of these IDs in CSS and on URLs below to describe each offer */
              .cwwbos_tri_banner_$epochTimeStamp #cwwbos_tri_offer_left {
                  background: url(/sbd/cre/products/160103/XXXXX/images/XXXXX_420x90.jpg) top center no-repeat;
              }
              
              .cwwbos_tri_banner_$epochTimeStamp #cwwbos_tri_offer_mid {
                  background: url(/sbd/cre/products/160103/XXXXX/images/XXXXX_420x90.jpg) top center no-repeat;
              }
              
              .cwwbos_tri_banner_$epochTimeStamp #cwwbos_tri_offer_right {
                  background: url(/sbd/cre/products/160103/XXXXX/images/XXXXX_420x90.jpg) top center no-repeat;
              }
            
            
              @media only screen and (min-width: 1260px) {
                .cwwbos_tri_banner_$epochTimeStamp {
                    width: 1260px;
                }
                
                .cwwbos_tri_banner_$epochTimeStamp .cwwbos_tri_offer, .cwwbos_tri_banner_$epochTimeStamp .cwwbos_tri_offer.cwwbos_tri_last {
                    width: 414px;
                }
              }
              @media only screen and (min-width: 1512px) {
                .cwwbos_tri_banner_$epochTimeStamp {
                    width: 1512px;
                }
                
                .cwwbos_tri_banner_$epochTimeStamp .cwwbos_tri_offer, .cwwbos_tri_banner_$epochTimeStamp .cwwbos_tri_offer.cwwbos_tri_last {
                    width: 498px;
                }
                
                .cwwbos_tri_banner_$epochTimeStamp #cwwbos_tri_offer_left {
                  background-image: url(/sbd/cre/products/160103/XXXXX/images/XXXXX_630x90.jpg);
                }
              
                .cwwbos_tri_banner_$epochTimeStamp #cwwbos_tri_offer_mid {
                  background-image: url(/sbd/cre/products/160103/XXXXX/images/XXXXX_630x90.jpg);
                }
              
                .cwwbos_tri_banner_$epochTimeStamp #cwwbos_tri_offer_right {
                  background-image: url(/sbd/cre/products/160103/XXXXX/images/XXXXX_630x90.jpg);
                }
              }
              @media only screen and (min-width: 1764px) {
                .cwwbos_tri_banner_$epochTimeStamp {
                    width: 1764px;
                }
                
                .cwwbos_tri_banner_$epochTimeStamp .cwwbos_tri_offer, .cwwbos_tri_banner_$epochTimeStamp .cwwbos_tri_offer.cwwbos_tri_last {
                    width: 582px;
                }
              }
            </style>
            
            <!-- Tri-mod banner -->
            <div class="cwwbos_tri_banner_$epochTimeStamp">
                
                <!-- First offer -->
                <div class="cwwbos_tri_offer">
                    $tripleBannerLeft
                </div>
                
                <!-- Second offer -->
                <div class="cwwbos_tri_offer">
                    $tripleBannerMiddle
                </div>
                
                <!-- Third offer -->
                <div class="cwwbos_tri_offer cwwbos_tri_last">
                    $tripleBannerRight
                </div>
                
            </div>
HTML;
        break;
}


$ds = DIRECTORY_SEPARATOR;
$fileName = $_POST['job-number'] . '_banner.html';
//$dir = getcwd() . '/' . $jobNumber.'/'.$fileName;
$dir = $_SERVER['DOCUMENT_ROOT'] . '/agency-dev/adaptive-banners/' . $jobNumber . '/' . $fileName;
echo 'DIR is: ' . $dir;
ADAPTIVEBANNER::createHTMLFile($dir, $adaptiveBannerHTML);

//print_r($_FILES);
//$zipFileName = $date1.'.zip';
//HZip::zipDir($dir, $zipFileName);