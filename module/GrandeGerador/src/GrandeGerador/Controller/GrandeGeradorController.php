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
    GrandeGerador\Model\ResiduoParaColeta,
    GrandeGerador\Model\Pendencia,
    GrandeGerador\Model\PendenciaTable;

class GrandeGeradorController extends AbstractActionController {

    protected $grandeGeradorTable;

//    public function init() {
//        exit();
//        if (!Zend_Auth::getInstance()->hasIdentity()) {
//            return $this->_helper->redirector->goToRoute(array('controller' => 'auth'), null, true);
//        }
//    }

    public function administracaoAction() {
        if (\Login\Service\Auth::authorize() == false) {
            return $this->redirect()->toRoute('login');
        }
        return new ViewModel();
    }

    /*
     * Exibe a tela de consulta do grande gerador
     */

    public function indexAction() {
        if (\Login\Service\Auth::authorize() == false) {
            return $this->redirect()->toRoute('login');
        }


        $request = $this->getRequest();
        $response = $this->getResponse();
        $adapter = $this->getServiceLocator()->get('AdapterDb');

        $postData = $request->getPost();
        $filtroPesquisa = $postData['filtro_pesquisa'];
        $valor_ditado_pesquisa = $postData['valor_digitado_pesquisa'];

        $data_inicial = '';
        $data_final = '';

        if ($request->isPost()) {

            echo 'post index';
            echo $valor_ditado_pesquisa;
            echo $filtroPesquisa;
            // exit();

            return new ViewModel(array('grandegerador' => $this->getGrandeGeradorTable()->fetchAllComFiltro($adapter, $filtroPesquisa, $valor_ditado_pesquisa, $data_inicial, $data_final),
                'filtroPesquisa' => $filtroPesquisa, 'valorDigitadoPesquisa' => $valor_ditado_pesquisa)
            );
        }

        //  echo 'método index';
        // enviar para view o array com key GrandeGerador e value com todos os GrandeGerador
        $view = new ViewModel(array(array('grandegerador' => $this->getGrandeGeradorTable()->fetchAll())));
        //  $view->setTerminal(true);//desabilita a redenrização da view
        // $view->setTemplate($template);//especifica um template
        //return $view;
        return new ViewModel(array('grandegerador' => $this->getGrandeGeradorTable()->fetchAllPaginaPrincial($adapter),
            'filtroPesquisa' => $filtroPesquisa, 'valorDigitadoPesquisa' => $valor_ditado_pesquisa));
    }

    public function filtrarAction() {
        echo 'metódo filtrar';


        $request = $this->getRequest();
        $response = $this->getResponse();

        $adapter = $this->getServiceLocator()->get('AdapterDb');
        $filtroPesquisa = $_POST['filtro_pesquisa'];
        $valor_ditado_pesquisa = $_POST['valor_digitado_pesquisa'];

        $data_inicial = $_POST['data_inicial'];
        $data_final = $_POST['data_final'];

//        echo 'data inicial  ';
//        echo $data_inicial;
//        echo 'data final  ';
//        echo $data_final;
//        
//        exit();
        //  echo 'método index';
        // enviar para view o array com key GrandeGerador e value com todos os GrandeGerador
        $view = new ViewModel(array(array('grandegerador' => $this->getGrandeGeradorTable()->fetchAll())));
        //  $view->setTerminal(true);//desabilita a redenrização da view
        // $view->setTemplate($template);//especifica um template
        //return $view;
//        echo 'metódo filtrar';
//        
//        echo 'filtro<br>';
//        echo $filtroPesquisa;
//        echo 'Valor digitado pesquisa<br>';
//        echo $valor_ditado_pesquisa;
//          exit();


        if ($request->isPost()) {
            echo 'Metódo Listaaaaaa';

            // $residuoTable->listaResidoPorTipo(2);
            //   echo "aasdf"+$residuoTable->listaResidoPorTipo(2);

            echo '         <thead>';
            echo ' <tr>';
            echo '      <th>Codigo</th>';
            echo '       <th>Nome Fantasia</th>';
            echo '       <th>CNPJ</th>';
            echo '        <th>Razão Social</th>';
            echo '        <th>Endereço</th>';
            echo '       <th>Data Cadastro</th>';
            echo '        <th>Situação</th>';
            echo '       <th>Ação</th>  ';
            echo '   </tr>';
            echo '   </thead>';
            foreach ($this->getGrandeGeradorTable()->fetchAllComFiltro($adapter, $filtroPesquisa, $valor_ditado_pesquisa, $data_inicial, $data_final) as $value) {
                // echo '<option value="' . $value['residuo_id']. '"> ' . utf8_encode($value['residuo_descricao']) . ' </option>';  



                echo '     <tr>';
                echo '     <td>' . $value['grande_gerador_id'] . '</td>';
                echo '     <td>' . $value['grande_gerador_nome_fantasia'] . '</td>';
                echo '     <td class="col-lg-2">' . $value['grande_gerador_cnpj'] . '</td>';
                echo '     <td>' . $value['grande_gerador_razao_social'] . '</td>';
                echo '     <td>' . $value['grande_gerador_rua'] . '</td>';
                echo '     <td>' . date("d-m-Y", strtotime($value['grande_gerador_data_cadastro'])) . '</td>';
                echo '     <td class="col-lg-2">';
                echo '   <select class="col-lg-2 form-control" name="grande_gerador_situacao" id="grande_gerador_situacao' . $value['grande_gerador_id'] . '" itemscope="4564"';
                echo '  onclick="atualizaSituacao(grande_gerador_situacao' . $value['grande_gerador_id'] . ',' . $value['grande_gerador_id'] . ')">';
                echo '      <option value="' . $value['grande_gerador_situacao'] . '">' . $value['grande_gerador_situacao'] . '</option>';
                echo '      <option value="Analisar">Analisar</option>';
                echo '      <option value="Analisando">Analisando</option>';
                echo '      <option value="Pendente">Pendente</option>';
                echo '      <option value="Deferido">Deferido</option>';
                echo '      <option value="Concluido">Concluido</option>';
                echo ' </select>';
                /*     <!-- Div que exibirá o botão de pendencia
                  Esta div só será exibida se situação selecionada for pendente
                  --> */
                echo '  <div class="col-lg-2"  id="pendencia' . $value['grande_gerador_id'] . '"';
                echo ' style="display:';
                if ($value['grande_gerador_situacao'] == 'Pendente') {
                    echo 'block ';
                } else {
                    echo 'none;';
                } echo ' color:red;">';
                echo' <a href="grande-gerador/pendencia/' . $value['grande_gerador_id'] . '" class="btn btn-primary">Pendência</a>';
                echo' </div>';
                // <!-- Input para guardar o valor anterior do combobox situação
                //esta flag é necessário pq quando o usuário seleciona uma situção na combobox ela já é alterada
                //-->
                echo' <input  type="hidden" id="flag_situacao' . $value['grande_gerador_id'] . '" name="flag_situacao' . $value['grande_gerador_id'] . '" value="' . $value['grande_gerador_situacao'] . '">';

                echo ' </td>';
                echo '  <td>';
                echo '<a class="btn btn-primary btn-warning   " title="Editar" href="grande-gerador/autenticar/' . $value['grande_gerador_id'] . ' "><span class="glyphicon glyphicon-edit"></span></a>';
                echo '   </td>';
                echo '  </tr> ';
            }
            //   $this->flashMessenger()->addSuccessMessage("Metódodo Lista");
        }
        return $response;
    }

    /*
     * Verica se o grande gerador esta cadastrado
     * Caso esteja cadastrado retorna os dados do grande gerador
     * @return array com os dados do grande gerador
     */

    public function vericaCadastroGrandeGeradorAction() {
        $request = $this->getRequest();
        $response = $this->getResponse();

        $adapter = $this->getServiceLocator()->get('AdapterDb');
        $grandeGerador = new GrandeGerador();

        $cnpjGrandeGerador = $_POST['cnpj'];

        if ($request->isPost()) {
            $postData = $request->getPost();

            $grandeGerador->grande_gerador_cnpj = $cnpjGrandeGerador;

            /**
             * Realiza uma busca na tabela grade gerador 
             * para buscar o id do grande gerador pelo cnpj
             */
            $grandeGerador = $this->getGrandeGeradorTable()->findCnpj($grandeGerador->grande_gerador_cnpj);

            /**
             * Verifica se o CNPJ informado esta cadastradastro no banco
             */
            $form = (array) $grandeGerador;
            //('a'=>1,'b'=>2,'c'=>3,'d'=>4,'e'=>5);
            //$form = array ('a'=>1,'b'=>2,'c'=>3,'d'=>4,'e'=>5);
            // if (!empty($grandeGerador->grande_gerador_id)) {
            //codifica para um arquivo json
            echo json_encode($grandeGerador);

            //  }

            /*
             * Para usar um retorno json não pode retornar um array no retorno da $response
             */
            return $response;
            // return $response->setContent(array('grandegerador' => $grandeGerador ));
        }
    }

    public function loginAction() {

        // $view = new ViewModel(array(array('grandegerador' => $this->getGrandeGeradorTable()->fetchAll())));
        $view = new ViewModel(array('loginGrandeGerador' => true));


        //$this->setLoginGrandeGerador(true);
        //$view->setTerminal(true);//desabilita a redenrização da view
        // $view->setTemplate('layout/layout_empresa_prestadora.phtml');
        // $view->setTemplate($template);//especifica um template
        return $view;

        /*
         * seta um novo template
         * a tela de login fica sem o layout
         */
        //$view->setTemplate('grande-gerador/grande-gerador/login.phtml');
        //  $view->setTemplate('layout/layout_empresa_prestadora.phtml');
        //  $layout = 'layout.phtml';
        //$this->getGrandeGeradorTable();
        //$this->getServiceLocator()->get('ModelGrandeGerador');
        // init
        // setTemplate
        //$view->setTemplate($layout);//especifica um template
        return $view;
    }

    /**
     * Carrega a view pendencia
     * retorna para a view pendencia o histórico de pendências do grande gerador
     * parametros $id -> recebe o id do grande gerador que receberá a pendência. 
     * @return type
     */
    public function pendenciaAction() {
        if (\Login\Service\Auth::authorize() == false) {
            return $this->redirect()->toRoute('login');
        }

        $adapter = $this->getServiceLocator()->get('AdapterDb');

        // return new ViewModel();
        // filtra pelo id passsado pela url
        $id = (int) $this->params()->fromRoute('id', -1);
        $pendencia = new Pendencia();
        $pendenciaTable = new PendenciaTable($adapter);

        //para , assunto, mensagem 
        // O remetente deve ser um e-mail do seu domínio conforme determina a RFC 822.
// O return-path deve ser ser o mesmo e-mail do remetente.
//        $headers = "MIME-Version: 1.1\r\n";
//        $headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
//        $headers .= "From: juliofsn@hotmail.com\r\n"; // remetente
//        $headers .= "Return-Path: julio.souza@salvador.ba.gov.br\r\n"; // return-path
//        $envio = mail("julio.souza@salvador.ba.gov.br", "Assunto", "Texto", $headers);
        //  echo phpinfo();
//        if ($envio)
//            echo "Mensagem enviada com sucesso";
//        else
//            echo "A mensagem não pode ser enviada";
//
//
//        $to = 'juliofsn@hotmail.com';
//        $subject = 'the subject';
//        $message = 'hello';
//        $headers = 'From: julio.souza@salvador.ba.gov.br' . "\r\n" .
//                'Reply-To: julio.souza@salvador.ba.gov.br' . "\r\n" .
//                'X-Mailer: PHP/' . phpversion();
//
//        mail($to, $subject, $message, $headers);
//
//
//        var_dump(mail('julio.souza@salvador.ba.gov.br', 'teste', 'oi'));
//        exit();
        if ($id != -1) {
            $form = (array) $this->getGrandeGeradorTable()->find($id);

            return array(
                'id' => $id,
                'form' => $form,
                // 'pendencia' => $pendenciaTable->find(1),
                'listaPendencia' => $pendenciaTable->findSQL($id, $adapter),
                    // 'listaPendencia' => $pendenciaTable->findUltimaPendenciaGrandeGerador($id, $adapter),
            );
        }


        //  exit();
        try {

            $form = $id;
        } catch (\Exception $exc) {
            // adicionar mensagem
            // $this->flashMessenger()->addErrorMessage($exc->getMessage());
            // redirecionar para action index
            return $this->redirect()->toRoute('grande-gerador/pendente');
        }

        // dados eviados para editar.phtml
        var_dump($id);
        exit();
        return array('id' => $id, 'form' => $form);
    }

    /**
     * Realiza a aumenteticacao do grande gerador
     * Verica se o mesmo ja esta cadastrado
     * 
     * a tela autenciar é usada tbm para edição do grande gerador pelo administrador da limpurb
     * @return \Zend\View\Model\ViewModel
     */
    public function autenticarAction() {

        $id = (int) $this->params()->fromRoute('id', -1);
        $id2 = $this->params()->fromRoute('id', -1);


        $adapter = $this->getServiceLocator()->get('AdapterDb');
        $prestadoraTable = new PrestadoraTable($adapter);

        $residuoTable = new ResiduoTable($adapter);
        $tipoResiduoTable = new TipoResiduoTable($adapter);
        $residuoHasGrandeGerador = new ResiduosGeradosHasGrandeGeradorTable($adapter);
        $residuoParaColeta = new ResiduoParaColeta();
        $residuoParaColetaTable = new ResiduoParaColetaTable($adapter);



        $request = $this->getRequest();
        $grandegerador = new GrandeGerador();
        $grandegerador2 = new GrandeGerador();
        $cnpj;
        $usuario = 'grande_gerador'; //botão cancelar por padrão redicireciona para a página home
        //  echo "<br>entrou no método autenticar<br><br>";
        /*
         * Se id válido 
         * o usuário clicou em no link editar da tela lista grande geradores
         */
        if ($id != -1) {
            $usuario = 'administrador_limpurb';
            $residuoParaColeta = $residuoParaColetaTable->findPorFkGrandGedaor($id);
            $form = (array) $this->getGrandeGeradorTable()->find($id);


            // exit();
            // $this->flashMessenger()->addSuccessMessage('Grande Geradora Encontrado: ' . $grandegerador->grande_gerador_cnpj);
            // echo 'Grande Gerador Encontrado';
            return array(
                'id' => $id,
                'form' => $form,
                'empresaPrestadora' => $prestadoraTable->fetchAll(),
                'gradegerador' => $this->getGrandeGeradorTable()->fetchAll(),
                'residuo' => $residuoTable->listaResidoPorTipo(2),
                'tipoResiduo' => $tipoResiduoTable->fetchAll(),
                'redisudoHasGrandeGerador' => $residuoHasGrandeGerador->fetchAll(),
                'residuoParaColeta' => $residuoParaColeta,
                'usuario' => $usuario
            );
        }
        /*
         * O usuário esta se autenticando usando o CNPJ
         */ else {

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
                //  echo $grandegerador->grande_gerador_cnpj;
                $cnpj = $grandegerador->grande_gerador_cnpj;
            }

            try {
                /**
                 * Realiza uma busca na tabela grade gerador 
                 * para buscar o id do grande gerador pelo cnpj
                 */
                $grandegerador = $this->getGrandeGeradorTable()->findCnpj($grandegerador->grande_gerador_cnpj);

                /**
                 * Verifica se o CNPJ informado esta cadastradastro no banco
                 */
                if (!empty($grandegerador->grande_gerador_id)) {
                    $pendenciaTable = new PendenciaTable($adapter);
                    $pendencia = new Pendencia();
                    $pendencia = $pendenciaTable->findUltimaPendenciaGrandeGerador($grandegerador->grande_gerador_id, $adapter);

                    if (empty($pendencia->pendencia_id)) {
                        $pendencia = new Pendencia();
                    }

                    $usuario = 'grande_gerador';
                    /**
                     * Busca o residuo para coleta vinculado ao grande gerador
                     */
                    $residoParaColeta = $residuoParaColetaTable->findPorFkGrandGedaor($grandegerador->grande_gerador_id);
                    // print_r($residoParaColeta);
//                  var_dump($residoParaColeta);
                    $form = (array) $this->getGrandeGeradorTable()->findCnpj($grandegerador->grande_gerador_cnpj);
                    /**
                     * verifica se a situação é diferente de anliazando
                     * caso seja a variável habilitaEdicao recebe true
                     */
                    $habilitaEdicao;
                    if ($form['grande_gerador_situacao'] == 'Analisar')
                        $habilitaEdicao = '';
                    else
                        $habilitaEdicao = 'disabled';
                    //  exit();
                    //  $this->flashMessenger()->addSuccessMessage('Grande Geradora Encontrado: ' . $grandegerador->grande_gerador_cnpj);
                    // echo 'Grande Gerador Encontradooooo';

                    return array(
                        'id' => $id,
                        'form' => $form,
                        'empresaPrestadora' => $prestadoraTable->fetchAll(),
                        'gradegerador' => $this->getGrandeGeradorTable()->fetchAll(),
                        'residuo' => $residuoTable->listaResidoPorTipo(2),
                        'tipoResiduo' => $tipoResiduoTable->fetchAll(),
                        'redisudoHasGrandeGerador' => $residuoHasGrandeGerador->fetchAll(),
                        'ultimaPendencia' => $pendencia,
                        'residuoParaColeta' => $residoParaColeta,
                        'habilitaEdicao' => $habilitaEdicao,
                        'usuario' => $usuario
                    );
                }
                /**
                 * Verifica para o primeiro cadastro do grande gerador
                 * verifica se a variável cnpj grande gerador esta preenchida
                 */ else if (!empty($grandegerador2->grande_gerador_cnpj)) {
                    /**
                     * a variável form recebe os dados do objeto grande gerador
                     * é feita a busca pelo CNPJ do grande gerador
                     * a variável form será passada para a view para poder exibir os dados no formulário
                     */
                    $form = (array) $grandegerador2;
                    //  $this->flashMessenger()->addErrorMessage("Grande Geradora Não Cadastrado: " . $grandegerador2->grande_gerador_cnpj);
//                echo '<pre>';
//
//                var_dump($grandegerador2);
//                echo '</pre>';

                    $data = date("d-m-Y");
                    $data_format_banco = date("Y-m-d", strtotime($data));

                    $form['grande_gerador_data_cadastro'] = $data_format_banco;
                    // var_dump($form['grande_gerador_data_cadastro']);
                    return array(
                        'empresaPrestadora' => $prestadoraTable->fetchAll(),
                        'gradegerador' => $grandegerador2,
                        'form' => $form,
                        'residuoParaColeta' => new ResiduoParaColeta(),
                        'usuario' => $usuario
                    );
                }
                /**
                 * Carrega a tela de login
                 * O administrador da limpurb clicou no menu Cadastrar grande gerador
                 */ else {
                     $usuario = 'administrador_limpurb';
                    //  exit();
                    return array('empresaPrestadora' => $prestadoraTable->fetchAll(),
                        'gradegerador' => $grandegerador2,
               //         'form' => $form,
                        'residuoParaColeta' => new ResiduoParaColeta(),
                        'usuario' => $usuario
                    );
                }
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }

//        ));
        }
    }

    // GET /contGrandeGeradoratos/novo
    public function novoAction() {
        if (\Login\Service\Auth::authorize() == false) {
            return $this->redirect()->toRoute('login');
        }
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

    /*
     * Lista os resíduos cadastrado
     * obs: o métido não está sendo mais usado
     * era usado quando a tabela resíduos possuia vinculo com a tabela tipo resíduo
     */

    public function listaAction() {

        $campo = $_POST['campo'];
        $request = $this->getRequest();
        $response = $this->getResponse();
        $grandegerador = new \GrandeGerador\Model\GrandeGerador;       // verifica se a requisição é do tipo post

        $adapter = $this->getServiceLocator()->get('AdapterDb');
        $residuoTable = new ResiduoTable($adapter);
        echo 'Metódo Listaaaaaa';

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

    /**
     * Altera o atributo situação da tabela grande gerador
     * Método ainda não esta sendo utilizado
     * @return type
     */
    public function atualizaSituacaoAction() {

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

    /*
     * Chamado quando o usuário clica no botão salvar grande gerador  na tela autenticar
     * Service para adicionar um grande gerador e atualizar um grande gerador
     */

    public function adicionarAction() {
        if (\Login\Service\Auth::authorize() == false) {
            return $this->redirect()->toRoute('login');
        }
        $adapter = $this->getServiceLocator()->get('AdapterDb');

        $grande_gerador_id = (int) $this->params()->fromRoute('grande_gerador_id', 1);
        // obtém a requisição
        // return new ViewModel(array('grandegerador' => $this->getGrandeGeradorTable()->fetchAll()));
        // echo "<br>clicou no método adicionarAction";
        $request = $this->getRequest();
        $grandegerador = new \GrandeGerador\Model\GrandeGerador;
        $residuoParaColeta = new ResiduoParaColeta();
        $residuoParaColetaTable = new ResiduoParaColetaTable($adapter);
        /*
         * Recebe o nome do usuário que esta acessando a página
         * pode ser o grande gerador ou o administrador limpurb
         */
        $usuario;
        if ($request->isPost()) {// verifica se a requisição é do tipo post
            //  $this->flashMessenger()->addSuccessMessage("Metódodo adicionar");
            // obter e armazenar valores do post
            $postData = $request->getPost();
            $usuario = $postData['usuario'];
            echo $usuario;
            //    echo 'if request';
            // $formularioValido->setData($postData);
            $formularioValido = true;

            if ($formularioValido) {
                echo "<br>if formulario válido";
                $grandegerador->exchangeArray($postData);
                // $grandegerador->grande_gerador_id = $grande_gerador_id;
                $residuoParaColeta->exchangeArray($postData);
                /**
                 * if para vericar se o usuário esta cadastrando ou editando um novo grande garador
                 */
                if (!empty($grandegerador->grande_gerador_id)) {
                    $this->getGrandeGeradorTable()->atualizarGrandeGerador($grandegerador);
                    // $grandegerador = $this->getGrandeGeradorTable()->findCnpj($grandegerador->grande_gerador_cnpj);
                    $residuoParaColeta->grande_gerador_fk = $grandegerador->grande_gerador_id;
                    $residuoParaColetaTable->atualizar($residuoParaColeta);
                }
                /*
                 * O usuário esta atualizando um grande gerador 
                 */ else {
                    $this->getGrandeGeradorTable()->saveGrandeGerador($grandegerador);
                    $grandegerador = $this->getGrandeGeradorTable()->findCnpj($grandegerador->grande_gerador_cnpj);
                    $residuoParaColeta->grande_gerador_fk = $grandegerador->grande_gerador_id;
                    $residuoParaColetaTable->save($residuoParaColeta);
                }

                echo $usuario;
                //  exit();
                if ($usuario == 'administrador_limpurb') {
                    return $this->redirect()->toRoute(
                                    'grande-gerador', array('action' => 'index',
                                'form' => $form,
                                'cnpj' => $cnpj
                    ));
                    $this->flashMessenger()->addSuccessMessage($retorno + " GrandeGerador inserido com sucesso!");
                } else {
                    return $this->redirect()->toRoute(
                                    'grande-gerador', array('action' => 'login',
                                'form' => $form,
                                'cnpj' => $cnpj
                    ));
                    $this->flashMessenger()->addSuccessMessage($retorno + " GrandeGerador inserido com sucesso!");
                }


                /**
                 * Salva o resido para coleta 
                 */
                //     echo '\nsalvando resioParaColeta';
                // $residuoParaColetaTable->save($residuoParaColeta);
                //    echo '\nsalvando resioParaColeta';
                // exit();
                // aqui vai a lógica para adicionar os dados à tabela no banco
                // 1 - solicitar serviço para pegar o model responsável pela adição
                // 2 - inserir dados no banco pelo model
                // adicionar mensagem de sucesso
                // redirecionar para action index no controller GrandeGerador
                // return $this->redirect()->toRoute('grande-gerador');
            } else {
                // adicionar mensagem de erro
                $this->flashMessenger()->addErrorMessage("Erro ao criar GrandeGerador");

                // redirecionar para action novo no controllers GrandeGerador
                return $this->redirect()->toRoute('grande-gerador', array('action' => 'novo'));
            }
        }
    }

    /*
     * Salva uma pendencia 
     * 
     */

    public function salvarPendenciaAction() {
        echo 'Clicou em salvar pendencia';
        // exit();
        $adapter = $this->getServiceLocator()->get('AdapterDb');

        // obtém a requisição
        // return new ViewModel(array('grandegerador' => $this->getGrandeGeradorTable()->fetchAll()));
        // echo "<br>clicou no método adicionarAction";
        $request = $this->getRequest();

        $pendencia = new Pendencia();
        $pendenciaTable = new PendenciaTable($adapter);


        if ($request->isPost()) {// verifica se a requisição é do tipo post
            $postData = $request->getPost();
            $formularioValido = true;
            if ($formularioValido) {
                echo "<br>if formulario válido";
                $pendencia->exchangeArray($postData);
                //$data =  "15/10/2015";
                //$data =  "10/20/2013";
                $data = (date($pendencia->pendencia_data));
                //  $data_format_banco = "";
                // echo '<br>';
                $data_format_banco = date("Y-m-d", strtotime($data));
                // echo $data_format_banco;
                //  echo '<br>';
                //  echo $pendencia->pendencia_data;
                // echo '<br>';
                //  echo '<br>';
                // echo date("Y-m-d",strtotime('12/02/2013')); 
                //exit();
                //exit();
                $pendencia->pendencia_data = $data_format_banco;



                $pendenciaTable->save($pendencia);
                echo 'Pendencia salva com sucesso!!!';
                return $this->redirect()->toRoute('grande-gerador', array('action' => 'index'));
                // $grandegerador = $this->getGrandeGeradorTable()->findCnpj($grandegerador->grande_gerador_cnpj);  
            } else {
                // adicionar mensagem de erro
                $this->flashMessenger()->addErrorMessage("Erro ao criar GrandeGerador");

                // redirecionar para action novo no controllers GrandeGerador
                return $this->redirect()->toRoute('grande-gerador', array('action' => 'index'));
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

        $adapter = $this->getServiceLocator()->get('AdapterDb');
        $residoParaColeta = new ResiduoParaColeta();
        $residoParaColetaTable = new ResiduoParaColetaTable($adapter);


        $id = (int) $this->params()->fromRoute('id', 0);

        // se id = 0 ou não informado redirecione para GrandeGerador
        if (!$id) {
            // adicionar mensagem de erro
            $this->flashMessenger()->addMessage("GrandeGerador não encotrado");
        } else {

            /**
             * Busca o residuo para coleta vinculado ao grande gerador
             */
            $residoParaColeta = $residoParaColetaTable->findPorFkGrandGedaor($id);
            print_r($residoParaColeta->residuo_para_coleta_id);
            //exit();
            if ($residoParaColeta->residuo_para_coleta_id) {
                $residoParaColetaTable->deleteResiduoParaColeta($residoParaColeta->residuo_para_coleta_id);
            }

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
