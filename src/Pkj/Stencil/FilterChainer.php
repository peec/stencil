<?php
/**
 * Created by PhpStorm.
 * User: pk
 * Date: 25.03.15
 * Time: 09:53
 */

namespace Pkj\Stencil;


class FilterChainer {


    private $value;

    public $preEscape = true;

    public $callers = array();



    public function __construct ($value) {
        $this->value = $value;
    }

    public function __call($filterName, $arguments) {
        if (isset(self::$_setup[$filterName])) {
            call_user_func_array(self::$_setup[$filterName], array_merge(array($this), $arguments));
        } else if (isset(self::$_filters[$filterName])) {
            $this->callers[] = array(
                self::$_filters[$filterName], $arguments
            );
        } else {
            throw new \Exception("Chaining, filter or setup-filter $filterName does not exist.");
        }
        return $this;
    }

    public function __toString () {
        $value = $this->value;
        if ($this->preEscape) {
            $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }
        foreach ($this->callers as $caller) {
            $value = call_user_func_array($caller[0], array_merge(array($value), $caller[1]));
        }
        return (string)$value;
    }


    static private $_filters = array();

    /**
     * Setup filters allows to setup the filter-chainer behavior.
     * @var array Array of setup filters
     */
    static private $_setup = array();

    static public function appendFilter($filterName, callable $callable) {
        self::$_filters[$filterName] = $callable;
    }
    static public function appendSetupFilter($filterName, callable $callable) {
        self::$_setup[$filterName] = $callable;
    }

    static public function getFilters () {
        return self::$_filters;
    }
    static public function getSetup () {
        return self::$_setup;
    }

} 