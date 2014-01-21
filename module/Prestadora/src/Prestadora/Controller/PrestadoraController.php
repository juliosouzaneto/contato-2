<?php

namespace Prestadora\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Prestadora\Model\Prestadora;
use Prestadora\Model\PrestadoraTable;
// imort Model\ContatoTable com alias
use Prestadora\Model\PrestadoraTable as ModelPrestadora;

class PrestadoraController extends AbstractActionController {

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
        // localizar adapter do banco
        $adapter = $this->getServiceLocator()->get('AdapterDb');

        // model ContatoTable instanciadoo
        $modelPrestadora = new ModelPrestadora($adapter); // alias para ContatoTable
        // enviar para view o array com key contatos e value com todos os contatos
        return new ViewModel(array('prestadora' => $modelPrestadora->fetchAll()));
    }

    // GET /contatos/novo
    public function novoAction() {
        // obtém a requisição
        $request = $this->getRequest();

        // verifica se a requisição é do tipo post
        if ($request->isPost()) {
            // obter e armazenar valores do post
            $postData = $request->getPost()->toArray();

            // $formularioValido = get('submit')->setValue('Add');

            $formularioValido = true;

            // verifica se o formulário segue a validação proposta
            if ($formularioValido) {

                $prestadora = new Prestadora();
                $prestadora->exchangeArray($postData);


                $adapter = $this->getServiceLocator()->get('AdapterDb');

                // model ContatoTable instanciadoo
                $modelPrestadora = new ModelPrestadora($adapter); // alias para ContatoTable
                
                $modelPrestadora->savePrestadora($prestadora);
                //$this->
                //  $prestadora->
                // aqui vai a lógica para adicionar os dados à tabela no banco
                // 1 - solicitar serviço para pegar o model responsável pela adição
                // 2 - inserir dados no banco pelo model
                // adicionar mensagem de sucesso
                $this->flashMessenger()->addSuccessMessage("Contato criado com sucesso");

                // redirecionar para action index no controller contatos
                $this->_helper->layout->setLayout('layout2');
                return $this->redirect()->toRoute('prestadora');
            } else {
                // adicionar mensagem de erro
                $this->flashMessenger()->addErrorMessage("Erro ao criar contato");

                // redirecionar para action novo no controllers contatos
                return $this->redirect()->toRoute('prestadora', array('action' => 'novo'));
            }
        }
    }

    // POST /contatos/adicionar
    public function adicionarAction() {
        
    }

    // GET /contatos/editar/id
    public function editarAction() {
        // filtra id passsado pela url
        $id = (int) $this->params()->fromRoute('id', 0);

        // se id = 0 ou não informado redirecione para contatos
        if (!$id) {
            // adicionar mensagem de erro
            $this->flashMessenger()->addMessage("Contato não encotrado");

            // redirecionar para action index
            return $this->redirect()->toRoute('prestadora');
        }

        // aqui vai a lógica para pegar os dados referente ao contato
        // 1 - solicitar serviço para pegar o model responsável pelo find
        // 2 - solicitar form com dados desse contato encontrado
        // formulário com dados preenchidos
        $form = array(
            'nome' => 'Igor Rocha',
            "telefone_principal" => "(085) 8585-8585",
            "telefone_secundario" => "(085) 8585-8585",
        );

        // dados eviados para editar.phtml
        return array('id' => $id, 'form' => $form);
    }

    // GET /contatos/detalhes/id
    public function detalhesAction() {
        // filtra id passsado pela url
        $id = (int) $this->params()->fromRoute('id', 0);

        // se id = 0 ou não informado redirecione para contatos
        if (!$id) {
            // adicionar mensagem
            $this->flashMessenger()->addMessage("Contato não encotrado");

            // redirecionar para action index
            return $this->redirect()->toRoute('prestadora');
        }

        // aqui vai a lógica para pegar os dados referente ao contato
        // 1 - solicitar serviço para pegar o model responsável pelo find
        // 2 - solicitar form com dados desse contato encontrado
        // formulário com dados preenchidos
//        $form = array(
//            'nome' => 'Igor Rocha',
//            "telefone_principal" => "(085) 8585-8585",
//            "telefone_secundario" => "(085) 8585-8585",
//            "data_criacao" => "02/03/2013",
//            "data_atualizacao" => "02/03/2013",
//        );
        //localizar adapter do banco
        $adapter = $this->getServiceLocator()->get('AdapterDb');

        //model ContatoTable instanciado
        $modelPrestadora = new ModelPrestadora($adapter);

        try {
            $form = (array) $modelPrestadora->find($id);
        } catch (\Exception $exc) {
            // adicionar mensagem
            $this->flashMessenger()->addErrorMessage($exc->getMessage());

            // redirecionar para action index
            return $this->redirect()->toRoute('contatos');
        }




        // dados eviados para detalhes.phtml
        return array('id' => $id, 'form' => $form);
    }

    // PUT /contatos/editar/id
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
                $this->flashMessenger()->addSuccessMessage("Contato editado com sucesso");

                // redirecionar para action detalhes
                return $this->redirect()->toRoute('contatos', array("action" => "detalhes", "id" => $postData['id'],));
            } else {
                // adicionar mensagem de erro
                $this->flashMessenger()->addErrorMessage("Erro ao editar contato");

                // redirecionar para action editar
                return $this->redirect()->toRoute('contatos', array('action' => 'editar', "id" => $postData['id'],));
            }
        }
    }

    // DELETE /contatos/deletar/id
    public function deletarAction() {
        // filtra id passsado pela url
        $id = (int) $this->params()->fromRoute('id', 0);

        // se id = 0 ou não informado redirecione para contatos
        if (!$id) {
            // adicionar mensagem de erro
            $this->flashMessenger()->addMessage("Contato não encotrado");
        } else {
            // aqui vai a lógica para deletar o contato no banco
            // 1 - solicitar serviço para pegar o model responsável pelo delete
            // 2 - deleta contato
            // adicionar mensagem de sucesso
            $this->flashMessenger()->addSuccessMessage("Contato de ID $id deletado com sucesso");
        }

        // redirecionar para action index
        return $this->redirect()->toRoute('contatos');
    }

}
