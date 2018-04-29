<?php
    namespace application\models;

    use application\core\Model;


    class Main extends Model {

        public $error;

        public function contactValidate($post) {
            $nameLen = iconv_strlen($post['name']);
            $textLen = iconv_strlen($post['text']);
            if (($nameLen<3) or ($nameLen>20)) {
                $this->error = 'Имя должно содержать от 3 до 20 символов';
                return false;
            } elseif (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
                $this->error = 'Введите корректный email';
                return false;
            } elseif (($textLen<10) or ($textLen>255)) {
                $this->error = 'Сообшение должно содержать от 10 до 255 символов';
                return false;
            }
            return true;
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

        public function isPostExists($id){
            $params = [
                'id' => $id,
            ];
            return $this->db->column('SELECT id FROM post WHERE id=:id', $params);
        }

        public function postData($id) {
            $params = [
                'id' => $id,
            ];
            return $this->db->row('SELECT * FROM post WHERE id=:id', $params);
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