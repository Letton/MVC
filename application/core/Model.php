<?php
    namespace application\core;

    use application\lib\Db;

    abstract class Model {

        public $db;

        function __construct() {
            $this->db = new Db;
        }

    }