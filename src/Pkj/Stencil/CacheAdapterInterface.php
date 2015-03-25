<?php
/**
 * Created by PhpStorm.
 * User: pk
 * Date: 25.03.15
 * Time: 15:43
 */

namespace Pkj\Stencil;


interface CacheAdapterInterface {

    public function exists($id);

    public function get($id);

    public function set($id, $content);

}