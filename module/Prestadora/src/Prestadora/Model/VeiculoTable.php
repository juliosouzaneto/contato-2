<?php

// namespace de localizacao do nosso model

namespace Prestadora\Model;

// import Zend\Db
use Zend\Db\Adapter\Adapter,
    Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\TableGateway,
    Zend\Db\TableGateway\AbstractTableGateway;
use Prestadora\Model\Veiculo;

class VeiculoTable extends AbstractTableGateway {

    protected $tableGateway;

    /**
     * Contrutor com dependencia do Adapter do Banco
     *
     * @param \Zend\Db\Adapter\Adapter $adapter
     */
    public function __construct(Adapter $adapter) {
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Veiculo());
        $this->tableGateway = new TableGateway('veiculo', $adapter, null, $resultSetPrototype);
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
     * @return \Model\Contato
     * @throws \Exception
     */
    public function find($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('veiculo_id' => $id));
        $row = $rowset->current();
        if (!$row)
            throw new \Exception("Não foi encontrado contado de id = {$id}");

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
        $rowset = $this->tableGateway->select(array('veiculo_id' => $id));
        $row = $rowset->current();
        if (!$row)
            throw new \Exception("Não foi encontrado contado de id = {$id}");

        return $row;
    }

    public function saveVeiculo(Veiculo $veiculo) {
        // echo '<pre>';
        //  var_dump($veiculo);
        //   echo '</pre>';
        // exit();
        $data = array(
            //'veiculo_id' => $veiculo->veiculo_id,
            'veiculo_placa' => $veiculo->veiculo_placa,
            'veiculo_capacidade' => (int) $veiculo->veiculo_capacidade,
            'veiculo_cor' => (int) $veiculo->veiculo_cor,
            'veiculo_modelo' => $veiculo->veiculo_modelo,
            'veiculo_ano' => $veiculo->veiculo_ano,
            'veiculo_est_conserv' => $veiculo->veiculo_est_conserv,
            'veiculo_resp_legal' => $veiculo->veiculo_resp_legal,
            'emp_prestadora_fk' => $veiculo->emp_prestadora_fk,
                // 'descricao' => strtoupper($prestadora->descricao)
        );


        //$codPrestadora = (int) $prestadora->emp_prest_id;


        try {
            $this->tableGateway->insert($data);
        } catch (Exception $e) {
            throw new \Exception("Erro ao salvar o veículo");
            $pdoException = $e->getPrevious();
            //var_dump($e);
            //exit;
        }
    }
    
     public function fetchAllVeiculoPrestadora($fk_prestadora) {
       //  echo $fk_prestadora;
       //  exit();
        $fk_prestadora = (int) $fk_prestadora;
//        echo '<pre>';
//            
//            var_dump($fk_prestadora);
//            echo '</pre>';
        return $rowset = $this->tableGateway->select(array('emp_prestadora_fk' => $fk_prestadora));
       
          //  return $this->tableGateway->select();
//            $rowset = $this->tableGateway->select();
//
//         echo '<pre>';
//            
//            var_dump($rowset);
//            echo '</pre>';
//
//        return $rowset;
//        if (!$row) {
//            // throw new \Exception("Não foi encontrado grande gerador com o cnpj = {$cnpj}");
//        }
//
//        return $row;
    }
    
    public function deletarVeiculo($id)
    {
         $id = (int) $id;

        try {
            $this->tableGateway->delete(array('veiculo_id' => $id));
        } catch (Exception $e) {
            $pdoException = $e->getPrevious();
            //  var_dump($e);
            echo "<br>exceção ao excluir prestadora";
            exit;
        }
    }

    /*  public function fetchAllVeiculoPrestadora(Adapter $adapter, $filtro, $like, $data_inicial, $data_final) {

        // $adapter = $this->getServiceLocator()->get('AdapterDb');  

        try {
            $sql = new Sql($adapter);
            $select = $sql->select();
            $select->from('veiculo');


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
      
            if ($filtro == 'grande_gerador_nome_fantasia') {
                $select->where("grande_gerador_nome_fantasia LIKE '%$like%'");
                //  $select->where('grande_gerador_nome_fantasia LIKE  %6%');
                $select->order('grande_gerador_data_cadastro ASC');
                // $select->where("'$filtro' LIKE '%6%' ");
            }



            $selectString = $sql->getSqlStringForSqlObject($select);
            return $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
        } catch (Exception $exc) {
            throw new \Exception("Não foi encontrado contado de id = {$id}");
            echo $exc->getTraceAsString();
        }
    }*/

}
