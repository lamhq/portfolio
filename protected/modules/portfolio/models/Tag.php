<?php

namespace portfolio\models;

class Tag extends \app\models\Tag {
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectTag()
    {
        return $this->hasMany(ProjectTag::className(), ['tag_id' => 'id']);
    }

}
