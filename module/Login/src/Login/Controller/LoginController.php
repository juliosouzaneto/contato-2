<?php

namespace Login\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Loader\AutoloaderFactory;
use Login\Model\Login;
use Login\Model\LoginTable;
use Zend\Authentication\Result;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable;

// imort Model\ContatoTable com alias
//use Login\Model\LoginTable as ModelPrestadora;

class LoginController extends AbstractActionController {

    protected $pretadoraTable;

    public function getPrestadoraTable() {
        if (!$this->pretadoraTable) {
            $sm = $this->getServiceLocator();
            $this->pretadoraTable = $sm->get('AdapterDb');
        }
        return $this->pretadoraTable;
    }

    // GET /contatos
    public function indexAction() {

        //exit();
        // localizar adapter do banco
        // model ContatoTable instanciadoo
        //  $modelPrestadora = new ModelPrestadora($adapter); // alias para ContatoTable
        // enviar para view o array com key contatos e value com todos os contatos
        return new ViewModel();
    }

    public function limpurbloginAction() {

        $request = $this->getRequest();
        //  $this->getRequest();

        $adapter = $this->getServiceLocator()->get('AdapterDb');
        $request = $this->getRequest();
        $usuario = $request->getPost('login');
        $senha = $request->getPost('senha');

        if ($request->isPost()) {
            try {
                
                 echo 'clicou em confirmar';
              //   exit();

                // Recebe os parâmetros login e senha via post
                $request = $this->getRequest();
                
                  $postData = $request->getPost();
                  var_dump($postData);
                //  exit();
                  
            $login = $postData['usuario'];
            $senha = $postData['senha'];
                
           
          //      $login = 'julio';
            //    $senha = '123g';

                /*
                 * Get no adaptador do banco de dados, neste caso você precisa verificar&nbsp;
                 * qual foi o nome usado para o adaptador.
                 */
                $zendDb = $this->getServiceLocator()->get('AdapterDb');
                /* Criando o auth adapter:&nbsp;
                 * passando o primeiro parâmetro o adaptador do banco de dados $zendDb
                 * segundo parâmetro a tabela de usuarios
                 * terceiro parâmetro a coluna da tabela aonde está o login
                 * quarto parâmetro a coluna da tabela aonde está a senha
                 */
                $authAdapter = new DbTable(
                        $zendDb, 'login', 'login_usuario', 'login_senha'
                );
                /* Seta o credential tratment:&nbsp;
                 * tratamento da senha para ser criptografada em md5
                 * passado um parâmetro status para logar o usuario que esteja ativo no sistema
                 * no caso dos parâmetros você pode passar quantos forem necessários usando o AND
                 * na sequência seta o Identity que é o login e Credential que é a senha
                 */
                $authAdapter->setCredentialTreatment('usuario_status = 1');
                $authAdapter->setIdentity($login); //&nbsp;
                $authAdapter->setCredential($senha);

// Instanciando o AutenticationService para fazer a altenticação com os dados passados para o authAdapter
                $authService = new AuthenticationService();

// Autenticando o passando para a variável result o resultado da autenticação
                $result = $authService->authenticate($authAdapter);

// Validando a autenticação
                if ($result->isValid()) {
                   // $request->
                    //      if ($request->isPost()) {

                    echo 'login válido';
                    
                    // exit();
                
                // Se validou damos um get nos dados autenticados usando o $result->getIdentity()
                $identity = $result->getIdentity();
                
                return $this->redirect()->toRoute('grande-gerador');

                /* Imprimindo os dados na tela para confirmar os dados autenticados
                 * pronto, se aparecer os dados isso quer dizer que o usuario está autenticado no sistema
                 */
               
                //   exit();
                //   exit(var_dump($identity));
                } else {
                /* Caso falhe a autenticação, será gerado o log abaixo que será impresso&nbsp;
                 * na tela do computador para você sabe do problema ocorrido.
                 * os erros listados abaixo são os erros mais comuns que podem ocorrer.
                 */
                switch ($result->getCode()) {
                    case Result::FAILURE_IDENTITY_NOT_FOUND:
                        echo "O email não existe";
                        break;
                    case Result::FAILURE_CREDENTIAL_INVALID:
                        echo "A senha está incorreta";
                        break;
                    default:
                        foreach ($result->getMessages() as $message) {
                            echo $message;
                        }
                }
                  }
            } catch (Exception $exc) {
                throw new \Exception("Não foi encontrado contado de id = {$id}");
                echo $exc->getTraceAsString();
            }
        }


        //exit();
        // localizar adapter do banco
        // $adapter = $this->getServiceLocator()->get('AdapterDb');
        // model ContatoTable instanciadoo
        //  $modelPrestadora = new ModelPrestadora($adapter); // alias para ContatoTable
        // enviar para view o array com key contatos e value com todos os contatos
        return new ViewModel();
    }
    public function logoutAction() {

        $request = $this->getRequest();
        //  $this->getRequest();

        $adapter = $this->getServiceLocator()->get('AdapterDb');
        

        if ($request->isPost()) {
          
                
                 echo 'clicou em sair';
              //  exit();

                // Recebe os parâmetros login e senha via post
                $request = $this->getRequest();
                
                  $postData = $request->getPost();
                  var_dump($postData);
                //  exit();
                  
            $login = $postData['usuario'];
            $senha = $postData['senha'];

                $zendDb = $this->getServiceLocator()->get('AdapterDb');
        

// Instanciando o AutenticationService para fazer a altenticação com os dados passados para o authAdapter
                $authService = new AuthenticationService();

// Autenticando o passando para a variável result o resultado da autenticação
             $result = $authService->clearIdentity();($authAdapter);

                
                return $this->redirect()->toRoute('login');

   
            }

        //exit();
        // localizar adapter do banco
        // $adapter = $this->getServiceLocator()->get('AdapterDb');
        // model ContatoTable instanciadoo
        //  $modelPrestadora = new ModelPrestadora($adapter); // alias para ContatoTable
        // enviar para view o array com key contatos e value com todos os contatos
        return new ViewModel();
    }

}
