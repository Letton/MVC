<?php
    namespace application\core;

    abstract class Controller {

        public  $route;
        public  $view;
        public  $model;
        public  $acl;

        function __construct($route) {
            $this->route = $route;
            if (!$this->checkAcl()) {
                View::errorCode(403);
            }
            $this->view = new View($route);
            $this->model = $this->loadModel($route['controller']);
        }
        public function loadModel($name){
            $path = 'application\models\\'.ucfirst($name);
            if (class_exists($path)) {
                return new $path;
            }
        }

        public function checkAcl() {
            $this->acl = require_once 'application/acl/' . $this->route['controller'] . '.php';
            if ($this->isAcl('all')) {
                return true;
            }
            elseif (isset($_SESSION['auth']['id']) and ($this->isAcl('auth'))) {
                return true;
            }
            elseif (!isset($_SESSION['auth']['id']) and ($this->isAcl('guest'))) {
                return true;
            }
            elseif (isset($_SESSION['admin']) and ($this->isAcl('admin'))) {
                return true;
            }
            return false;
        }

        public function isAcl($key) {
            return in_array($this->route['action'], $this->acl[$key]);
        }
    }

