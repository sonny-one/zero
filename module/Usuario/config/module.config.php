<?php

/**

 * Zend Framework (http://framework.zend.com/)

 *

 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository

 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)

 * @license   http://framework.zend.com/license/new-bsd New BSD License

 */



return array(

    'router' => array(

        'routes' => array(

            'home' => array(

                'type' => 'Zend\Mvc\Router\Http\Literal',

                'options' => array(

                    'route'    => '/',

                    'defaults' => array(

                        'controller' => 'Usuario\Controller\Index',

                        'action'     => 'index',

                    ),

                ),

            ),

            // The following is a route to simplify getting started creating

            // new controllers and actions without needing to create a new

            // module. Simply drop new controllers in, and you can access them

            // using the path /application/:controller/:action

            'usuario' => array(

                'type'    => 'Literal',

                'options' => array(

                    'route'    => '/usuario',

                    'defaults' => array(

                        '__NAMESPACE__' => 'Usuario\Controller',

                        'controller'    => 'Index',

                        'action'        => 'index',

                    ),

                ),

                'may_terminate' => true,

                'child_routes' => array(

                    'default' => array(

                        'type'    => 'Segment',

                        'options' => array(

                            'route'    => '/[:controller[/:action[/:id]]]',

                            'constraints' => array(

                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',

                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',

                                'id'         => '[0-9-a-z]*'

                            ),

                            'defaults' => array(

                            ),

                        ),

                    ),

                ),

            ),

        ),

    ),

    'service_manager' => array(

        'abstract_factories' => array(

            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',

            'Zend\Log\LoggerAbstractServiceFactory',

        ),

        'factories' => array(
            'translator' => 'Zend\Mvc\Service\TranslatorServiceFactory',
        ),

    ),

    'translator' => array(

        'locale' => 'en_US',

        'translation_file_patterns' => array(

            array(

                'type'     => 'gettext',

                'base_dir' => __DIR__ . '/../language',

                'pattern'  => '%s.mo',

            ),

        ),

    ),

    'controllers' => array(

        'invokables' => array(

            'Usuario\Controller\Index' => 'Usuario\Controller\IndexController',

            'Usuario\Controller\Club' => 'Usuario\Controller\ClubController',

            'Usuario\Controller\Reclamo' => 'Usuario\Controller\ReclamoController',

            'Usuario\Controller\Sugerencia' => 'Usuario\Controller\SugerenciaController',

            'Usuario\Controller\Circular' => 'Usuario\Controller\CircularController',

            'Usuario\Controller\Gcomunes' => 'Usuario\Controller\GcomunesController'

        ),

    ),

 'view_manager' => array(

        'display_not_found_reason' => true,

        'display_exceptions'       => true,

        'doctype'                  => 'HTML5',

        'not_found_template'       => 'error/404',

        'exception_template'       => 'error/index',

        'template_map' => array(

            'layout/usuario'           => __DIR__ . '/../view/layout/usuario.phtml',

            'usuario/index/index' => __DIR__ . '/../view/usuario/index/index.phtml',

            'error/404'               => __DIR__ . '/../view/error/404.phtml',

            'error/index'             => __DIR__ . '/../view/error/index.phtml',

        ),

        'template_path_stack' => array(

          'usuario' =>  __DIR__ . '/../view',

        ),

    ), 

);