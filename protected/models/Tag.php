<?php

namespace app\models;

use Yii;
use yii\helpers\Url;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "{{%tag}}".
 *
 * @property string $id
 * @property string $name
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tag}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }
	
	static public function getListData() {
		return \yii\helpers\ArrayHelper::map(self::find()->all(), 'id', 'name');
	}
	
	public function behaviors() {
		return [
			[
				'class' => SluggableBehavior::className(),
				'attribute' => 'name',
				'ensureUnique' => true,
				'immutable'=>false,
				// 'slugAttribute' => 'slug',
			],
		];
	}
	
    public function getUrl() {
        return Url::to(['/blog/tag', 'slug' => $this->slug]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['id' => 'post_id'])
            ->viaTable('{{%post_tag}}', ['tag_id' => 'id']);        
    }    
}
