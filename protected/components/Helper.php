<?php

namespace app\components;
use Yii;
use yii\helpers\Html;

class Helper {

	/*
	 * convert input date (from view) to database date format
	 */
	public static function toDbDate($value) {
		$d = date_create_from_format(Yii::$app->params['dateFormat'], $value);
		if (!$d) return null;
		return $d->format('Y-m-d H:i:s');
	}
	
	/*
	 * convert datebase date to view format
	 */
	public static function toAppDate($value) {
		$t = strtotime($value);
		if (!$t) return null;
		return date(\Yii::$app->params['dateFormat'], $t);
	}
	
	/*
	 * @author Lam Huynh
	 */
	static public function moveUploadedAjaxFile($file, $toDir) {
		$root = Yii::getAlias('@webroot');
		$src = $root .'/'. Yii::$app->params['ajaxUploadDir'] .'/'. $file;
		$dst = $root . '/' . $toDir . '/' . $file;
		if (!$file || !is_file($src))
			return;
		if (!file_exists(dirname($dst)))
			mkdir(dirname($dst), 0777, true);
		rename($src, $dst);
	}
	
	static protected function loadJpeg($imgname) {
		/* Attempt to open */
		$im = @imagecreatefromjpeg($imgname);

		/* See if it failed */
		if(!$im) {
			/* Create a black image */
			$im  = imagecreatetruecolor(150, 30);
			$bgc = imagecolorallocate($im, 255, 255, 255);
			$tc  = imagecolorallocate($im, 0, 0, 0);

			imagefilledrectangle($im, 0, 0, 150, 30, $bgc);

			/* Output an error message */
			imagestring($im, 1, 5, 5, 'Error loading ' . $imgname, $tc);
		}

		return $im;
	}
	
	
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
			mkdir(dirname($dstImg), 0777, true);
		
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
				$old = self::loadJpeg($srcImg);  
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
	
	/*
	 * Return img html tag with the specified size. Display holder image if url is empty
	 * 
	 * @author Lam Huynh
	 */
	static public function holderImage($url, $width, $height, $options=array()) {
		$options = array_merge(array('class'=>'img-responsive'), $options);
		return Html::img(self::holderUrl($url, $width, $height), 
			'', $options);
	}

	/*
	 * Return no image url for specific size if url is empty
	 * 
	 * @author Lam Huynh
	 */
	static public function holderUrl($url, $width, $height) {
		if ($url) return $url;
		
		$noImg = Yii::getAlias('@webroot').'/media/placeholder/noimage.jpg';
		$resizedImg = Yii::getAlias('@webroot')."/assets/placeholder/{$width}x{$height}.jpg";
		$resizedImageUrl = Yii::getAlias('@web')."/assets/placeholder/{$width}x{$height}.jpg";
		// resize the placeholder image file
		if (!is_file($resizedImg)) {
			self::resize($noImg, $resizedImg, $width, $height);
		}
		return $resizedImageUrl;
	}
	
	/**
	 * Returns a sanitized string, typically for URLs.
	 *
	 * Parameters:
	 *     $string - The string to sanitize.
	 *     $force_lowercase - Force the string to lowercase?
	 *     $anal - If set to *true*, will remove all non-alphanumeric characters.
	 */
	static public function sanitize($string, $force_lowercase = true, $anal = false) {
		$strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
					   "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
					   "â€”", "â€“", ",", "<", ">", "/", "?");
		$clean = trim(str_replace($strip, "", strip_tags($string)));
		$clean = preg_replace('/\s+/', "-", $clean);
		$clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;
		return ($force_lowercase) ?
			(function_exists('mb_strtolower')) ?
				mb_strtolower($clean, 'UTF-8') :
				strtolower($clean) :
			$clean;
	}	
}
