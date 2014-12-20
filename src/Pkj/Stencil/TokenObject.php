<?php
/**
 * Created by PhpStorm.
 * User: peec
 * Date: 12/20/14
 * Time: 6:06 PM
 */

namespace Pkj\Stencil;


class TokenObject {

    private $token;

    private $value;


    private $lineNumber;

    public function __construct($token) {
        if (is_string($token)) {
            $this->value = $token;
        } else {
            $this->token = $token[0];
            $this->value = $token[1];
            $this->lineNumber = $token[2];
        }
        //$this->lineNumber = $token[2];
    }

    /**
     * @param mixed $lineNumber
     */
    public function setLineNumber($lineNumber)
    {
        $this->lineNumber = $lineNumber;
    }

    /**
     * @return mixed
     */
    public function getLineNumber()
    {
        return $this->lineNumber;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $tokenName
     */
    public function setTokenName($tokenName)
    {
        $this->tokenName = $tokenName;
    }

    /**
     * @return string
     */
    public function getTokenName()
    {
        return $this->tokenName;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }



}
