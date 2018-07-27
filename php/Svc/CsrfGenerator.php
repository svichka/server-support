<?php
namespace Svc;
/**
 * Created by PhpStorm.
 * User: svc
 * Date: 27.07.2018
 * Time: 16:51
 */
class CsrfGenerator
{
    private $salt = "AAEHhzIqH2U2T5pMMoiV";

    /**
     * @param $formName
     * @return string
     */

    public static function generateToken(string $formName)
    {
        if (!session_id()) {
            session_start();
        }
        $sessionId = session_id();
        return sha1($formName . $sessionId);

    }

    /**
     * @param string $token
     * @param string $formName
     * @return bool
     */
    public static function checkToken(string $token, string $formName)
    {
        return $token == self::generateToken($formName);
    }
}