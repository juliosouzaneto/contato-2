<?php
namespace Login\Controller;
 
use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Login\Form\Login;
 
/**
 * Controlador que gerencia os posts
 * 
 * @category Admin
 * @package Controller
 * @author  Elton Minetto<eminetto@coderockr.com>
 */
class AuthController extends ActionController
{
    /**
     * Mostra o formulário de login
     * @return void
     */
    public function indexAction()
    {
        
        $form = new Login();
        return new ViewModel(array(
            'form' => $form
        ));
    }
 
    /**
     * Faz o login do usuário
     * @return void
     */
    public function loginAction()
    {
        $request = $this->getRequest();
//        if (!$request->isPost()) {
//           
//        }
 
        $data = $request->getPost();
        $service = $this->getService('Login\Service\Auth');
        
          
//     
        try {
             $auth = $service->authenticate(
            array('username' => $data['username'], 'password' => $data['password'])
        );
            
        } catch (Exception $exc) {
             throw new \Exception('Acesso inválido');
            echo $exc->getTraceAsString();
        }
        
        if($auth)
        {
              return $this->redirect()->toRoute('grande-gerador');
        }
        else{
             $this->flashMessenger()->addMessage('Acesso inválido');
            return $this->redirect()->toRoute('login');
           // exit();
           
        }

       
//           var_dump($data);
//        exit();
        
        //return $this->redirect()->toUrl('grande-gerador/administracao');
       
    }
 
    /**
     * Faz o logout do usuário
     * @return void
     */
    public function logoutAction()
    {
        $service = $this->getService('Login\Service\Auth');
        $auth = $service->logout();
        
       // return $this->redirect()->toUrl('auth');
        return $this->redirect()->toRoute('login');
    }
}