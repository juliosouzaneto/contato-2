<?php

// namespace de localizacao do nosso model

namespace Prestadora\Model;

// import Zend\Db
use Zend\Db\Adapter\Adapter,
    Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\TableGateway,
    Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Expression;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class PrestadoraTable extends AbstractTableGateway {

    protected $tableGateway;

    /**
     * Contrutor com dependencia do Adapter do Banco
     *
     * @param \Zend\Db\Adapter\Adapter $adapter
     */
    public function __construct(Adapter $adapter) {
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Prestadora());
        $this->tableGateway = new TableGateway('emp_prestadora', $adapter, null, $resultSetPrototype);
    }

    /**
     * Recuperar todos os elementos da tabela contatos
     *
     * @return ResultSet
     */
    public function fetchAll() {
        return $this->tableGateway->select();
    }

    /**
     * Localizar linha especifico pelo id da tabela contatos
     *
     * @param type $id
     * @return 
     * @throws \Exception
     */
    public function find($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('emp_prest_id' => $id));
        $row = $rowset->current();
        if (!$row)
            throw new \Exception("Não foi encontrado contado de id = {$id}");

        return $row;
    }

    public function findCnpj($cnpj) {
        $cnpj = $cnpj;
        $rowset = $this->tableGateway->select(array('emp_prest_cnpj' => $cnpj));
        $row = $rowset->current();
        if (!$row)
            throw new \Exception("Não foi encontrado contado de id = {$cnpj}");

        return $row;
    }

    public function findSQL($sql) {
//        $id = (int) $id;
//       // $sql = (Select) $sql;
//       
//         $this->tableGateway->select
//        //$row = $rowset->current();
//        if (!$row)
//            throw new \Exception("Não foi encontrado contado de id = {$id}");
//
//        return $row;
    }

    public function save($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('emp_prest_id' => $id));
        $row = $rowset->current();
        if (!$row)
            throw new \Exception("Não foi encontrado contado de id = {$id}");

        return $row;
    }

    public function savePrestadora(Prestadora $prestadora) {
        $data = array(
            'emp_prest_cnpj' => $prestadora->emp_prest_cnpj,
            'emp_prest_insc_estadual' => $prestadora->emp_prest_insc_estadual,
            'emp_prest_email' => $prestadora->emp_prest_email,
            'emp_prest_telefone_fixo' => $prestadora->emp_prest_telefone,
            'emp_prest_celular' => $prestadora->emp_prest_celular,
            'emp_prest_data_cadastro' => $prestadora->emp_prest_data_cadastro,
            'emp_prest_resp_legal' => $prestadora->emp_prest_resp_legal,
            'emp_prest_resp_legal_rg' => $prestadora->emp_prest_resp_legal_rg,
            'emp_prest_resp_legal_emissor_rg' => $prestadora->emp_prest_resp_legal_emissor_rg,
            'emp_prest_resp_legal_uf_orgao_emissor_rg' => $prestadora->emp_prest_resp_legal_uf_orgao_emissor,
            'emp_prest_nome_fantasia' => $prestadora->emp_prest_nome_fantasia,
                // 'descricao' => strtoupper($prestadora->descricao)
        );


        //$codPrestadora = (int) $prestadora->emp_prest_id;


        try {
            $this->tableGateway->insert($data);
        } catch (Exception $e) {
            $pdoException = $e->getPrevious();
            var_dump($e);
            exit;
        }
    }

    public function atualizarPrestadora(Prestadora $prestadora) {
        $data = array(
            'emp_prest_cnpj' => $prestadora->emp_prest_cnpj,
            'emp_prest_insc_estadual' => $prestadora->emp_prest_insc_estadual,
            'emp_prest_email' => $prestadora->emp_prest_email,
            'emp_prest_telefone_fixo' => $prestadora->emp_prest_telefone,
            'emp_prest_celular' => $prestadora->emp_prest_celular,
            'emp_prest_data_cadastro' => $prestadora->emp_prest_data_cadastro,
            'emp_prest_resp_legal' => $prestadora->emp_prest_resp_legal,
            'emp_prest_resp_legal_rg' => $prestadora->emp_prest_resp_legal_rg,
            'emp_prest_resp_legal_emissor_rg' => $prestadora->emp_prest_resp_legal_emissor_rg,
            'emp_prest_resp_legal_uf_orgao_emissor_rg' => $prestadora->emp_prest_resp_legal_uf_orgao_emissor,
            'emp_prest_nome_fantasia' => $prestadora->emp_prest_nome_fantasia,
                // 'descricao' => strtoupper($prestadora->descricao)
        );


        $codPrestadora = (int) $prestadora->emp_prest_id;


        try {
            $this->tableGateway->update($data, array('emp_prest_id' => $codPrestadora));
        } catch (Exception $e) {
            $pdoException = $e->getPrevious();
            var_dump($e);
            exit;
        }
    }

    public function deletePrestadora($id, $adapter) {
        $id = (int) $id;
        $arryMensagem;

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new \GrandeGerador\Model\GrandeGerador());
        $tableGatewayPrestadora = new TableGateway('grande_gerador', $adapter, null, $resultSetPrototype);

        $grandeGeradorTable = new \GrandeGerador\Model\GrandeGeradorTable($tableGatewayPrestadora);
        $listaGrandeGeradores = $grandeGeradorTable->fetchAllGrandeGeradorPrestadora($id);

//        var_dump(count($listaGrandeGeradores,0));
//        exit();

        /*
         * Efetua a exclução da empresa prestadora se não existir nenhum grande gerador vinculado a empresa prestadora selecionad
         */
        if (count($listaGrandeGeradores, 0) == 0) {//
            echo '<pre>';
            foreach ($listaGrandeGeradores as $key) {
                echo var_dump($key);
            }

            echo '<pre>';
            // exit();
            // $adapter = $this->getServiceLocator()->get('AdapterDb');
            $veiculoTable = new \Prestadora\Model\VeiculoTable($adapter);
            $listVeiculos = $veiculoTable->fetchAllVeiculoPrestadora($id);
            if (!empty($listVeiculos)) {
                foreach ($listVeiculos as $veiculo) {
                    $veiculoTable->deletarVeiculo($veiculo->veiculo_id);
                }
            }

            try {
                $this->tableGateway->delete(array('emp_prest_id' => $id));
                $arryMensagem = Array("mensagem" => 'Grande Gerador Excluido Com Sucesso', "excluiu" => true);
            } catch (Exception $e) {
                $pdoException = $e->getPrevious();
                //  var_dump($e);
                echo "<br>exceção ao excluir prestadora";
                exit;
            }
        } else {
            $arryMensagem = Array("mensagem" => 'Esta Empresa Prestadora não Pode Ser Excluída. <br>Existe um Grande Gerador Vinculado a Ela', "excluiu" => false);
        }
        return $arryMensagem;
    }

    public function fetchAllPaginacao($adapter, $itensPorPagina, $pagina) {
        //$select = new Select();
        //$select->from($this->tableGateway)->order('emp_prest_id');


        $sql = new Sql($adapter);
        $select = $sql->select();
        $select->from('emp_prestadora');
        $select->order('emp_prest_id ASC');


        $adapter = new DbSelect($select, $adapter);
        $paginator = new Paginator($adapter);
        
        $paginator->setItemCountPerPage($itensPorPagina);
        $paginator->setCurrentPageNumber($pagina);
        
       // echo '<pre>';
       // echo var_dump($paginator->count());
       // echo '</pre>';
       
      //  exit();
        return $paginator;
    }

    public function fetchAllComFiltro(Adapter $adapter, $filtro, $like, $data_inicial, $data_final) {

        // $adapter = $this->getServiceLocator()->get('AdapterDb');  

        try {
            $sql = new Sql($adapter);
            $select = $sql->select();
            $select->from('emp_prestadora');

            if ($filtro == 'veiculo_placa') {
                $select_veiculo = $sql->select();
                $select_veiculo->from('veiculo');
                $select_veiculo->where("$filtro LIKE '%$like%'");


                $selectString2 = $sql->getSqlStringForSqlObject($select_veiculo);
                $results2 = $adapter->query($selectString2, $adapter::QUERY_MODE_EXECUTE);

                // $select->where("pendencia_descricao LIKE '%$for%' OR pendencia_descricao LIKE '%$for%' OR pendencia_descricao LIKE '%$for%'");
                if (count($results2, 0) > 0) {//
                    // if (!empty($results2)) {
                    $where = '';
                    foreach ($results2 as $veiculo) {
                        $where.= ' emp_prest_id = ' . $veiculo->emp_prestadora_fk . ' OR ';
                    }

                    $rest = substr($where, 0, -3);  // retira os 3 ultimos carecteres da string, usado pq a variavel $where terminava com OR e gerava erro
                } else {
                    $rest = ' emp_prest_id = -1 ';
                }


                $select->from('emp_prestadora');
                $select->where($rest);
                $selectString = $sql->getSqlStringForSqlObject($select);
//                
//                        echo '<pre>';
//                echo var_dump($selectString);
//                echo '/<pre>';
                // exit();

                return $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
            }
            //$like = '6';
            //$select->where(array('id' => 2)); // $select already has the from('foo') applied  nome_cliente like “g%”;
            // $select->where(array('grande_gerador_fk' => $id_grande_gerador, 'pendencia_descricao' => "F"));
            //  $filtro = 'F';
            //$select->where("pendencia_descricao LIKE '%$for%' OR pendencia_descricao LIKE '%$for%' OR pendencia_descricao LIKE '%$for%'");
            //$select->where('pendencia_descricao LIKE  F%');
            //orderna por orden de data decrescente
            // $select->order('grande_gerador_data_cadastro DES');
            //  $select->where("grande_gerador_situacao LIKE '$filtro%' "
//                    . "OR grande_gerador_situacao LIKE '$analisando%' "
//                    . "OR grande_gerador_situacao LIKE '$pendente%' "
//                    . "OR grande_gerador_situacao LIKE '$deferido%' "
//                    . " OR grande_gerador_situacao LIKE '$concluido%'");
            //$select->order('grande_gerador_situacao ASC');
            /**
             * Filtra por nome fantasia
             */
            $select->where("$filtro LIKE '%$like%'");
            //  $select->where('grande_gerador_nome_fantasia LIKE  %6%');
            $select->order('emp_prest_data_cadastro ASC');
            // $select->where("'$filtro' LIKE '%6%' ");


            /*
             * Filtra por situação
             */

            /**
             * Filtra por data do cadastro
             */
//            if ($filtro == 'grande_gerador_data_cadastro') {
//
////                echo 'Filtro por data do cadastro';
////                exit();
//                $select->where("grande_gerador_data_cadastro BETWEEN '$data_inicial' AND '$data_final' ");
//                //  $select->where('grande_gerador_nome_fantasia LIKE  %6%');
//                $select->order('grande_gerador_data_cadastro ASC');
//                // $select->where("'$filtro' LIKE '%6%' ");
//            }
//            else
//            {
//                         $select->where("grande_gerador_data_cadastro BETWEEN '$data_inicial' AND '$data_final' ");  
//           //  $select->where('grande_gerador_nome_fantasia LIKE  %6%');
//             $select->order('grande_gerador_data_cadastro ASC');
//                
//            }
            //$select->order('grande_gerador_data_cadastro ASC');
            // $select->order('grande_gerador_nome_fantasia ASC');

            $selectString = $sql->getSqlStringForSqlObject($select);
            return $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
        } catch (Exception $exc) {
            throw new \Exception("Não foi encontrado contado de id = {$id}");
            echo $exc->getTraceAsString();
        }

        if (!$row)
            throw new \Exception("Não foi encontrado contado de id = {$id}");

        return $row;
    }

}
