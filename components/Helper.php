<?php

namespace app\components;

use Yii;
use yii\base\Component as BaseComponent;
use yii\db\Expression;
use yii\helpers\BaseStringHelper;
use WhichBrowser\Parser;

class Helper extends BaseComponent
{
    public static function getSafeColumnName($column)
    {
        return preg_replace("/[^a-z_]/i", "", strtolower($column));
    }

    public static function getSafeExpression($operation, $column)
    {
        $operation = preg_replace("/[^A-Z]/i", "", strtoupper($operation));
        $column = static::getSafeColumnName($column);

        return new Expression("$operation(`{$column}`)");
    }

    public static function getSecretKey()
    {
        return Yii::$app->params['encodingSecretKey'];
    }

    public static function encode($data, $secretKey)
    {
        try {
            $encryptedData = json_encode($data);
            $encryptedData = Yii::$app->getSecurity()->encryptByPassword($encryptedData, $secretKey);
            return BaseStringHelper::base64UrlEncode($encryptedData);
        } catch (\Throwable $th) {
        }
        return null;
    }

    public static function decode($encryptedData, $secretKey)
    {
        try {
            $encryptedData = BaseStringHelper::base64UrlDecode($encryptedData);
            $encryptedData = Yii::$app->getSecurity()->decryptByPassword($encryptedData, $secretKey);
            return json_decode($encryptedData, true);
        } catch (\Throwable $th) {
        }
        return null;
    }

    public static $parseUserAgentCache = [];
    public static function parseUserAgent($userAgent)
    {
        if (isset(self::$parseUserAgentCache[$userAgent])) {
            return self::$parseUserAgentCache[$userAgent];
        }

        $result = [
            'browser' => ['name' => null, 'version' => null,],
            'os' => ['name' => null, 'version' => null,],
            'device' => null,
        ];

        try {
            $userAgentParsed = (array) new Parser($userAgent);
            //
            $browser = (array) $userAgentParsed['browser'];
            if (isset($browser['name'])) {
                $result['browser']['name'] = $browser['name'];
            }
            if (isset($browser['version']) && $browser['version']) {
                $result['browser']['version'] = $browser['version']->value;
            }
            //
            $os = (array) $userAgentParsed['os'];
            if (isset($os['name'])) {
                $result['os']['name'] = $os['name'];
            }
            if (isset($os['version']) && $os['version']) {
                $result['os'][$os['version']] = $os['version']->alias;
            }
            ///
            $device = (array) $userAgentParsed['device'];
            $result['device'] = $device['type'];
        } catch (\yii\base\ErrorException $e) {
        } catch (\Exception $e) {
        } catch (\Throwable $e) {
        }

        return self::$parseUserAgentCache[$userAgent] = $result;
    }
}
