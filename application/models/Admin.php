<?php
namespace application\models;

use application\core\Model;

use Imagick;


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
        } elseif (($descriptionLen<5) or ($descriptionLen>50)) {
            $this->error = 'Описание должно содержать от 5 до 50 символов';
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

    public function postAdd($post) {
        $params = [
            'name' => $post['name'],
            'description' => $post['description'],
            'text' => $post['text'],
        ];
        $this->db->query('INSERT INTO post VALUES (NULL, :name, :description, :text, CURRENT_TIMESTAMP)', $params);
        return $this->db->lastInsertId();
    }

    public function postEdit($post, $id) {
        $params = [
            'id' => $id,
            'name' => $post['name'],
            'description' => $post['description'],
            'text' => $post['text'],
        ];
        $this->db->query('UPDATE post SET name = :name, description = :description, text = :text, date = CURRENT_TIMESTAMP WHERE id = :id', $params);
    }

    public function postUploadImage($path, $id) {
        move_uploaded_file($path,'public/materials/'.$id.'.jpg');
    }

    public function isPostExists($id){
        $params = [
            'id' => $id,
        ];
        return $this->db->column('SELECT id FROM post WHERE id=:id', $params);
    }

    public function postDelete($id) {
        $params = [
            'id' => $id,
        ];
        $this->db->query('DELETE FROM post WHERE id=:id', $params);
        unlink('public/materials/'.$id.'.jpg');
    }

    public function postData($id) {
        $params = [
            'id' => $id,
        ];
        return $this->db->row('SELECT * FROM post WHERE id=:id', $params);
    }

    public function postCount(){
        return $this->db->column('SELECT COUNT(id) FROM post');
    }

    public function postList($route, $max){
        $params = [
            'max' => $max,
            'start' => (($route['page'] ?? 1) - 1) * $max,
        ];
        return $this->db->row('SELECT * FROM post ORDER BY date DESC LIMIT :start, :max', $params);
    }

    public function pageExists($route, $max) {
        if (isset($route['page'])) {
            if (($route['page']>1) and (($route['page'] - 1) * $max>=$this->postCount())) {
                    return false;
            }
        }
        return true;
    }

}