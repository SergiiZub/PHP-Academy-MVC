<?php
class Model {
    public function getUserInfo() {
        return [
            'name' => 'Dima',
            'birthday' => '15.02.95'
        ];
    }
}

class ActiveModel {
    private $view_list = [];

    public function addView($view) {
        $this->view_list[] = $view;
    }

    public function getUserInfo() {
        return [
            'name' => 'Dima',
            'birthday' => '15.02.95'
        ];
    }

    public function sends($data = []) {
        /**
         * @var View $v
         */
        foreach ($this->view_list as $v) {
            echo $v->render(
                'main.template.html',
                $data
            );
        }
    }
}

class View {

    /**
     * @param string $template_name
     * @param array $args
     * @return string
     */
    public function render($template_name, $args) {
        extract($args);
        ob_start();
        include $template_name;
        return ob_get_clean();
    }
}

class Controller {
    private $model;
    private $view;

    /**
     * Controller constructor.
     * @param ActiveModel $model
     * @param View $view
     */
    public function __construct(ActiveModel $model, View $view) {
        $this->model = $model;
        $this->view = $view;
    }

    public function getUserProfile() {
        $this->model->addView($this->view);
        $user_info = $this->model->getUserInfo();
        $this->model->sends($user_info);
    }
}

$model = new ActiveModel();
$view = new View();
$controller = new Controller($model, $view);
$controller->getUserProfile();
