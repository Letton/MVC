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

    }