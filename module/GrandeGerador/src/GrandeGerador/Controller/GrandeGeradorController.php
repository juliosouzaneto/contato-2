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
    Residuo\Model\TipoResiduoTable,
    Residuo\Model\ResiduoTable,
    GrandeGerador\Model\GrandeGerador,
    GrandeGerador\Model\ResiduosGeradosHasGrandeGerador,
    GrandeGerador\Model\ResiduosGeradosHasGrandeGeradorTable,
    GrandeGerador\Model\ResiduoParaColetaTable,
    GrandeGerador\Model\ResiduoParaColeta;

class GrandeGeradorController extends AbstractActionController {

    protected $grandeGeradorTable;

    // GET /GrandeGerador
    public function indexAction() {
        $request = $this->getRequest();
        $response = $this->getResponse();

        echo 'método index';


        // enviar para view o array com key GrandeGerador e value com todos os GrandeGerador
        $view = new ViewModel(array(array('grandegerador' => $this->getGrandeGeradorTable()->fetchAll())));
        //  $view->setTerminal(true);//desabilita a redenrização da view
        // $view->setTemplate($template);//especifica um template
        //return $view;
        return new ViewModel(array('grandegerador' => $this->getGrandeGeradorTable()->fetchAll()));
    }

    public function loginAction() {

        return new ViewModel();
    }

    /**
     * Realiza a aumenteticacao do grande gerado
     * Verica se o mesmo ja esta cadastrado
     * @return \Zend\View\Model\ViewModel
     */
    public function autenticarAction() {

        $id = (int) $this->params()->fromRoute('id', -1);


        $adapter = $this->getServiceLocator()->get('AdapterDb');
        $prestadoraTable = new PrestadoraTable($adapter);

        $residuoTable = new ResiduoTable($adapter);
        $tipoResiduoTable = new TipoResiduoTable($adapter);
        $residuoHasGrandeGerador = new ResiduosGeradosHasGrandeGeradorTable($adapter);
        $residuoParaColeta = new ResiduoParaColetaTable($adapter);


        $request = $this->getRequest();
        $grandegerador = new GrandeGerador();
        $grandegerador2 = new GrandeGerador();
        $cnpj;

        echo "<br>entrou no método autenticar<br><br>";

        /*
         * Se id válido 
         * o usuário clicou em no link editar da tela lista grande geradores
         */
        if ($id != -1) {
            echo 'if' . $id;
            $form = (array) $this->getGrandeGeradorTable()->find($id);

            $this->flashMessenger()->addSuccessMessage('Grande Geradora Encontrado: ' . $grandegerador->grande_gerador_cnpj);
            echo 'Grande Gerador Encontrado';

            return array(
                'id' => $id,
                'form' => $form,
                'empresaPrestadora' => $prestadoraTable->fetchAll(),
                'gradegerador' => $this->getGrandeGeradorTable()->fetchAll(),
                'residuo' => $residuoTable->listaResidoPorTipo(2),
                'tipoResiduo' => $tipoResiduoTable->fetchAll(),
                'redisudoHasGrandeGerador' => $residuoHasGrandeGerador->fetchAll(), 
                'residuoParaColega' => $residuoParaColeta->fetchAll()
            );
        } else {
            //$id = (int) $this->params()->fromRoute('id', 1);
            //  $id = $this->params()->fromRoute('id');
            // echo $id;

            /**
             * verifica se a requisição é do tipo post
             */
            if ($request->isPost()) {
                $postData = $request->getPost();

                //echo '<br><br>CNPJ: ';
                //echo $grandegerador->grande_gerador_cnpj;
                // echo $postData+'<br>';
                $grandegerador->exchangeArray2($postData);
                $grandegerador2->exchangeArray2($postData);
                echo $grandegerador->grande_gerador_cnpj;
                $cnpj = $grandegerador->grande_gerador_cnpj;
            }

            /**
             * Realiza uma busca na tabela grade gerador 
             * para buscar o id do grande gerador pelo cnpj
             */
            $grandegerador = $this->getGrandeGeradorTable()->findCnpj($grandegerador->grande_gerador_cnpj);

            echo 'id grande gerador: <br>';
            /**
             * a variável form recebe os dados do objeto grande gerador
             * é feita a busca pelo CNPJ do grande gerador
             * a variável form será passada para a view para poder exibir os dados no formulário
             */
            try {
                /**
                 * Verifica se o CNPJ informado esta cadastradastro no banco
                 */
                if ($grandegerador->grande_gerador_id) {
                    $form = (array) $this->getGrandeGeradorTable()->findCnpj($grandegerador->grande_gerador_cnpj);

                    $this->flashMessenger()->addSuccessMessage('Grande Geradora Encontrado: ' . $grandegerador->grande_gerador_cnpj);
                    echo 'Grande Gerador Encontrado';

                    return array(
                        'id' => $id,
                        'form' => $form,
                        'empresaPrestadora' => $prestadoraTable->fetchAll(),
                        'gradegerador' => $this->getGrandeGeradorTable()->fetchAll(),
                        'residuo' => $residuoTable->listaResidoPorTipo(2),
                        'tipoResiduo' => $tipoResiduoTable->fetchAll(),
                        'redisudoHasGrandeGerador' => $residuoHasGrandeGerador->fetchAll(),
                        'residuoParaColega' => $residuoParaColeta->fetchAll()
                    );
                } 
                /**
                 * Verifica para o primeiro cadastro do grande gerador
                 * verifica se a variável cnpj grande gerador esta preenchida
                 */
                else if ($grandegerador2->grande_gerador_cnpj) {
                    $form = (array) $grandegerador2;
                    $this->flashMessenger()->addErrorMessage("Grande Geradora Não Cadastrado: " . $grandegerador2->grande_gerador_cnpj);
                    echo 'Grande Geradora Não Cadastrado';
//                echo '<pre>';
//
//                var_dump($grandegerador2);
//                echo '</pre>';
                    return array(
                        'empresaPrestadora' => $prestadoraTable->fetchAll(),
                        'gradegerador' => $grandegerador2,
                        'form' => $form
                    );
//                return $this->redirect()->toRoute(
//                                'grande-gerador', array('action' => 'novo',
//                            'form' => $form,
//                            'cnpj' => $cnpj,
//                            'gradegerador' => $grandegerador2
//                ));

                }
                /**
                 * Carrega a tela de login
                 */
                else {
                    return $this->redirect()->toRoute(
                                    'grande-gerador', array('action' => 'login',
                                'form' => $form,
                                'cnpj' => $cnpj,
                                'gradegerador' => $grandegerador2
                    ));
                }
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }



            // $adapter = $this->getServiceLocator()->get('AdapterDb');
//        $prestadoraTable = new PrestadoraTable($adapter);
//        $residuoTable = new ResiduoTable($adapter);
//        $tipoResiduoTable = new TipoResiduoTable($adapter);
//        $residuoHasGrandeGerador = new ResiduosGeradosHasGrandeGeradorTable($adapter);
            //   return $this->redirect()->toRoute('grande-gerador');
            // return $this->redirect()->toRoute('grande-gerador', array("action" => "detalhes", "id" => $postData['id'],));
//        return new ViewModel(array('empresaPrestadora' => $prestadoraTable->fetchAll(),
//            'gradegerador' => $this->getGrandeGeradorTable()->fetchAll(),
//            'residuo' => $residuoTable->listaResidoPorTipo(2),
//            'tipoResiduo' => $tipoResiduoTable->fetchAll(),
//            'redisudoHasGrandeGerador' => $residuoHasGrandeGerador->fetchAll()
//        ));
        }
    }

    // GET /contGrandeGeradoratos/novo
    public function novoAction() {


//        $request = $this->getRequest();
//        $grandegerador = new GrandeGerador();
//        if ($request->isPost) {// verifica se a requisição é do tipo post
//            $postData = $request->getPost();
//            echo '<pre>';
//
//            var_dump($postData);
//            echo '</pre>';
//
//
//            //echo '<br><br>CNPJ: ';
//            //echo $grandegerador->grande_gerador_cnpj;
//            // echo $postData+'<br>';
//            $grandegerador->exchangeArray2($postData);
//            echo $grandegerador->grande_gerador_cnpj;
//        }

        $cnpj = (string) $this->params()->fromRoute('cnpj', 0);
        echo 'valor cnpj: ';
        echo $cnpj;
        $adapter = $this->getServiceLocator()->get('AdapterDb');

        $prestadoraTable = new PrestadoraTable($adapter);
        $residuoTable = new ResiduoTable($adapter);
        $tipoResiduoTable = new TipoResiduoTable($adapter);
        $residuoHasGrandeGerador = new ResiduosGeradosHasGrandeGeradorTable($adapter);

        return new ViewModel(array('empresaPrestadora' => $prestadoraTable->fetchAll(),
            'gradegerador' => $this->getGrandeGeradorTable()->fetchAll(),
            'residuo' => $residuoTable->listaResidoPorTipo(2),
            'tipoResiduo' => $tipoResiduoTable->fetchAll(),
            'redisudoHasGrandeGerador' => $residuoHasGrandeGerador->fetchAll()
        ));
    }

    public function listaAction() {

        $campo = $_POST['campo'];
        $request = $this->getRequest();
        $response = $this->getResponse();
        $grandegerador = new \GrandeGerador\Model\GrandeGerador;       // verifica se a requisição é do tipo post

        $adapter = $this->getServiceLocator()->get('AdapterDb');
        $residuoTable = new ResiduoTable($adapter);

        if ($request->isPost()) {
            echo 'Metódo Listaaaaaa';

            // $residuoTable->listaResidoPorTipo(2);
            //   echo "aasdf"+$residuoTable->listaResidoPorTipo(2);

            echo '<option value="0"> Selecione </option>';
            foreach ($residuoTable->listaResidoPorTipo($campo) as $value) {
                //echo '<option value="' . $value['residuo_id']. '"> ' . utf8_encode($value['residuo_descricao']) . ' </option>';  
                echo '<option value="' . $value->residuo_id . '"> ' . ($value->residuo_descricao) . ' </option>';
            }
            $this->flashMessenger()->addSuccessMessage("Metódodo Lista");

            return $response->setContent(array(
                        'residuo' => $residuoTable->listaResidoPorTipo(2)
            ));
        }
    }

    public function addAction() {
        $request = $this->getRequest();
        $response = $this->getResponse();
        echo 'entrou no metodo add';
        if ($request->isPost()) {
            $new_note = new \StickyNotes\Model\Entity\StickyNote();
            if (!$note_id = $this->getStickyNotesTable()->saveStickyNote($new_note))
                $response->setContent(\Zend\Json\Json::encode(array('response' => false)));
            else {
                $response->setContent(\Zend\Json\Json::encode(array('response' => true, 'new_note_id' => $note_id)));
            }
        }
        return $response;
    }

    // POST /GrandeGerador/adicionar
    public function adicionarAction() {


        $grande_gerador_id = (int) $this->params()->fromRoute('grande_gerador_id', 1);
        // obtém a requisição
        // return new ViewModel(array('grandegerador' => $this->getGrandeGeradorTable()->fetchAll()));
        echo "<br>clicou no método adicionarAction";
        $request = $this->getRequest();
        $grandegerador = new \GrandeGerador\Model\GrandeGerador;
        $residuoParaColeta = new ResiduoParaColeta();
        if ($request->isPost()) {// verifica se a requisição é do tipo post
            //  $this->flashMessenger()->addSuccessMessage("Metódodo adicionar");
            // obter e armazenar valores do post
            $postData = $request->getPost();
            echo 'if request';
            // $formularioValido->setData($postData);
            $formularioValido = true;

            //  $grandegerador->exchangeArray($postData);
            // validaCamposGrandeGerador( $grandegerador);
            // verifica se o formulário segue a validação proposta
//            echo '<pre>';
//
//            var_dump($postData);
//            echo '</pre>';

            if ($formularioValido) {
                echo "<br>if formulario válido";
                $grandegerador->exchangeArray($postData);
                // $grandegerador->grande_gerador_id = $grande_gerador_id;

                $residuoParaColeta->exchangeArray($postData);
                print_r($residuoParaColeta);
                exit;


//                echo '<pre>';
//                var_dump();
//                
//
//                echo '</pre>';
                 $this->getGrandeGeradorTable()->saveGrandeGerador($grandegerador);


                // aqui vai a lógica para adicionar os dados à tabela no banco
                // 1 - solicitar serviço para pegar o model responsável pela adição
                // 2 - inserir dados no banco pelo model
                // adicionar mensagem de sucesso
                $this->flashMessenger()->addSuccessMessage($retorno + " GrandeGerador criado com sucesso" + $residuohasGrandeGerador);

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
    public function ValidaCamposGrandeGerador(GrandeGerador $grandegerador) {
        //!isset($_POST['Idade']) || ($_POST['Idade']=="")
        if (!isset($grandegerador->grande_gerador_cnpj) || $grandegerador->grande_gerador_cnpj == "") {
            $this->flashMessenger()->addErrorMessage("O CNPJ deve ser preenchindo");
            return false;
        }

        return true;
    }

}
