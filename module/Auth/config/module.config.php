<?php
 // Filename: /module/Auth/config/module.config.php
 return array(

   'controllers' => array(
         'invokables' => array(
             'Auth\Controller\Auth'    => 'Auth\Controller\AuthController',
         )
     ),

   'router' => array(
     'routes' => array(

       'auth' => array(
         'type'    => 'segment',
         'options' => array(
           'route'    => '/auth/[:action/]',
           'defaults' => array(
             'controller' => 'Auth\Controller\Auth',
             'action'     => 'login',
           ),
         ),
       ),
     ),
   ),

   'view_manager' => array(
     'display_not_found_reason' => true,
     'display_exceptions'       => true,
     'doctype'                  => 'HTML5',
     'template_path_stack' => array(
       __DIR__ . '/../view',
     ),
   ),
 );