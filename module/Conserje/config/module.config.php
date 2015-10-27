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
                        'controller' => 'Conserje\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'conserje' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/conserje',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Conserje\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action[/:id/:id2]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'         => '[0-9-a-z]*',
                                'id2'         => '[0-9-a-z]*'                                
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
            'Conserje\Controller\Index' => 'Conserje\Controller\IndexController',
            'Conserje\Controller\Reclamo' => 'Conserje\Controller\ReclamoController',
            'Conserje\Controller\Notificacion' => 'Conserje\Controller\NotificacionController',
            'Conserje\Controller\Estadistica' => 'Conserje\Controller\EstadisticaController',
            'Conserje\Controller\Comentario' => 'Conserje\Controller\ComentarioController',
            'Conserje\Controller\Encomienda' => 'Conserje\Controller\EncomiendaController',
            'Conserje\Controller\Visita' => 'Conserje\Controller\VisitaController',
			'Conserje\Controller\Cfg' => 'Conserje\Controller\CfgController',
			'Conserje\Controller\Quincho' => 'Conserje\Controller\QuinchoController'
            
        ),
    ),
 'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/conserje'           => __DIR__ . '/../view/layout/conserje.phtml',
            'conserje/index/index' => __DIR__ . '/../view/conserje/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
          'conserje' =>  __DIR__ . '/../view',
        ),
    ), 
);