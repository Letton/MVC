<?php

namespace application\controllers;

use application\core\Controller;

use application\core\View;

use application\lib\Pagination;

class AdminController extends Controller {
    public function __construct($route)
    {
        parent::__construct($route);
        $this->view->layout = 'admin';
    }

    public function loginAction() {
        if (isset($_SESSION['admin'])) {
            $this->view->redirect('/admin/add');
        }
        if (!empty($_POST)) {
            if  (!$this->model->loginValidate($_POST)) {
                $this->view->message('Error', $this->model->error);
            }
            $_SESSION['admin'] = true;
            $this->view->location('admin/add');
        }
        $this->view->render('Вход');
    }
    public function addAction() {
        if (!empty($_POST)) {
            if (!$this->model->postValidate($_POST, 'add')) {
                $this->view->message('Error', $this->model->error);
            }
            $id = $this->model->postAdd($_POST);
            $this->model->postUploadImage($_FILES['img']['tmp_name'], $id);
            $this->view->message('Success', 'OK');
        }
        $this->view->render('Добавить пост');
    }
    public function editAction() {
        if (!$this->model->isPostExists($this->route['id'])) {
            View::errorCode(404);
        }
        if (!empty($_POST)) {
            if (!$this->model->postValidate($_POST, 'edit')) {
                $this->view->message('Error', $this->model->error);
            }
            $this->model->postEdit($_POST, $this->route['id']);
            if ($_FILES['img']['tmp_name']) {
                $this->model->postUploadImage($_FILES['img']['tmp_name'], $this->route['id']);
            }
            $this->view->message('Success', 'OK');
        }
        $vars = [
            'data' => $this->model->postData($this->route['id'])[0],
        ];
        $this->view->render('Редактировать пост', $vars);
    }
    public function deleteAction() {
        if (!$this->model->isPostExists($this->route['id'])) {
            View::errorCode(404);
        }
        $this->model->postDelete($this->route['id']);
        $this->view->redirect('../../admin/list');
    }
    public function logoutAction() {
        unset($_SESSION['admin']);
        $this->view->redirect('admin/login');
    }
    public function listAction() {
        $limit = 10;
        if (!$this->model->pageExists($this->route, $limit)) {
            View::errorCode(404);
        }
        $pagination = new Pagination($this->route, $this->model->postCount(), $limit);
        $vars = [
            'pagination' => $pagination->get(),
            'list' => $this->model->postList($this->route, $limit),
            'limit' => $limit,
            'postCount' => $this->model->postCount(),
        ];
        $this->view->render('Посты', $vars);
    }



}