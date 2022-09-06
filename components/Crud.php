<?php

namespace app\components;

use Yii;
use yii\db\ActiveQuery;
use yii\web\NotFoundHttpException;
use yii\base\Component as BaseComponent;

class Crud extends BaseComponent
{
    public static function store(&$newModel, $post, $staticAttributes = [])
    {
        if (!$newModel->load($post)) {
            return null;
        }
        //
        $newModel->setAttributes($staticAttributes, false);
        return $newModel->save();
    }

    public static function findOrFail(ActiveQuery $query)
    {
        $model = $query->one();
        if ($model) {
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
    }
}
