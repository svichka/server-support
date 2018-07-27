<?php
/**
 * Created by PhpStorm.
 * User: svc
 * Date: 27.07.2018
 * Time: 17:34
 */

namespace Svc;


use Curl\Curl;

class FormValidators
{
    /**
     * @param $phone
     * @return bool
     */
    public static function phoneValidator($phone)
    {
        $justNums = preg_replace("/[^0-9]/", '', $phone);
        if(strlen($justNums) > 9 && strlen($justNums) < 12)
        {
            return true;
        }
        return false;
    }

    /**
     * @param $string
     * @return bool
     */
    public static function existValidator($string)
    {
        return !empty($string);
    }

    /**
     * @param $code
     * @return bool
     */
    public static function captchaValidator($code)
    {
        $url = "https://www.google.com/recaptcha/api/siteverify";
        $secret = "6Lc6wWYUAAAAAKoIroY-sLQ5yRfrsoX-ZCTMaHsG";
        $curl = new Curl();
        $curl->post($url, [
            'secret' => $secret,
            'response' => $code
        ]);

        if ($curl->error) {
            return false;
        }
        $response = json_decode($curl->response);

        return $response->success;

    }
}