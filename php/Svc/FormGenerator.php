<?php
namespace Svc;
/**
 * Created by PhpStorm.
 * User: svc
 * Date: 27.07.2018
 * Time: 17:11
 */
class FormGenerator
{
    private $formName = "feedback";
    private $inputName = "inputName";
    private $inputPhone = "inputPhone";
    private $inputText = "inputText";
    private $inputAgreement = "inputAgreement";
    private $inputToken = "inputToken";
    private $inputCaptcha = "g-recaptcha-response";
    private $token;
    private $lastError;
    private $values = [];

    public function __construct()
    {
        $this->token = CsrfGenerator::generateToken($this->formName);
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return [
            'phone' => $this->inputPhone,
            'name' => $this->inputName,
            'text' => $this->inputText,
            'agreement' => $this->inputAgreement,
            'token' => $this->inputToken,
            'csrf' => $this->token
        ];
    }

    /**
     * @return string
     */
    public function getFormName()
    {
        return $this->formName;
    }

    /**
     * @return mixed
     */
    public function getLastError()
    {
        return $this->lastError;
    }

    /**
     * @param $post
     * @return bool
     */
    public function validate($post)
    {
        if (!CsrfGenerator::checkToken($post[$this->inputToken], $this->formName)) {
            $this->lastError = "CSRF token error";
            return false;
        }
        if (!FormValidators::captchaValidator($post[$this->inputCaptcha]))  {
            $this->lastError = "CAPTCHA error";
            return false;
        }
        if (!FormValidators::phoneValidator($post[$this->inputPhone])) {
            $this->lastError = "Phone error";
            return false;
        }
        $this->values[$this->inputPhone] = $post[$this->inputPhone];

        if (!FormValidators::existValidator($post[$this->inputName])) {
            $this->lastError = "Name is empty";
            return false;
        }
        $this->values[$this->inputName] = $post[$this->inputName];

        if (!FormValidators::existValidator($post[$this->inputText])) {
            $this->lastError = "Message is empty";
            return false;
        }
        $this->values[$this->inputText] = $post[$this->inputText];

        return true;
    }

    public function getMailBody() {
        return sprintf("Name: %s\nPhone: %s\nMessage:\n\n%s",
            $this->values[$this->inputName], $this->values[$this->inputPhone], $this->values[$this->inputText]);
    }
}