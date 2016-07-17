<?php

abstract class Controller {
    /**
     * @var App
     */
    protected $app;

    public function __construct() {
        $this->app = App::getInstance();
    }


}