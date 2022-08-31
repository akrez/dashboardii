<?php

namespace app\models;

use yii\db\ActiveRecord as BaseActiveRecord;

class ActiveRecord extends BaseActiveRecord
{
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        if ($this->isNewRecord) {
            if ($this->hasAttribute('created_at')) {
                $this->created_at = \date('Y-m-d H:i:s');
            }
        }
        if ($this->hasAttribute('updated_at')) {
            $this->updated_at = \date('Y-m-d H:i:s');
        }

        return true;
    }

    public function attributeLabels()
    {
        return Model::attributeLabelsList();
    }
}
