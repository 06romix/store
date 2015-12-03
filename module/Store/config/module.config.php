<?php
 // Filename: /module/Store/config/module.config.php
 return array(

   'controllers' => array(
         'invokables' => array(
             'Store\Controller\Index' => 'Store\Controller\IndexController',
         )
     ),

   'router' => array(
     'routes' => array(

       'store' => array(
         'type'    => 'segment',
         'options' => array(
           'route'    => '/[:action/][:id/]',
//           'constraints' => array(
//             'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
//             'id'     => '[0-9]+',
//           ),
           'defaults' => array(
             'controller' => 'Store\Controller\Index',
             'action'     => 'index',
           ),
         ),
//         'may_terminate' => true,
//
//         'child_routes' => array(
//           'home' => array(
//             'type'    => 'segment',
//             'options' => array(
//               'route'    => 'home/[:action/][:id/]',
//               'defaults' => array(
//                 'controller' => 'home',
//                 'action'     => 'home',
//               ),
//             ),
//           ),
//
//         ),//< child routes

       ),

     ),
   ),

   'view_manager' => array(
      'template_path_stack' => array(
        __DIR__ . '/../view',
      ),
   ),
 );