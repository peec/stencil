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

    const VARIABLE_NAME_OUTPUTSTR = '$stencil_out';

    public function __construct ($html) {
        $this->html = $html;
    }

    public function parseExpression ($expr) {
        $build = '<?php ';
        $bits = str_split($expr);
        foreach ($bits as $i => $bit) {
            $build .= $bit;
        }
        $build .= ' ?>';
        return $build;
    }

    public function parsePrint ($expr, $filters) {

        $build = '<?php '.self::VARIABLE_NAME_OUTPUTSTR.' = ';
        $bits = str_split($expr);
        foreach ($bits as $i => $bit) {

            $build .= $bit;
        }
        $build .=   '; ?>';


        $parseFilters = $this->parseFilters($filters);
        $build .= $parseFilters;

        $build .= '<?php echo '.self::VARIABLE_NAME_OUTPUTSTR.';  ?>';



        return $build;
    }

    public function parseFilters ($filters) {
        $build = '';

        $build .= '<?php
        $stencil_filterParser = new \Pkj\Stencil\FilterChainer('.self::VARIABLE_NAME_OUTPUTSTR.');
        '.self::VARIABLE_NAME_OUTPUTSTR.' =  $stencil_filterParser' . $filters . '; ?>';


        return $build;
    }




    public function parse() {
        $that = $this;

        $html = $this->html;

        $html = preg_replace_callback('/@\{(.*?)\}/i', function ($expr) use($that) {
            return $that->parseExpression($expr[1]);
        }, $html);


        $html = preg_replace_callback('/\{\{(.*?)\}(.*?)\}/i', function ($expr) use($that) {
            return $that->parsePrint($expr[1], $expr[2]);
        }, $html);


        return $html;
    }


}
