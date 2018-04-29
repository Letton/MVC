<?php
    namespace application\controllers;

    use application\core\Controller;

    use application\lib\Pagination;

    use application\core\View;

    class MainController extends Controller{

        public function indexAction() {
            $limit = 10;
            $pagination = new Pagination($this->route, $this->model->postCount(), $limit);
            if (!$this->model->pageExists($this->route, $limit)) {
                View::errorCode(404);
            }
            $vars = [
                'pagination' => $pagination->get(),
                'list' => $this->model->postList($this->route, $limit),
                'limit' => $limit,
                'postCount' => $this->model->postCount(),
            ];
            $this->view->render('Главная страница', $vars);

        }

        public function aboutAction() {
            $this->view->render('Обо мне');

        }

        public function contactAction() {
            if (!empty($_POST)) {
                if  (!$this->model->contactValidate($_POST)) {
                    $this->view->message('Error', $this->model->error);
                }
                mail('lettonchannel@gmail.com', 'Сообщение из блога', $_POST['name'].' | '.$_POST['email'].' | '.$_POST['text']);
                $this->view->message('Success', 'Форма успешно отправлена!');
            }
            $this->view->render('Контакты');
        }

        public function postAction() {
            if (!$this->model->isPostExists($this->route['id'])) {
                View::errorCode(404);
            }
            $vars = [
                'data' => $this->model->postData($this->route['id'])[0],
            ];
            $this->view->render('Пост', $vars);

        }



    }
