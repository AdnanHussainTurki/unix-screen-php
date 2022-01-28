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
}