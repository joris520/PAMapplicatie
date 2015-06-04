<?php

/**
 * Description of ImageUtils
 *
 * @author ben.dokter
 */

class ImageUtils {

    static function getAllowedImageExtensions()
    {
        return array(".jpg", ".png", ".gif");
    }

    static function getImageSizeFromFile($file)
    {
        return getimagesize($file);
    }

    static function calculateLogoSize($file_width, $file_height, $default_width, $default_height)
    {
        if (($file_width > $default_width) || ($file_height > $default_height)) {
            $width_factor = $file_width / $default_width;
            $height_factor =  $file_height / $default_height;
            // de grootste schaalfactor gebruiken
            $scale_factor = max($width_factor, $height_factor);
            $new_width = round($file_width / $scale_factor);
            $new_height = round($file_height / $scale_factor);
        } else {
            $new_width = $file_width;
            $new_height = $file_height;
        }
        $logo_hor_offset = 0;
        $logo_ver_offset = 0;
        return array($new_width, $new_height, $logo_hor_offset, $logo_ver_offset);
    }


    static function calculatePhotoSize($file_width, $file_height, $box_width, $box_height)
    {

        return ImageUtils::calculateLogoSize($file_width, $file_height, $box_width, $box_height);
//        $photo_width = $box_width;
//        $photo_height = $box_height;
//        $photo_width_offset = 0;
//        $photo_height_offset = 0;
//
//        if ($file_width > $file_height) { //
//            $photo_width = round($file_width / ($file_height / $box_height));
//            $photo_width_offset = round(($box_width / 2) - ($photo_width / 2));
//        } else { //(($file_width < $file_height) || ($file_width == $file_height))
//            $photo_height = round($file_height / ($file_width / $box_width));
//            $photo_height_offset = round(($box_height / 2) - ($photo_height / 2));
//        }
//
//        return array($photo_width, $photo_height,
//                     $photo_width_offset, $photo_height_offset);
    }

    /**
     *
     * De source image in memory, met de opgegeven afmetingen
     * @param <type> $image
     * @param <type> $image_width
     * @param <type> $image_height
     *
     * De destination image afmetingen
     * @param <type> $box_width
     * @param <type> $box_height
     *
     * correctie op origineel voor schaling en uitsnede.
     * @param <type> $convert_width
     * @param <type> $convert_height
     * @param <type> $width_offset
     * @param <type> $height_offset
     * @return <type>
     */
    static function rescaleImage($image, $image_width, $image_height, $box_width, $box_height, $convert_width, $convert_height, $width_offset = 0, $height_offset = 0)
    {
        $newImage = imagecreatetruecolor($box_width, $box_height);
        $white = imagecolorallocate($newImage, 255, 255, 255);
        imagefill($newImage, 0, 0, $white);
        imagecopyresampled($newImage, $image, $width_offset, $height_offset, 0, 0, $convert_width, $convert_height, $image_width, $image_height);
        return $newImage;
    }

//    static function rescaleLogo($image, $image_width, $image_height, $request_width, $request_height, $ver_offset = 0, $hor_offset = 0)
//    {
//        $newImage = imagecreatetruecolor($request_width, $request_height);
//        $white = imagecolorallocate($image, 255, 255, 255);
//        imagefill($newImage, 0, 0, $white);
//        imagecopyresampled($newImage, $image, $hor_offset, $ver_offset, 0, 0, $request_width, $request_height, $image_width, $image_height);
//        return $newImage;
//
//    }


//    static function PAMPhotoRescale($simg, $w, $h, $nw, $nh)
//    {
//        $dimg = imagecreatetruecolor($nw, $nh);
//        $wm = $w / $nw;
//        $hm = $h / $nh;
//        $h_height = $nh / 2;
//        $w_height = $nw / 2;
//        if ($w > $h) {
//            $adjusted_width = $w / $hm;
//            $half_width = $adjusted_width / 2;
//            $int_width = $half_width - $w_height;
//            imagecopyresampled($dimg, $simg, -$int_width, 0, 0, 0, $adjusted_width, $nh, $w, $h);
//        } elseif (($w < $h) || ($w == $h)) {
//            $adjusted_height = $h / $wm;
//            $half_height = $adjusted_height / 2;
//            $int_height = $half_height - $h_height;
//            imagecopyresampled($dimg, $simg, 0, -$int_height, 0, 0, $nw, $adjusted_height, $w, $h);
//        } else {
//            imagecopyresampled($dimg, $simg, 0, 0, 0, 0, $nw, $nh, $w, $h);
//        }
//        return $dimg;
//    }

    static function saveImageToJpeg($image, $file)
    {
        return imagejpeg($image, $file, 100);
    }

    static function getJpegInMemory($image)
    {
        // use output buffering to capture outputted image stream
        ob_start();
        ImageUtils::saveImageToJpeg($image, null);
        $contents_size = ob_get_length();
        $contents = ob_get_clean();
        return array($contents_size, $contents);
    }

    static function getImageInMemory($image_file, $image_mimetype)
    {
        switch ($image_mimetype) {
            case 'image/gif':
                $mem_img = imagecreatefromgif($image_file);
                break;
            case 'image/jpg':
            case 'image/jpeg':
            case 'image/pjpeg':
                $mem_img = imagecreatefromjpeg($image_file);
                break;
            case 'image/png':
                $mem_img = imagecreatefrompng($image_file);
                break;
        }
        return $mem_img;
    }

    // hbd: stond eerst in scoreboard.php...
    // todo: refactor zonder files...
    function rotateImageFile($sourceFile, $destImageName, $degreeOfRotation) {
        //function to rotate an image in PHP
        //developed by Roshan Bhattara (http://roshanbh.com.np)
        //get the detail of the image
        $imageinfo = getimagesize($sourceFile);
        switch ($imageinfo['mime']) {
            //create the image according to the content type
            case "image/jpg":
            case "image/jpeg":
            case "image/pjpeg": //for IE
                $src_img = imagecreatefromjpeg("$sourceFile");
                break;
            case "image/gif":
                $src_img = imagecreatefromgif("$sourceFile");
                break;
            case "image/png":
            case "image/x-png": //for IE
                $src_img = imagecreatefrompng("$sourceFile");
                break;
        }
        //rotate the image according to the spcified degree
        $src_img = imagerotate($src_img, $degreeOfRotation, 0);
        //output the image to a file
        imagejpeg($src_img, $destImageName);
    }

}
?>
