<?php

/**
 * namespace para nosso modulo GrandeGerador
 */

namespace Login;

use Zend\ModuleManager\ModuleManager;
//use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;
use Zend\Loader\StandardAutoloader;
use Zend\Session\Container;

// import Model\GrandeGerador


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
            //ou adicionar no array do module.config.php (ou outro config)
//                'service_manager' => array(
//                    'factories' => array(
//                        'Session' => function($sm) {
//                    return new Zend\Session\Container('limpurb');
//                },
//                        'Login\Service\Auth' => function($sm) {
//                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
//                    return new Login\Service\Auth($dbAdapter);
//                },
//                    )
//                ),
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

    public function init(ModuleManager $moduleManager) {

        // no config.php do ckfinder coloco isso no começo:
        // Setup autoloading Zend Framework 2
        // require '../../../../../../../vendor/zendframework/zendframework/library/Zend/Loader/StandardAutoloader.php';
        // $loader = new StandardAutoloader(array('autoregister_zf' => true));
        // $loader->register();
        //na função dele CheckAuthentication coloquei isso:
//        $auth = new AuthenticationService();
//        $auth->setStorage(new Session('login'));
//
//        if ($auth->hasIdentity()) {
//            return $this->redirect()->toRoute('grande-gerador');
//        } else {
//            //  return $this->redirect()->toRoute('grande-gerador');
//        }
        // e para o $baseUrl coloquei assim:
        //  $baseUrl = str_replace('panel/vendor/ckfinder/core/connector/php/connector.php', 'uploads/ckfinder/', $_SERVER['PHP_SELF']);
        //   protected function redirecionaUsuarioNaoLogado()
        // {
//        $authService = new AuthenticationService();
//
//// Autenticando o passando para a variável result o resultado da autenticação
//        $result = $authService->authenticate($authAdapter);
//
//// Validando a autenticação
//        if ($result->isValid()) {
//              return $this->redirect()->toRoute('grande-gerador');
//        }
//        else{
//            return $this->redirect()->toRoute('login');
//        }
        // $auth = new AuthenticationService();
        // var_dump($auth);
        //  exit();
        //  $auth->setStorage(new SessionStorage('login'));
        //  if (!$auth->hasIdentity())
        //     $this->redirect()->toRoute('login_usuario', array('action' => 'login_senha'));
        //}
        //exit();
        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();
        $sharedEvents->attach(__NAMESPACE__, 'dispatch', function($e) {
            // This event will only be fired when an ActionController under the MyModule namespace is dispatched.
            $controller = $e->getTarget();
            $controller->layout('layout/layout_login');
        }, 100);
    }

    /**
     * Retorna a configuração do service manager do módulo
     * @return array
     */
    public function getServiceConfig() {
        return array(
            'factories' => array(
                'Session' => function($sm) {
            return new Container('limpurb');
        },
                'Login\Service\Auth' => function($sm) {
            $dbAdapter = $sm->get('DbAdapter');
            return new Service\Auth($dbAdapter);
        },
            ),
        );
    }

    /**
     * Executada no bootstrap do módulo
     * 
     * @param MvcEvent $e
     */
    public function onBootstrap($e) {
        /** @var \Zend\ModuleManager\ModuleManager $moduleManager */
        $moduleManager = $e->getApplication()->getServiceManager()->get('modulemanager');
        /** @var \Zend\EventManager\SharedEventManager $sharedEvents */
        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();

        //adiciona eventos ao módulo
        $sharedEvents->attach('Zend\Mvc\Controller\AbstractActionController', \Zend\Mvc\MvcEvent::EVENT_DISPATCH, array($this, 'mvcPreDispatch'), 100);
    }

    /**
     * Verifica se precisa fazer a autorização do acesso
     * @param  MvcEvent $event Evento
     * @return boolean
     */
    public function mvcPreDispatch($event) {
        $di = $event->getTarget()->getServiceLocator();
        $routeMatch = $event->getRouteMatch();
        $moduleName = $routeMatch->getParam('module');
        $controllerName = $routeMatch->getParam('controller');

        if ($moduleName == 'login' && $controllerName != 'Login\Controller\Auth') {
            $authService = $di->get('Login\Service\Auth');
            if (!$authService->authorize()) {
                $redirect = $event->getTarget()->redirect();
                $redirect->toUrl('/login/auth');
            }
        }
        return true;
    }

    /**
     * Register Services
     */
//    public function getServiceConfig() {
//        return array(
//            'factories' => array(
//                'GrandeGeradorTableGateway' => function ($sm) {
//            // obter adapter db atraves do service manager
//            $adapter = $sm->get('Zend\Db\Adapter\Adapter');
//
//            // configurar ResultSet com nosso model GrandeGerador
//            $resultSetPrototype = new ResultSet();
//            $resultSetPrototype->setArrayObjectPrototype(new GrandeGerador());
//
//            // return TableGateway configurado para nosso model GrandeGerador
//            return new TableGateway('grande_gerador', $adapter, null, $resultSetPrototype);
//        },
//                'ModelGrandeGerador' => function ($sm) {
//            // return instacia Model GrandeGeradorTable
//            return new GrandeGeradorTable($sm->get('GrandeGeradorTableGateway'));
//        }
//            )
//        );
//    }
}
