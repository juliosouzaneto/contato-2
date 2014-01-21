<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */




return array(
    'db' => array(
        'driver'            => 'Pdo',
        'dsn'               => 'mysql:dbname=limpurb;host=192.168.1.212',
        'driver_options'    => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'AdapterDb'   => 'Zend\Db\Adapter\AdapterServiceFactory', // new \Zend\Db\Adapter\AdapterServiceFactory
        ),     
    ),
    'service_manager_2' => array(
        'factories' => array(
            'AdapterDb2'   => 'Zend\Db\Adapter\AdapterServiceFactory', // new \Zend\Db\Adapter\AdapterServiceFactory
        ),     
    ),
);