<?php
/**
 * Created by PhpStorm.
 * User: pk
 * Date: 25.03.15
 * Time: 11:58
 */

namespace Pkj\Stencil;


class Resource {

    private $tokens, $filePath, $cacheAdapter;



    public function __construct ($str, $filePath, CacheAdapterInterface $cacheAdapter = null) {
        $this->tokens = $this->getTokens($str);
        $this->filePath = $filePath;
        $this->cacheAdapter = $cacheAdapter;
    }



    public function compile () {
        if ($this->cacheAdapter) {
            if ($this->cacheAdapter->exists($this->filePath)) {
                return $this->cacheAdapter->get($this->filePath);
            }
        }

        $runnable = '<?php $stencil_resource = $this ?>';
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

        if ($this->cacheAdapter) {
            $this->cacheAdapter->set($this->filePath, $runnable);
        }
        return $runnable;
    }



    public function render (array $vars = array()) {
        return $this->evalCode($this->compile(), $vars);
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

        $filter = function ($val) {
            return new FilterChainer($val);
        };

        eval("?>$runnable");
        return ob_get_clean();
    }
} 