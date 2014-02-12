<?php

namespace Login\Service;

use Core\Service\Service;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Db\Sql\Select;
//use Zend\Authentication\Result;
//use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable;

/**
 * Serviço responsável pela autenticação da aplicação
 * 
 * @category Admin
 * @package Service
 * @author  Elton Minetto<eminetto@coderockr.com>
 */
class Auth extends Service {

    /**
     * Adapter usado para a autenticação
     * @var Zend\Db\Adapter\Adapter
     */
    private $dbAdapter;

    /**
     * Construtor da classe
     *
     * @return void
     */
    public function __construct($dbAdapter = null) {
        $this->dbAdapter = $dbAdapter;
    }

    /**
     * Faz a autenticação dos usuários
     * 
     * @param array $params
     * @return array
     */
    public function authenticate($params) {
        if (!isset($params['username']) || !isset($params['password'])) {
            throw new \Exception("Parâmetros inválidos");
        }

        $password = md5($params['password']);

        $auth = new AuthenticationService();

        echo '<pre>';
        var_dump($password);
        echo '</pre>';



        $authAdapter = new AuthAdapter($this->dbAdapter);

        $authAdapter
                ->setTableName('user')
                ->setIdentityColumn('username')
                ->setCredentialColumn('password')
                ->setIdentity($params['username'])
                ->setCredential($password);
        $result = $auth->authenticate($authAdapter);

        echo '<pre>';
        var_dump($result);
        echo '</pre>';

        if ($result->isValid()) {
            echo 'Login válido';
                    try {

            $session = $this->getServiceManager()->get('Session');

            $session->offsetSet('user', $authAdapter->getResultRowObject());
//           echo '<pre>';
//        var_dump($session);
//        echo '</pre>';
//        exit();

            return true;
        } catch (Exception $exc) {
            echo 'falha ao criar a sessão';
            echo $exc->getTraceAsString();
        }
            
            
            
            
        } else {
            return false;
          //  throw new \Exception("Login ou senha inválidos");
        }

        //salva o user na sessão
        // exit();

    }

    /**
     * Faz o logout do sistema
     *
     * @return void
     */
    public function logout() {
        $auth = new AuthenticationService();
        $session = $this->getServiceManager()->get('Session');
        $session->offsetUnset('user');
        $auth->clearIdentity();
        return true;
    }

    /**
     * Faz a autorização do usuário para acessar o recurso
     * @return boolean
     */
    public function authorize() {
        $auth = new AuthenticationService();
        if ($auth->hasIdentity()) {
            return true;
        }
        return false;
    }

}
