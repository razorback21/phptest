<?php
class Request {

    protected $requestCollection;

    public function __construct() {
        $this->requestCollection = collect($_REQUEST);
    }

    public function getVar($name) {
        return $this->requestCollection->pull($name);
    }

    public function getVars() {
        return $this->requestCollection->all();
    }

    public function collection() {
        return $this->requestCollection;
    }
}