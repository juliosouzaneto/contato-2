<?php

/**
 * namespace para nosso modulo GrandeGerador
 */

namespace GrandeGerador;

// import Model\GrandeGerador
use GrandeGerador\Model\GrandeGerador,
    GrandeGerador\Model\GrandeGeradorTable;
// import Zend\Db
use Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\ModuleManager;

class Module {

    /**
     * include de arquivo para outras configuracoes desse modulo
     */
    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * autoloader para nosso modulo
     */
    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * Register View Helper
     */
    public function getViewHelperConfig() {
        return array(
            # registrar View Helper com injecao de dependecia
            'factories' => array(
                'menuAtivo' => function($sm) {
            return new View\Helper\MenuAtivo($sm->getServiceLocator()->get('Request'));
        },
                'message' => function($sm) {
            return new View\Helper\Message($sm->getServiceLocator()->get('ControllerPluginManager')->get('flashmessenger'));
        },
            )
        );
    }

    /**
     * Register Services
     */
    public function getServiceConfig() {
        return array(
            'factories' => array(
                'GrandeGeradorTableGateway' => function ($sm) {
            // obter adapter db atraves do service manager
            $adapter = $sm->get('Zend\Db\Adapter\Adapter');

            // configurar ResultSet com nosso model GrandeGerador
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new GrandeGerador());           // return TableGateway configurado para nosso model GrandeGerador
            return new TableGateway('grande_gerador', $adapter, null, $resultSetPrototype);
        },
                'ModelGrandeGerador' => function ($sm) {
            // return instacia Model GrandeGeradorTable
            return new GrandeGeradorTable($sm->get('GrandeGeradorTableGateway'));
        }
            )
        );
    }
    
    public function init(ModuleManager $moduleManager)
    {
        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();
        $sharedEvents->attach(__NAMESPACE__, 'dispatch', function($e) {
            // This event will only be fired when an ActionController under the MyModule namespace is dispatched.
            $controller = $e->getTarget();
            $controller->layout('layout/layout.phtml');
        }, 100);
    }
 

}
