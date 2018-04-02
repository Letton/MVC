<?php
    namespace application\core;

    class View {

        public $path;
        public $route;
        public $layout = 'default';


        function __construct($route) {
            $this->route = $route;
            $this->path = $route['controller'].'/'.$route['action'];
        }
        public function render($title, $vars = []) {
            extract($vars);
            $path = 'application/view/'.$this->path.'.php';
            if (file_exists($path)) {
                ob_start();
                require_once $path;
                $content = ob_get_clean();
                require_once 'application/view/layouts/'.$this->layout.'.php';
            }
        }

        public static function errorCode($code) {
            http_response_code($code);
            $path = 'application/view/errors/'.$code.'.php';
            if (file_exists($path)) {
                require $path;
            }
            exit;
        }

        public function redirect($url)
        {
            header('location: '.$url);
            exit;
        }

        public function message($status, $message) {
            exit(json_encode(['status' => $status, 'message' => $message]));
        }

    }
