<?php

/**
 * namespace de localizacao do nosso controller
 */

namespace GrandeGerador\Controller;

// import Zend\Mvc
use Zend\Mvc\Controller\AbstractActionController;
// import Zend\View
use Zend\View\Model\ViewModel, 
    Prestadora\Model\PrestadoraTable,
    GrandeGerador\Model\GrandeGerador;

class GrandeGeradorController extends AbstractActionController {

    protected $grandeGeradorTable;
     

    // GET /GrandeGerador
    public function indexAction() {
        // enviar para view o array com key GrandeGerador e value com todos os GrandeGerador
        return new ViewModel(array('grandegerador' => $this->getGrandeGeradorTable()->fetchAll()));
    }

    
    // GET /contGrandeGeradoratos/novo
    public function novoAction() {
        
         $adapter = $this->getServiceLocator()->get('AdapterDb');
        
        $prestadoraTable = new PrestadoraTable($adapter);
        
        return new ViewModel(array('empresaPrestadora' => $prestadoraTable->fetchAll(), 'gradegerador' => $this->getGrandeGeradorTable()->fetchAll() ) );
    }

    // POST /GrandeGerador/adicionar
    public function adicionarAction() {
        // obtém a requisição
        // return new ViewModel(array('grandegerador' => $this->getGrandeGeradorTable()->fetchAll()));
        echo "<br>clicou no método adicionarAction";
        $request = $this->getRequest();
        $grandegerador = new \GrandeGerador\Model\GrandeGerador();

        // verifica se a requisição é do tipo post
        if ($request->isPost()) {
            // obter e armazenar valores do post
            $postData = $request->getPost();
            echo 'if request';
            // $formularioValido->setData($postData);
            $formularioValido = true;
            
           //  $grandegerador->exchangeArray($postData);
           // validaCamposGrandeGerador( $grandegerador);
                
               
            // verifica se o formulário segue a validação proposta
            if ($formularioValido) {
                echo "<br>if formulario válido";
                $grandegerador->exchangeArray($postData);
                echo "<br>if formulario válido2";
                $this->getGrandeGeradorTable()->saveGrandeGerador($grandegerador);
                     echo "<br>if formulario válido3";

                // aqui vai a lógica para adicionar os dados à tabela no banco
                // 1 - solicitar serviço para pegar o model responsável pela adição
                // 2 - inserir dados no banco pelo model
                // adicionar mensagem de sucesso
                $this->flashMessenger()->addSuccessMessage("GrandeGerador criado com sucesso");

                // redirecionar para action index no controller GrandeGerador
                return $this->redirect()->toRoute('grande-gerador');
            } else {
                // adicionar mensagem de erro
                $this->flashMessenger()->addErrorMessage("Erro ao criar GrandeGerador");

                // redirecionar para action novo no controllers GrandeGerador
                return $this->redirect()->toRoute('grande-gerador', array('action' => 'novo'));
            }
        }
    }

    // GET /GrandeGerador/detalhes/id
    public function detalhesAction() {
        echo "<br>entrou no método detalhesAction";
        // filtra id passsado pela url
        $id = (int) $this->params()->fromRoute('id', 1);
       // $id = 2;

        // se id = 0 ou não informado redirecione para GrandeGerador
        if (!$id) {
            // adicionar mensagem
            $this->flashMessenger()->addMessage("GrandeGerador não encotrado");

            // redirecionar para action index
            return $this->redirect()->toRoute('grandegerador');
        }

        try {
            // aqui vai a lógica para pegar os dados referente ao GrandeGerador
            // 1 - solicitar serviço para pegar o model responsável pelo find
            // 2 - solicitar form com dados desse GrandeGerador encontrado
            // formulário com dados preenchidos
            $form = (array) $this->getGrandeGeradorTable()->find($id);
        } catch (\Exception $exc) {
            
            
            
            
            // adicionar mensagem
            $this->flashMessenger()->addErrorMessage($exc->getMessage());

            // redirecionar para action index
            return $this->redirect()->toRoute('grande-gerador');
        }

        // dados eviados para detalhes.phtml
        return array('id' => $id, 'form' => $form);
    }

    // GET /GrandeGerador/editar/id
    public function editarAction() {
        // filtra id passsado pela url
        $id = (int) $this->params()->fromRoute('id', 1);

        // se id = 0 ou não informado redirecione para GrandeGerador
        if (!$id) {
            // adicionar mensagem de erro
            $this->flashMessenger()->addMessage("GrandeGerador não encotrado");

            // redirecionar para action index
            return $this->redirect()->toRoute('grande-gerador');
        }

        try {
            // aqui vai a lógica para pegar os dados referente ao GrandeGerador
            // 1 - solicitar serviço para pegar o model responsável pelo find
            // 2 - solicitar form com dados desse GrandeGerador encontrado
            // formulário com dados preenchidos
            $form = (array) $this->getGrandeGeradorTable()->find($id);
        } catch (\Exception $exc) {
            // adicionar mensagem
            $this->flashMessenger()->addErrorMessage($exc->getMessage());

            // redirecionar para action index
            return $this->redirect()->toRoute('grande-gerador');
        }

        // dados eviados para editar.phtml
        return array('id' => $id, 'form' => $form);
    }

    // PUT /GrandeGerador/editar/id
    public function atualizarAction() {
        // obtém a requisição
        $request = $this->getRequest();

        // verifica se a requisição é do tipo post
        if ($request->isPost()) {
            // obter e armazenar valores do post
            $postData = $request->getPost()->toArray();
            $formularioValido = true;

            // verifica se o formulário segue a validação proposta
            if ($formularioValido) {
                // aqui vai a lógica para editar os dados à tabela no banco
                // 1 - solicitar serviço para pegar o model responsável pela atualização
                // 2 - editar dados no banco pelo model
                // adicionar mensagem de sucesso
                $this->flashMessenger()->addSuccessMessage("GrandeGerador editado com sucesso");

                // redirecionar para action detalhes
                return $this->redirect()->toRoute('grande-gerador', array("action" => "detalhes", "id" => $postData['id'],));
            } else {
                // adicionar mensagem de erro
                $this->flashMessenger()->addErrorMessage("Erro ao editar GrandeGerador");

                // redirecionar para action editar
                return $this->redirect()->toRoute('grande-gerador', array('action' => 'editar', "id" => $postData['id'],));
            }
        }
    }

    // DELETE /GrandeGerador/deletar/id
    public function deletarAction() {
        // filtra id passsado pela url
        $id = (int) $this->params()->fromRoute('id', 0);

        // se id = 0 ou não informado redirecione para GrandeGerador
        if (!$id) {
            // adicionar mensagem de erro
            $this->flashMessenger()->addMessage("GrandeGerador não encotrado");
        } else {
            // aqui vai a lógica para deletar o GrandeGerador no banco
            // 1 - solicitar serviço para pegar o model responsável pelo delete
            // 2 - deleta GrandeGerador
            // adicionar mensagem de sucesso
            $this->getGrandeGeradorTable()->deleteGrandeGerador($id);
            $this->flashMessenger()->addSuccessMessage("GrandeGerador de ID $id deletado com sucesso");
        }

        // redirecionar para action index
        return $this->redirect()->toRoute('grande-gerador');
    }

    /**
     * Metodo privado para obter instacia do Model GrandeGeradorTable
     * 
     * @return \GrandeGerador\Model\GrandeGeradorTable
     */
    private function getGrandeGeradorTable() {
        // adicionar service ModelGrandeGerador a variavel de classe
        if (!$this->grandeGeradorTable) {
            $this->grandeGeradorTable = $this->getServiceLocator()->get('ModelGrandeGerador');
        }

        // return vairavel de classe com service ModelGrandeGerador
        return $this->grandeGeradorTable;
    }
    
    
    /**
     * Valida os campos do formulário
     * @param \GrandeGerador\Controller\GrandeGerador $grandegerador
     * @return boolean
     */
     public  function  ValidaCamposGrandeGerador(GrandeGerador $grandegerador)
    {
         //!isset($_POST['Idade']) || ($_POST['Idade']=="")
        if(!isset($grandegerador->grande_gerador_cnpj) || $grandegerador->grande_gerador_cnpj == "")
        {
            $this->flashMessenger()->addErrorMessage("O CNPJ deve ser preenchindo");
            return false;
        }
        
        return true;
    }

}
