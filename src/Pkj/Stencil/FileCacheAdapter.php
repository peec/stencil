<?php
/**
 * Created by PhpStorm.
 * User: pk
 * Date: 25.03.15
 * Time: 15:43
 */

namespace Pkj\Stencil;


class FileCacheAdapter implements CacheAdapterInterface{

    private $storageDir, $templateDir;


    const EXT = '.stencil.compile.php';


    public function __construct ($storageDir, $templateDir = '.') {
        $this->storageDir = $storageDir;
        $this->templateDir = $templateDir;

        if (!file_exists($storageDir)  || !is_writable($storageDir)) {
            throw new \Exception("Compilation dir $storageDir must exist and be writable.");
        }
    }

    public function exists($id) {
        return file_exists($this->file($id)) && filemtime($this->file($id)) > filemtime($this->templateFile($id));
    }

    public function get($id) {
        return file_get_contents($this->file($id));
    }

    public function set($id, $content) {
        file_put_contents($this->file($id), $content);
    }

    private function templateFile($id) {
        return $this->templateDir  . '/' . $id;
    }

    private function file ($id) {
        return $this->storageDir . '/' . $id . self::EXT;
    }

} 