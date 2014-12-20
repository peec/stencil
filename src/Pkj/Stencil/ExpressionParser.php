<?php
/**
 * Created by PhpStorm.
 * User: peec
 * Date: 12/20/14
 * Time: 6:05 PM
 */

namespace Pkj\Stencil;




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
