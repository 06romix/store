<?php
namespace Store\Acl;

return array(
    'acl' => array(
        'roles' => array(
            'guest' => 'null',
            'user'  => 'guest',
            'admin' => 'user',
        ),
        'resources' => array(
            'resources' => array(
                'Store' => array(
                    'Store\Controller\Index',
                ),
                'Admin' => array(
                    'Admin\Controller\Index',
                    'product',
                    'user',
                    'order',
                ),
                'Auth' => array(
                    'Auth\Controller\Auth',
                ),
                'Api' => array(
                    'Api\Controller\Index',
                    'test'
                ),
            ),
        ),
        'allow' => array(
            // Store Controller
            'Store' => array(
              'all' => 'guest',
            ),
            'Store\Controller\Index' => array(
              'all' => 'guest',
            ),
            // Api Controller
            'Api\Controller\Index' => array(
              'all' => 'guest',
            ),
            'test' => array(
              'all' => 'guest',
            ),
            // Authorization Controller
            'Auth\Controller\Auth' => array(
              'all' => 'guest',
            ),
            // Admin Controller
            'Admin' => array(
              'all' => 'admin'
            ),
            'Admin\Controller\Index' => array(
              'all' => 'admin'
            ),
            'product' => array(
              'all' => 'admin'
            ),
            'user' => array(
              'all' => 'admin'
            ),
            'order' => array(
              'all' => 'admin'
            ),
        ),
    )
);