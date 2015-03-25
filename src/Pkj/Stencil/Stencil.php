<?php
/**
 * Created by PhpStorm.
 * User: peec
 * Date: 12/20/14
 * Time: 6:05 PM
 */

namespace Pkj\Stencil;


class Stencil {
    protected static $_instance;

    private $cacheAdapter;

    public function setCacheAdapter (CacheAdapterInterface $cacheAdapter) {
        $this->cacheAdapter = $cacheAdapter;
        return $this;
    }

    protected function __construct() {
        FilterChainer::appendSetupFilter('raw', function ($filterChainer) {
            $filterChainer->preEscape = false;
        });
    }

    public static function getInstance()
    {
        if( self::$_instance === NULL ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }


    public function resource ($file) {
        return new Resource(file_get_contents($file), $file, $this->cacheAdapter);
    }



} 