<?php

namespace portfolio\models;

use Yii;

/**
 * This is the model class for table "{{%project_banner}}".
 *
 * @property string $project_id
 * @property string $banner_id
 */
class ProjectBanner extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%project_banner}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'banner_id'], 'required'],
            [['project_id', 'banner_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'project_id' => 'Project ID',
            'banner_id' => 'Banner ID',
        ];
    }
}
