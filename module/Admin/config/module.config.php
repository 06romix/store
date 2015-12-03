<?php
 // Filename: /module/Admin/config/module.config.php
 return array(

   'controllers' => array(
         'invokables' => array(
             'Admin\Controller\Index'    => 'Admin\Controller\IndexController',
             'product'                   => 'Admin\Controller\ProductController',
             'order'                     => 'Admin\Controller\OrderController',
             'user'                      => 'Admin\Controller\UserController',
         )
     ),

   'router' => array(
     'routes' => array(

       'admin' => array(
         'type'    => 'literal',
         'options' => array(
           'route'    => '/admin/',
           'defaults' => array(
             'controller' => 'Admin\Controller\Index',
             'action'     => 'index',
           ),
         ),

         'may_terminate' => true,

         'child_routes' => array(
           'product' => array(
             'type'    => 'segment',
             'options' => array(
               'route'    => 'product/[:action/][:id/]',
               'defaults' => array(
                 'controller' => 'product',
                 'action'     => 'index',
               ),
             ),
           ),

           'order' => array(
             'type'    => 'segment',
             'options' => array(
               'route'    => 'order/[:action/][:id/]',
               'defaults' => array(
                 'controller' => 'order',
                 'action'     => 'index',
               ),
             ),
           ),

           'user' => array(
             'type'    => 'segment',
             'options' => array(
               'route'    => 'user/[:action/][:id/]',
               'defaults' => array(
                 'controller' => 'user',
                 'action'     => 'index',
               ),
             ),
           ),

           'auth' => array(
             'type'    => 'literal',
             'options' => array(
               'route'    => 'auth/',
               'defaults' => array(
                 'controller' => 'auth',
                 'action'     => 'login',
               ),
             ),
           ),

         ),//< child routes
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