<?php

namespace app\models;

use Yii;
use app\components\ImageHelper;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property string $id
 * @property string $username
 * @property string $password
 * @property integer $status
 * @property string $create_time
 * @property string $login_time
 * @property string $limage
 *
 * @property Post[] $posts
 */
class User extends \yii\db\ActiveRecord
{
	const UPLOAD_DIR = 'media/user';
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['create_time', 'login_time'], 'safe'],
            [['username'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'login_time' => 'Login Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['author_id' => 'id']);
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
			ImageHelper::resize($srcImg, $imgFile, $width, $height, array('fit'=>false));
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
    protected function generateImagePath($width=null, $height=null, $watermark=false) {
        $paths = array(
            0 => Yii::getAlias('@webroot'),
            1 => self::UPLOAD_DIR,
            2 => $this->id,
            3 => "{$width}x{$height}",
            4 => $this->image
        );
		if ($watermark)
			$paths[4] = 'w'.$paths[4];
        if (!$width && !$height)
            unset ($paths[3]);
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
            1 => self::UPLOAD_DIR,
            2 => $this->id,
            3 => "{$width}x{$height}",
            4 => $this->image
        );
		if ($watermark)
			$paths[4] = 'w'.$paths[4];
        if (!$width && !$height)
            unset ($paths[2]);
        return implode('/', $paths);
    }
	
}
