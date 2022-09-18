<?php

namespace app\components;

use yii\i18n\Formatter as BaseFormatter;

class Formatter extends BaseFormatter
{
    public $datetimefa = 'H:i Y-m-d';

    public function asDatetimefa($value)
    {
        if (!is_numeric($value) && $stt = strtotime($value)) {
            $value = $stt;
        }
        if ($value) {
            return Jdf::jdate($this->datetimefa, $value);
        }
        return $this->nullDisplay;
    }
}
