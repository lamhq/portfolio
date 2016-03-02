<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\components;

/**
 * Helper functions for image
 *
 * @author Lam Huynh
 */
class ImageHelper {
	
	/**
	 * Resize image fit/fill to extract dimension but keep the ratio
	 * @author Lam Huynh
	 * 
	 * @param string $srcImg absolute file name to the source image file
	 * @param string $dstImg absolute file name to the destination image file
	 * @param int $width width of destination image
	 * @param int $height height of destination image
	 * @param array $options other options
	 *    boolean $fit
	 *       If true, fill the gap in destination image with white padding 
	 *           http://stackoverflow.com/questions/3050952/resize-an-image-and-fill-gaps-of-proportions-with-a-color
	 *       If false, crop the edge of source image to fill the dimension
	 * 
	 *    string $watermarkFile file path to watermark file
	 */
	static public function resize($srcImg, $dstImg, $width, $height, $options=array()) {
		if (!is_file($srcImg)) return false;
		if (!file_exists(dirname($dstImg))) 
			mkdir(dirname($dstImg));
		
		$setting = array_merge(array(
			'fit' => true,
			'watermarkFile' => null
		), $options);
		
		$fit = $setting['fit'];
		$watermarkFile = $setting['watermarkFile'];
		
		// load image from disk
		$newWidth = $width;
		$newHeight = $height;
		$image_type = exif_imagetype($srcImg);
		switch ($image_type) {
			case IMAGETYPE_GIF: 
				$old = imagecreatefromgif($srcImg); 
				break;
			case IMAGETYPE_JPEG: 
				$old = imagecreatefromjpeg($srcImg);  
				break;
			case IMAGETYPE_PNG: 
				$old = imagecreatefrompng($srcImg); 
				break;
			default: 
				return;  
				break;
		}
		// auto rotate image
		$exif = @exif_read_data($srcImg);
		$white = imagecolorallocate($old, 255, 255, 255);
		if(!empty($exif['Orientation'])) {
			switch($exif['Orientation']) {
				case 8:
					$old = imagerotate($old,90,$white);
					break;
				case 3:
					$old = imagerotate($old,180,$white);
					break;
				case 6:
					$old = imagerotate($old,-90,$white);
					break;
			}
		}
		$oldWidth = imagesx($old);
		$oldHeight = imagesy($old);

		// resize image
		$new = imagecreatetruecolor($newWidth, $newHeight);
		$white = imagecolorallocate($new, 255, 255, 255);
		imagefill($new, 0, 0, $white);
		if ($fit) {
			// fit image to extract dimension (add padding)
			if (($oldWidth / $oldHeight) >= ($newWidth / $newHeight)) {
				// by width
				$nw = $newWidth;
				$nh = $oldHeight * ($newWidth / $oldWidth);
				$nx = 0;
				$ny = round(abs($newHeight - $nh) / 2);
			} else {
				// by height
				$nw = $oldWidth * ($newHeight / $oldHeight);
				$nh = $newHeight;
				$nx = round(abs($newWidth - $nw) / 2);
				$ny = 0;
			}
			imagecopyresampled($new, $old, $nx, $ny, 0, 0, $nw, $nh, $oldWidth, $oldHeight);
		} else {
			// fill image to extract dimension (crop)
			if (($oldWidth / $oldHeight) >= ($newWidth / $newHeight)) {
				// by height
				$oh = $oldHeight;
				$ow = $oh * ($newWidth / $newHeight);
				$ox = round(abs($ow - $oldWidth) / 2);  // crop from center
				$oy = 0;
			} else {
				// by width
				$ow = $oldWidth;
				$oh = $ow * ($newHeight / $newWidth);
				// $oy = round(abs($oh - $oldHeight) / 2);  // crop from middle
				$oy = 0;
				$ox = 0;
			}
			imagecopyresampled($new, $old, 0, 0, $ox, $oy, $newWidth, $newHeight, $ow, $oh);
		}
		
		// add watermark to source image
		if ($watermarkFile)
			self::addWatermark($new, $watermarkFile);
		
		// save image to disk
		switch ($image_type) {
			case 1: 
				$old = imagegif($new, $dstImg);
				break;
			case 2: 
				$old = imagejpeg($new, $dstImg);
				break;
			case 3: 
				$old = imagepng($new, $dstImg); 
				break;
			default: 
				break;
		}		 
	}
	
	/**
	 * Add watermark to image resource
	 *
	 * @author Lam Huynh
	 * @param resource $image
	 * @param string $watermarkFile file path to watermark file. only support png
	 */
	static public function addWatermark($image, $watermarkFile) {
		if (!is_file($watermarkFile)) return false;
		$watermark = imagecreatefrompng($watermarkFile);

		// calculate watermark size to make it always viewable
		$wWidth = min(imagesx($image)/3, imagesx($watermark));
		$wHeight = $wWidth * imagesy($watermark) / imagesx($watermark);
		
		// calculate watermark position to make it center the image
		$dst_x = (imagesx($image) - $wWidth) / 2;
		$dst_y = (imagesy($image) - $wHeight) / 2;

		// Copy the stamp image onto our photo using the margin offsets and the photo 
		// width to calculate positioning of the stamp. 
		imagecopyresampled($image, $watermark, 
			$dst_x, $dst_y, 0, 0, 
			$wWidth, $wHeight, imagesx($watermark), imagesy($watermark));
		return true;
	}
	
}
