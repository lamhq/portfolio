<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%subscriber}}".
 *
 * @property string $id
 * @property string $email
 */
class Subscriber extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%subscriber}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email'], 'required', 'on' => 'insert', 'message'=>'You must enter an email address.'],
            [['email'], 'email', 'message'=>'This is not an valid email address.'],
            [['email'], 'unique', 'message'=>'This email address had been registered.'],
            [['email'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
        ];
    }
}
