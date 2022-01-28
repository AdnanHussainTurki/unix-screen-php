<?php 

namespace myPHPnotes;

use myPHPnotes\Models\DataStore;

class Screen {
    protected $datastore;
    public function __construct($datastore_path)
    {
        $this->datastore = new DataStore($datastore_path);
    }
}