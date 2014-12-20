<?php
/**
 * Created by PhpStorm.
 * User: peec
 * Date: 12/20/14
 * Time: 6:05 PM
 */

namespace Pkj\Stencil;


class Stencil {
    private $tokens;

    public function __construct ($str) {
        $this->tokens = $this->getTokens($str);
    }

    static public function resource ($file) {
        return new self(file_get_contents($file));
    }

    public function render (array $vars = array()) {
        $runnable = '';
        /** @var TokenObject $token */
        foreach($this->tokens as $token) {
            switch($token->getToken()) {
                case T_INLINE_HTML:
                    $exprParser = new ExpressionParser($token->getValue());
                    $runnable .= $exprParser->parse();
                    break;
                default:
                    $runnable .= $token->getValue();
            }
        }
        return $this->evalCode($runnable, $vars);
    }

    private function getTokens ($str) {
        $tok = array();
        $tokens = token_get_all($str);
        foreach($tokens as $t) {
            $tok[] = new TokenObject($t);
        }
        return $tok;
    }

    private function evalCode ($runnable, array $vars = array()) {
        ob_start();
        extract($vars);
        eval("?>$runnable");
        return ob_get_clean();
    }


} 