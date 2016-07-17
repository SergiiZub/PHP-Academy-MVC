<?php
class Composite {
    private static $instance;
    private $component_list = [];

    public static function getInstance(){
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function addComponent($component) {
        $this->component_list[] = $component;
    }

    public function init() {
        /**
         * @var Component $c
         */
        foreach ($this->component_list as $c) {
            try {
                $c->init();
            } catch (Exception $e) {
                echo $c->getName() . ' is not valid! ' . PHP_EOL;
            }
        }

    }
}

abstract class Component {
    private $name;

    public function __construct($name) {
        $this->name = $name;
    }

    final public function getName(){
        return $this->name;
    }

    abstract function init();
}

final class TrashComponent extends Component {
    function init()
    {
        throw new Exception();
        echo 'class = ' .  __CLASS__ . '; method = ' . __METHOD__ . PHP_EOL;
    }

}

final class AuthComponent extends Component {
    function init()
    {
        echo 'class = ' . __CLASS__ . '; method = ' . __METHOD__ . PHP_EOL;
    }

}

$app = Composite::getInstance();
$app->addComponent(new TrashComponent('trash'));
$app->addComponent(new AuthComponent('auth'));
$app->init();
