<?php

return array(
    # definir e gerenciar controllers
    'controllers' => array(
        'invokables' => array(
            'HomeController' => 'Prestadora\Controller\HomeController',
            'PrestadoraController' => 'Prestadora\Controller\PrestadoraController',
        ),
    ),
# definir e gerenciar rotas
    'router' => array(
        'routes' => array(
            # literal para action index home
            'home' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'HomeController',
                        'action' => 'index',
                    ),
                ),
            ),
            # literal para action sobre home
            'sobre' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/sobre',
                    'defaults' => array(
                        'controller' => 'HomeController',
                        'action' => 'sobre',
                    ),
                ),
            ),
            # segment para controller contatos
            'prestadora' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/prestadora[/:action][/:id][/:pagina]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[-1-9]+',
                        'pagina' => '[-1-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'PrestadoraController',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
    # definir e gerenciar servicos
    'service_manager' => array(
        'factories' => array(
        #'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
        ),
    ),
    # definir e gerenciar layouts, erros, exceptions, doctype base
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'prestadora/home/index' => __DIR__ . '/../view/prestadora/home/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
