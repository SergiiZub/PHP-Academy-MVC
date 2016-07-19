<?php


namespace Controllers;


use Classes\AuthError;
use Classes\Controller;
use Models\UserModel;

final class UserController extends Controller {

    public function profile() {
        $user = \App::getInstance()->getComponent('auth')->getCurrentUser();
        return $this->app->getView()->render('user_profile', ['user' => $user]);
    }

    public function deleteProfile() {
        $auth_component = \App::getInstance()->getComponent('auth');
        $user = $auth_component->getCurrentUser();
        $status = UserModel::getModel()->delete($user->id);
        if (!$status) {
            throw new AuthError();
        }
        $auth_component->logout();

        header('Cache-Control: no-cache');
        header('Location: /', true, 301);
    }
}
