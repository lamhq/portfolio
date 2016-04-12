<?php

namespace app\models;

use Yii;
use app\components\Helper;

/**
 * This is the model class for table "{{%banner}}".
 *
 * @property string $id
 * @property string $title
 * @property string $image
 * @property integer $type
 * @property string $link
 * 
 * @property string $imageUrl
 */
class Banner extends \yii\db\ActiveRecord
{
    const TYPE_RIGHT = 1;
    const TYPE_BOTTOM = 2;
    const TYPE_POST = 3;
    const TYPE_PROJECT = 4;
	const UPLOAD_DIR = 'media/banner';
	
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%banner}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'integer'],
            [['title', 'image', 'link'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'image' => 'Image',
            'type' => 'Type',
            'link' => 'Link',
        ];
    }
	
	/*
	 * Return the resized image url
	 * 
	 * @author Lam Huynh
	 */
    public function getImageUrl($width=null, $height=null, $watermark=false) {
        $imgFile = $this->generateImagePath($width, $height, $watermark);
        if (!is_file($imgFile)) {
			// resize image
			$srcImg = $this->generateImagePath();
			Helper::resize($srcImg, $imgFile, $width, $height, array('fit'=>false));
		}
		
        $imgUrl = $this->generateImageUrl($width, $height, $watermark);
        return is_file($imgFile) ? $imgUrl : null;
    }
    
	/*
	 * Generate the filename corresponding to the dimension
	 * Need to change the code when copy to another model
	 * 
	 * @author Lam Huynh
	 */
    public function generateImagePath($width=null, $height=null, $watermark=false) {
        $paths = array(
            0 => Yii::getAlias('@webroot'),
            1 => 'assets',
            2 => self::UPLOAD_DIR,
            3 => $this->id,
            4 => "{$width}x{$height}",
            5 => $this->image
        );
		if ($watermark)
			$paths[5] = 'w'.$paths[5];
        if (!$width && !$height) {
            unset ($paths[1]);
            unset ($paths[4]);
		}
        return implode('/', $paths);
    }
    
	/*
	 * Generate the image url corresponding to the dimension
	 * Need to change the code when copy to another model
	 * 
	 * @author Lam Huynh
	 */
    protected function generateImageUrl($width=null, $height=null, $watermark=false) {
        $paths = array(
            0 => Yii::getAlias('@web'),
            1 => 'assets',
            2 => self::UPLOAD_DIR,
            3 => $this->id,
            4 => "{$width}x{$height}",
            5 => $this->image
        );
		if ($watermark)
			$paths[5] = 'w'.$paths[5];
        if (!$width && !$height) {
            unset ($paths[1]);
            unset ($paths[4]);
		}
        return implode('/', $paths);
    }
	
	public function saveImage() {
		Helper::moveUploadedAjaxFile($this->image, self::UPLOAD_DIR.'/'.$this->id);
	}
	
	static public function getListData() {
		$result = Lookup::items('banner_type');
		unset($result[self::TYPE_POST]);
		return $result;
	}
	
    public function beforeDelete()
    {
        $rm = implode(DIRECTORY_SEPARATOR, [Yii::getAlias('@webroot'), self::UPLOAD_DIR, $this->id]);
		Yii::info(sprintf('remove banner directory: %s', $rm));
		\yii\helpers\FileHelper::removeDirectory($rm);
		return parent::beforeDelete();
    }
	
}
