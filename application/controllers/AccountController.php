<?php
    namespace application\controllers;

    use application\core\Controller;

    class AccountController extends Controller{

        public function loginAction() {
            if (!empty($_POST)) {
                $this->view->message('success' , 'OK');
            }
            $this->view->render('Login');
        }
        public function registerAction() {
            if (!empty($_POST)) {
                $this->view->message('success' , 'OK');
                $this->view->redirect('/account/login');
            }
            $this->view->render('Register');
        }
    }