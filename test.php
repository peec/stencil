<?php


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




class TokenTemplate {
    private $tokens;

    public function __construct ($str) {
        $this->tokens = $this->getTokens($str);
    }

    private function getTokens ($str) {
        $tok = array();
        $tokens = token_get_all($str);
        foreach($tokens as $t) {
            $tok[] = new TokenObject($t);
        }
        return $tok;
    }

    static public function loadFile ($file) {
        return new self(file_get_contents($file));
    }

    public function render () {
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
        return $this->evalCode($runnable);
    }

    public function evalCode ($runnable, $vars = array()) {
        ob_start();
        extract($vars);
        eval("?>$runnable");
        return ob_get_clean();
    }

}


interface ExpressionParserInterface {

    public function parse();

}


class ExpressionParser implements ExpressionParserInterface{
    private $html;

    public function __construct ($html) {
        $this->html = $html;
    }

    public function parseExpression ($expr) {
        $build = '<?php ';
        $bits = str_split($expr);
        foreach ($bits as $i => $bit) {
            if ($i === 0 && $bit === '=') {
                $build .= 'echo ';
            } else {
                $build .= $bit;
            }
        }
        $build .= ' ?>';
        return $build;
    }

    public function parse() {
        $that = $this;

        $html = $this->html;

        $html = preg_replace_callback('/@\{(.*?)\}/i', function ($expr) use($that) {
            return $that->parseExpression($expr[1]);
        }, $html);

        return $html;
    }


}


$engine = TokenTemplate::loadFile('o.php');

echo $engine->render();


