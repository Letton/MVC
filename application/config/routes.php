<?php
    return [
        //  MainController
        '' => [
            'controller' => 'main',
            'action' => 'index',
        ],
        'about' => [
            'controller' => 'main',
            'action' => 'about',
        ],
        'contact' => [
            'controller' => 'main',
            'action' => 'contact',
        ],
        'post/{id:\d+}' => [
            'controller' => 'main',
            'action' => 'post',
        ],
        //  AdminController

        'admin/list' => [
            'controller' => 'admin',
            'action' => 'list',
        ],

        'admin/login' => [
            'controller' => 'admin',
            'action' => 'login',
        ],
        'admin/logout' => [
            'controller' => 'admin',
            'action' => 'logout',
        ],
        'admin/add' => [
            'controller' => 'admin',
            'action' => 'add',
        ],
        'admin/edit/{id:\d+}' => [
            'controller' => 'admin',
            'action' => 'edit',
        ],
        'admin/delete/{id:\d+}' => [
            'controller' => 'admin',
            'action' => 'delete',
        ],
    ];