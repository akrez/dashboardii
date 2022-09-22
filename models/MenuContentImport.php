<?php

namespace app\models;

use Yii;
use yii\db\Transaction;

class MenuContentImport extends Model
{
    public $content;

    public function rules()
    {
        return [
            [['content'], 'required'],
            [['content'], 'safe'],
        ];
    }

    public function import(Menu $parentModel)
    {
        $connection = Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {
            MenuContent::deleteByMenuId($parentModel->id);
            $step = MenuContent::findMaxStep($parentModel->id);
            $header = null;
            foreach ((array)explode("\r\n", $this->content) as $rowKey => $row) {
                if (0 == mb_strlen(trim($row, " "))) {
                    continue;
                }
                $i = 97;
                $cells = [];
                foreach ((array)explode("\t", $row) as $cell) {
                    if ($i > 122) {
                        return static::returnWithError($transaction, $this, ['bishtar az 26']);
                    }
                    $cell = trim($cell);
                    if (0 == mb_strlen($cell)) {
                        $cell = null;
                    }
                    $cells['column_' . chr($i)] = $cell;
                    $i++;
                }
                if (null === $header) {
                    $header = $cells;
                } else {
                    $model = new MenuContent();
                    $model->load($cells, '');
                    $model->menu_id = $parentModel->id;
                    $model->step = $step;
                    if ($model->save()) {
                        unset($model);
                    } else {
                        return static::returnWithError($transaction, $this, $model->getErrorSummary(true));
                    }
                }
            }

            if ($header and $parentModel->saveHeaders($header)) {
            } else {
                return static::returnWithError($transaction, $this, [$parentModel->getErrorSummary(true)]);
            }

            return static::returnWithSuccess($transaction);
        } catch (\Throwable $th) {
            return static::returnWithError($transaction, $this, [$th->getMessage()]);
        }
    }

    private static function returnWithError($transaction, MenuContentImport $model,  $messages)
    {
        $model->addErrors(['content' => $messages]);
        $transaction->rollBack();
        return false;
    }

    private static function returnWithSuccess(Transaction $transaction)
    {
        $transaction->commit();
        return true;
    }
}
