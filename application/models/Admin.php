<?php
namespace application\models;

use application\core\Model;

class Admin extends Model {

    public $error;

    public function loginValidate($post) {
        $config = require_once 'application/config/admin.php';
        if (($config['login'] != md5(md5($post['login']))) or ($config['password'] != md5(md5($post['password'])))) {
            $this->error = 'Логин или пароль введён неверно';
            return false;
        }
        return true;
    }

    public function postValidate($post, $type) {
        $nameLen = iconv_strlen($post['name']);
        $descriptionLen = iconv_strlen($post['description']);
        $textLen = iconv_strlen($post['text']);
        if (($nameLen<5) or ($nameLen>25)) {
            $this->error = 'Название должно содержать от 5 до 25 символов';
            return false;
        } elseif (($descriptionLen<5) or ($descriptionLen>25)) {
            $this->error = 'Описание должно содержать от 5 до 25 символов';
            return false;
        } elseif (($textLen<10) or ($textLen>1000)) {
            $this->error = 'Текст должен содержать от 10 до 1000 символов';
            return false;
        }

        if (($type == 'add') and (empty($_FILES['img']['tmp_name']))) {
            $this->error = 'Изображение не выбрано';
            return false;
        }
        return true;
    }

}