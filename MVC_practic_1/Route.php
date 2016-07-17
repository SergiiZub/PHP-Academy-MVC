<?php


final class Route {
    /**
     * @var string $uri
     */
    private $uri;
    private $controller;
    private $action_name;

    /**
     * Route constructor.
     * @param string $uri
     * @param string $controller
     * @param string $action_name
     */
    public function __construct($uri, $controller, $action_name)
    {
        $this->uri = $uri;
        $this->controller = $controller;
        $this->action_name = $action_name;
    }

    public function inspect($current_uri) {
        return strstr($this->uri, $current_uri) !== false;
    }

    public function callAction() {
        if (method_exists($this->controller, $this->action_name)) {
            return $this->controller->{$this->action_name}();
        }
        return false;
    }
}