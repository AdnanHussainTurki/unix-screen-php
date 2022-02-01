<?php

namespace myPHPnotes\Models;

class DataStore {
    protected $json;
    public function __construct($path)
    {
        if (!file_exists($path)) {
            file_put_contents($path, json_encode([]));
        }
        $this->json = $path;
    }
    public function clear()
    {
        if (file_exists($this->json)) {
            file_put_contents($this->json, json_encode([]));
            return true;
        }
        return false;
    }
}