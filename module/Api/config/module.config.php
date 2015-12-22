<?php
 // Filename: /module/Admin/config/module.config.php
 return array(

   'controllers' => array(
         'invokables' => array(
             'Api\Controller\Index'    => 'Api\Controller\IndexController',
         )
     ),

   'router' => array(
     'routes' => array(

       'api' => array(
         'type'    => 'segment',
         'options' => array(
           'route'    => '/api/:v/[:action/][:param/][:resource]',
           'defaults' => array(
             'controller' => 'Api\Controller\Index',
             'action'     => 'index',
           ),
         ),
       ),

     ),
   ),

   'view_manager' => array(
     'display_not_found_reason' => true,
     'display_exceptions'       => true,
     'doctype'                  => 'HTML5',
     'template_map' => array(
       'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
//       'admin/product/index'           => __DIR__ . '/../view/layout/layout.phtml',
//       'store/index/index'       => __DIR__ . '/../view/layout/index.phtml',
     ),
     'template_path_stack' => array(
       __DIR__ . '/../view',
     ),
   ),

   'service_manager' => array(
     'factories' => array(
       'AccessControl' => function () {
//         $auth = new Zend\Authentication\AuthenticationService();
         return 'service_manager';
       }
     ),

   ),

 );