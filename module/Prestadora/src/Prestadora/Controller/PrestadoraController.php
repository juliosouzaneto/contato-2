<?php

namespace Prestadora\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Prestadora\Model\Prestadora;
use Prestadora\Model\PrestadoraTable;
use Prestadora\Model\Veiculo;
use Prestadora\Model\VeiculoTable;

//use Prestadora\Model\PrestadoraTable;
// imort Model\ContatoTable com alias
//use Prestadora\Model\PrestadoraTable as ModelPrestadora;

class PrestadoraController extends AbstractActionController {

    protected $pretadoraTable;

    public function getPrestadoraTable() {
        if (\Login\Service\Auth::authorize() == false) {
            return $this->redirect()->toRoute('login');
        }
        if (!$this->pretadoraTable) {
            $sm = $this->getServiceLocator();
            $this->pretadoraTable = $sm->get('AdapterDb');
        }
        return $this->pretadoraTable;
    }

    // GET /contatos
    public function indexAction() {
             if (\Login\Service\Auth::authorize() == false) {
            return $this->redirect()->toRoute('login');
        }
        $request = $this->getRequest();


//        if ($request->isPost()) {
//

        $id = (int) $this->params()->fromRoute('id', 0);
        $pagina = (int) $this->params()->fromRoute('pagina', 0);
//        } else {
//            $pagina = 1;
//        }
//            if($pagina  < 0){
//                $pagina = 1;
//                
//                echo $pagina;
//                
//            }
        //   $postData = $request->getPost();
        //$postData[''];
        // localizar adapter do banco
        $adapter = $this->getServiceLocator()->get('AdapterDb');
        $intensPorPagina = 5;
        //$pagina = 2;
        // model ContatoTable instanciadoo
        $modelPrestadora = new PrestadoraTable($adapter); // alias para ContatoTable
        //
        //
         //var_dump($modelPrestadora->fetchAllPaginacao($adapter, $intensPorPagina, 3 )->getItemCountPerPage());
        // exit();
        //
        // enviar para view o array com key contatos e value com todos os contatos
        $paginator = $modelPrestadora->fetchAllPaginacao($adapter, $intensPorPagina, $pagina);
        $totalPagina = $paginator->count();

        return new ViewModel(array('prestadora' => $paginator,
            'intensPorPagina' => $intensPorPagina,
            'pagina' => $pagina,
            'totalPagina' => $totalPagina));
    }

    public function paginacaoAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        $pagina = (int) $this->params()->fromRoute('pagina', 0);

        // exit();
        // $request = $this->getRequest();
        // $response = $this->getResponse();
        $adapter = $this->getServiceLocator()->get('AdapterDb');

        $modelPrestadora = new PrestadoraTable($adapter);
        //  exit();

        $intensPorPagina = 3;
        // $pagina = $pagina;


        echo $pagina;
        //  pagesInRange;
        echo $modelPrestadora->fetchAllPaginacao($adapter, $intensPorPagina, 3)->pagesInRange;

        exit();
        //  return $this->redirect()->toRoute('prestadora');
        return $this->redirect()->toRoute('prestadora', array('prestadora' => $modelPrestadora->fetchAllPaginacao($adapter, $intensPorPagina, 3),
                    'intensPorPagina' => $intensPorPagina,
                    'pagina' => $pagina));
        // }
    }

    public function inserirVeiculoAction() {
        $request = $this->getRequest();
        $response = $this->getResponse();

        $adapter = $this->getServiceLocator()->get('AdapterDb');
        $veiculo = new Veiculo();
        $veiculoTable = new VeiculoTable($adapter);

        $prestadora = new Prestadora();
        $prestadoraTable = new PrestadoraTable($adapter);

        // echo 'a resquisição é post';
        // exit();
//        $veiculo->veiculo_placa = $_POST['veiculo_placa'];
//        $veiculo->veiculo_capacidade = $_POST['veiculo_capacidade'];
//        $veiculo->veiculo_cor = $_POST['veiculo_cor'];
//        $veiculo->veiculo_modelo = $_POST['veiculo_modelo'];
//        $veiculo->veiculo_ano = $_POST['veiculo_ano'];
//        $veiculo->veiculo_est_conserv = $_POST['veiculo_est_conserv'];
//        $veiculo->veiculo_resp_legal = $_POST['veiculo_resp_legal'];
        //  $veiculo->emp_prestadora_fk = $_POST['emp_prest_fk'];



        $postData = $request->getPost();
        $veiculo->exchangeArray($postData);
        $prestadora->exchangeArray($postData);

        // $veiculo = $_POST['veiculo'];


        if ($request->isPost()) {
            /*
             * Verifica se a empresa prestara que o veículo será vinculado já esta cadastro
             * apenas um insere um veículo
             */
            if ($prestadora->emp_prest_id != '') {
                $veiculo->emp_prestadora_fk = $prestadora->emp_prest_id;
                $prestadoraTable->atualizarPrestadora($prestadora);
                $veiculoTable->saveVeiculo($veiculo);
                $form = $veiculoTable->fetchAllVeiculoPrestadora($prestadora->emp_prest_id);
            }
            /*
             * Será cadastrado a empresa prestadora
             * o id da empresa prestadora será inserido como chame estrangeira no objeto veiculo
             */ else {
                //  echo 'Prestadora não cadastrada';
                // exit();
                $prestadoraTable->savePrestadora($prestadora);

                /* retornada os dados da prestadora inserido
                 * usuado para pegar o atributo prestadora_id do objeto prestadora inserido
                 */
                $prestadora = $prestadoraTable->findCnpj($prestadora->emp_prest_cnpj);
                /*
                 * vincula o veículo a prestadora inserida
                 */
                $veiculo->emp_prestadora_fk = $prestadora->emp_prest_id;
                /*
                 * insere o veículo 
                 */
                $veiculoTable->saveVeiculo($veiculo);

                $form = $veiculoTable->fetchAllVeiculoPrestadora($veiculo->emp_prestadora_fk);
            }
            try {

//                echo '<pre>';
//
//                foreach ($form as $value) {
//
//                    var_dump($value);
//                }
//
//                echo '</pre>';
//                exit();
//                echo'    <thead>';
//                echo'  <tr>';
//                echo'      <th>Id</th>';
//                echo'      <th>Placa</th>';
//                echo'      <th>Capacidade</th>';
//                echo'       <th>Cor</th>';
//                echo'       <th>Modelo</th>';
//                echo'       <th>Ano</th>  ';
//                echo'       <th>Estado Conservação</th>';
//                echo'       <th>Responsável Legal</th>  ';
//                echo'    </tr>';
//                echo'   </thead>';
//
//
//                foreach ($form as $value) {
//
//                    echo '     <tr>';
//                    echo '     <td>' . $value->veiculo_id . '</td>';
//                    echo '     <td>' . $value->veiculo_placa . '</td>';
//                    echo '     <td>' . $value->veiculo_capacidade . '</td>';
//                    echo '     <td>' . $value->veiculo_cor . '</td>';
//                    echo '     <td>' . $value->veiculo_modelo . '</td>';
//                    echo '     <td>' . $value->veiculo_ano . '</td>';
//                    echo '     <td>' . $value->veiculo_est_conserv . '</td>';
//                    echo '     <td>' . $value->veiculo_resp_legal . '</td>';
//
//                    //  echo '     <td>fas</td>';
//                    echo '     </tr>';
//                }
                /*
                 * variável $tabela recebe uma String com todos os veículos vinculados 
                 * a empresa prestadora
                 */
                $tabela = '<thead><tr>' .
                        '  <tr>' .
                        '      <th>Id</th>' .
                        '      <th>Placa</th>' .
                        '      <th>Capacidade</th>' .
                        '       <th>Cor</th>' .
                        '       <th>Modelo</th>' .
                        '       <th>Ano</th>  ' .
                        '       <th>Estado Conservação</th>' .
                        '       <th>Responsável Legal</th>  ' .
                        '    </tr>' .
                        '   </thead>';


                foreach ($form as $value) {
                    //concatenção em PHP
                    $tabela.= '     <tr>' .
                            '     <td>' . $value->veiculo_id . '</td>' .
                            '     <td>' . $value->veiculo_placa . '</td>' .
                            '     <td>' . $value->veiculo_capacidade . '</td>' .
                            '     <td>' . $value->veiculo_cor . '</td>' .
                            '     <td>' . $value->veiculo_modelo . '</td>' .
                            '     <td>' . $value->veiculo_ano . '</td>' .
                            '     <td>' . $value->veiculo_est_conserv . '</td>' .
                            '     <td>' . $value->veiculo_resp_legal . '</td>' .
                            '     </tr>';
                }
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }

            /*
             * array com a string $tabela e o id da empresa prestadora
             * será retornado no arquivo json
             */
            $arry = Array("tabela" => $tabela, "emp_prest_id" => $prestadora->emp_prest_id);

            //codifica para um arquivo json
            echo json_encode($arry);
        }

        //  }

        /*
         * Para usar um retorno json não pode retornar um array no retorno da $response
         */
        return $response;
        // return $response->setContent(array('grandegerador' => $grandeGerador ));
    }

    public function editarPrestadoraAction() {
             if (\Login\Service\Auth::authorize() == false) {
            return $this->redirect()->toRoute('login');
        }
        $request = $this->getRequest();
        $response = $this->getResponse();

        $adapter = $this->getServiceLocator()->get('AdapterDb');
        $veiculoTable = new VeiculoTable($adapter);
        $prestadoraTable = new PrestadoraTable($adapter);

        $postData = $request->getPost();
        $id_prestadora = $postData['id'];
        $listVeiculoPrestadora = $veiculoTable->fetchAllVeiculoPrestadora($id_prestadora);

        if ($request->isPost()) {
            try {

                $tabela = '<thead><tr>' .
                        '  <tr>' .
                        '      <th>Id</th>' .
                        '      <th>Placa</th>' .
                        '      <th>Capacidade</th>' .
                        '       <th>Cor</th>' .
                        '       <th>Modelo</th>' .
                        '       <th>Ano</th>  ' .
                        '       <th>Estado Conservação</th>' .
                        '       <th>Responsável Legal</th>  ' .
                        '    </tr>' .
                        '   </thead>';


                foreach ($listVeiculoPrestadora as $value) {
                    //concatenção em PHP
                    $tabela.= '     <tr>' .
                            '     <td>' . $value->veiculo_id . '</td>' .
                            '     <td>' . $value->veiculo_placa . '</td>' .
                            '     <td>' . $value->veiculo_capacidade . '</td>' .
                            '     <td>' . $value->veiculo_cor . '</td>' .
                            '     <td>' . $value->veiculo_modelo . '</td>' .
                            '     <td>' . $value->veiculo_ano . '</td>' .
                            '     <td>' . $value->veiculo_est_conserv . '</td>' .
                            '     <td>' . $value->veiculo_resp_legal . '</td>' .
                            '     </tr>';
                }
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }



            /*
             * array com a string $tabela e o id da empresa prestadora
             * será retornado no arquivo json
             */
            $arry = Array("prestadora" => $prestadoraTable->find($id_prestadora), "veiculo" => $tabela);

            //codifica para um arquivo json
            echo json_encode($arry);
        }

        //  }

        /*
         * Para usar um retorno json não pode retornar um array no retorno da $response
         */
        return $response;
        // return $response->setContent(array('grandegerador' => $grandeGerador ));
    }

    public function inserirPrestadoracomAjaxAction() {
        $request = $this->getRequest();
        $response = $this->getResponse();

        $adapter = $this->getServiceLocator()->get('AdapterDb');

        $prestadora = new Prestadora();
        $prestadoraTable = new PrestadoraTable($adapter);

        $postData = $request->getPost();
        $prestadora->exchangeArray($postData);
        // exit();

        if ($request->isPost()) {
            /*
             * Verifica se a empresa prestara que o veículo será vinculado já esta cadastro
             * apenas um insere um veículo
             */
            if ($prestadora->emp_prest_id != '') {

                $prestadoraTable->atualizarPrestadora($prestadora);
                // echo 'id prestadora é difente de vazio';
                // exit();
            }
            /*
             * Será cadastrado a empresa prestadora
             */ else {
                //  echo 'Prestadora não cadastrada';
                // exit();
                $prestadoraTable->savePrestadora($prestadora);
                //   echo 'id prestadora é difente de vazio';
                // exit();
            }
        }

        return $this->redirect()->toRoute('prestadora');
        // return $response->setContent(array('grandegerador' => $grandeGerador ));
    }

    public function deletarPrestadoraAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        $request = $this->getRequest();
        $adapter = $this->getServiceLocator()->get('AdapterDb');
        $prestadoraTable = new PrestadoraTable($adapter);
        echo $id;
        if (!$id) {
            // adicionar mensagem de erro
            $this->flashMessenger()->addMessage("Contato não encotrado");
        } else {
            // aqui vai a lógica para deletar o contato no banco
            // 1 - solicitar serviço para pegar o model responsável pelo delete
            // 2 - deleta contato
            // adicionar mensagem de sucesso
            $retornoExclusao = $prestadoraTable->deletePrestadora($id, $adapter);
            if ($retornoExclusao['excluiu'] == true) {
                $this->flashMessenger()->addSuccessMessage("Prestadora de ID $id deletado com sucesso");
            } else {
                $this->flashMessenger()->addMessage($retornoExclusao['mensagem']);
            }
        }
        return $this->redirect()->toRoute('prestadora');
    }

    /*
     * Botão Novo
     * Abre a tela novo prestadora
     */

    public function novoAction() {
             if (\Login\Service\Auth::authorize() == false) {
            return $this->redirect()->toRoute('login');
        }
        // obtém a requisição
        $request = $this->getRequest();

        // verifica se a requisição é do tipo post
        if ($request->isPost()) {
            // obter e armazenar valores do post
            $postData = $request->getPost()->toArray();

            $this->_helper->layout->setLayout('layout2');
            return $this->redirect()->toRoute('prestadora');
        }
    }

    /*
     * insere uma nova empresa prestadora
     */

    public function adicionarAction() {
             if (\Login\Service\Auth::authorize() == false) {
            return $this->redirect()->toRoute('login');
        }

        // obtém a requisição
        $request = $this->getRequest();

        // verifica se a requisição é do tipo post
        if ($request->isPost()) {
            // obter e armazenar valores do post
            $postData = $request->getPost()->toArray();

            // $formularioValido = get('submit')->setValue('Add');

            $formularioValido = true;

            // verifica se o formulário segue a validação proposta
            try {

                if ($formularioValido) {

                    $prestadora = new Prestadora();
                    $prestadora->exchangeArray($postData);


                    $adapter = $this->getServiceLocator()->get('AdapterDb');


                    // model ContatoTable instanciadoo
                    // alias para ContatoTable
                    // model ContatoTable instanciadoo
                    $modelPrestadora = new PrestadoraTable($adapter); // alias para ContatoTable

                    $modelPrestadora->savePrestadora($prestadora); // alias para ContatoTable
                    //   exit();


                    echo var_dump($prestadora);
                    //   exit();
                    //$this->
                    //  $prestadora->
                    // aqui vai a lógica para adicionar os dados à tabela no banco
                    // 1 - solicitar serviço para pegar o model responsável pela adição
                    // 2 - inserir dados no banco pelo model
                    // adicionar mensagem de sucesso
                    $this->flashMessenger()->addSuccessMessage("Contato criado com sucesso");

                    // redirecionar para action index no controller contatos
                    //$this->_helper->layout->setLayout('layout2');
                    return $this->redirect()->toRoute('prestadora');
                } else {
                    // adicionar mensagem de erro
                    $this->flashMessenger()->addErrorMessage("Erro ao criar contato");

                    // redirecionar para action novo no controllers contatos
                    return $this->redirect()->toRoute('prestadora', array('action' => 'novo'));
                }
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        }
    }

    public function filtrarAction() {
        echo 'metódo filtrar';
        $request = $this->getRequest();
        $response = $this->getResponse();

        $adapter = $this->getServiceLocator()->get('AdapterDb');
        $filtroPesquisa = $_POST['filtro_pesquisa'];
        $valor_ditado_pesquisa = $_POST['valor_digitado_pesquisa'];
        $data_inicial = '';
        $data_final = '';


        $prestadoraTable = new PrestadoraTable($adapter);
//        echo 'filtro<br>';
//        echo $filtroPesquisa;
//        echo 'Valor digitado pesquisa<br>';
//        echo $valor_ditado_pesquisa;
        //  exit();


        if ($request->isPost()) {
            echo 'Metódo Listaaaaaa';

            // $residuoTable->listaResidoPorTipo(2);
            //   echo "aasdf"+$residuoTable->listaResidoPorTipo(2);

            $tabela = '         <thead>' .
                    ' <tr>' .
                    '      <th>Codigo</th>' .
                    '       <th>Nome Fantasia</th>' .
                    '       <th>CNPJ</th>' .
                    '        <th>Data Cadastro</th>' .
                    '       <th>Ação</th>' .
                    '   </tr>' .
                    '   </thead>';
            foreach ($prestadoraTable->fetchAllComFiltro($adapter, $filtroPesquisa, $valor_ditado_pesquisa, $data_inicial, $data_final) as $value) {
                //foreach ($prestadoraTable->fetchAll() as $value) {

                $tabela.= ' <tr>' .
                        '<td>' . $value->emp_prest_id . '</td>' .
                        '<td>' . $value->emp_prest_nome_fantasia . '</td>' .
                        ' <td>' . $value->emp_prest_cnpj . '</td>' .
                        ' <td>' . $value->emp_prest_data_cadastro . '</td>' .
                        '<td>' .
                        '    <!-- Button trigger modal -->' .
                        '    <button id="<?php echo $prest->emp_prest_id ?>" value="' . $value->emp_prest_id . '"  class="btn btn-primary " data-toggle="modal" data-target="#myModal" onclick="editarPrestador(this)">Editar</button>' .
                        '   <a class="btn btn-primary btn-danger" title="Deletar" href="prestadora/deletarPrestadora/' . $value->emp_prest_id . '"><span class="glyphicon glyphicon-floppy-remove"></span></a>' .
                        ' </td>' .
                        ' </tr>' .
                        '</tbody>';
            }
        }
        echo $tabela;
        //   $this->flashMessenger()->addSuccessMessage("Metódodo Lista");

        return $response;
    }

}
