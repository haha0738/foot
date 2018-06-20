<?php
/**
 * Created by PhpStorm.
 * User: dermot
 * Date: 2018/5/21
 * Time: 下午9:29
 */

namespace App\Services;


class WitService
{
    public function parse($witData)
    {
        if (!empty($witData['entities']) && !empty($witData['entities']['intent'])) {
            $value = $witData['entities']['intent'][0]['value'];
            $value = $this->toCamelCase($value);

            if (method_exists($this, $value)) {
                return $this->$value($witData['entities']['intent'][0]['confidence']);
            }
        }
        return '我不知道你說什麼';
    }

    public function Greeting($confidence)
    {
        return '安安，你好啊～';
    }

    public function PhoneGet($confidence)
    {
        return '我的電話是09XX-XXX-XXX';
    }

    public function aovWinRateGet($confidence)
    {
        return '大概46%而已拉';
    }

    function toCamelCase($str)
    {
        $array = explode('_', $str);
        $result = $array[0];
        $len = count($array);
        if ($len > 1) {
            for ($i = 1; $i < $len; $i++) {
                $result .= ucfirst($array[$i]);
            }
        }
        return $result;
    }
}