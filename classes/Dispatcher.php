<?php
require_once('classes/Controller.php');

class Dispatcher {

    protected $controller;

    public function __construct(Controller $controller) {
        $this->controller = $controller;
    }

    public function dispatch() {
        $format = $this->controller->getVar('format') ?: 'html';
        $type = $this->controller->getVar('type');

        if (!$type) {
            exit('Please specify a type');
        }

        echo $this->controller->export($type, $format);
    }
}