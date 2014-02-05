<?php

// namespace de localizacao do nosso model

namespace GrandeGerador\Model;

// import Zend\Db
use Zend\Db\Adapter\Adapter,
    Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\TableGateway,
    Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Expression;

class PendenciaTable extends AbstractTableGateway {

    protected $tableGateway;

    /**
     * Contrutor com dependencia do Adapter do Banco
     *
     * @param \Zend\Db\Adapter\Adapter $adapter
     */
    public function __construct(Adapter $adapter) {
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Pendencia());
        $this->tableGateway = new TableGateway('pendencia', $adapter, null, $resultSetPrototype);
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
        $rowset = $this->tableGateway->select(array('pendencia_id' => $id));
        $row = $rowset->current();
        echo 'find pendencia';
//        echo '<pre>';
//        var_dump($row);
//        echo '</pre>';

        if (!$row) {
            throw new \Exception("Não foi encontrado a pendência  de id = {$id}");
            exit();
        }
        return $row;
    }

    /**
     * Busca o Risiduo para coleta pela chave estrangeira do grande gerador
     * @param type $id
     * @return type
     * @throws \Exception
     */
    public function findPorFkGrandGedaor($id) {
        try {

            $id = (int) $id;
            $rowset = $this->tableGateway->select(array('grande_gerador_fk' => $id));
            $row = $rowset->current();
        } catch (Exception $exc) {
            if (!$row)
                throw new \Exception("Não foi encontrado residuo para colega com a chave estrangeira = {$id}");

            echo $exc->getTraceAsString();
        }
        return $row;
    }

    public function fetchAllPaginacao($currentPage = 1, $countPerPage = 2) {
        $select = new Select();
        $select->from($this->tableGateway)->order('produto_id');
        $adapter = $this->getServiceLocator()->get('AdapterDb');
        $paginator = new \Zend\Paginator\Paginator($adapter);
        $paginator->setItemCountPerPage($countPerPage);
        $paginator->setCurrentPageNumber($currentPage);
        return $paginator;
    }

    public function findSQL($id_grande_gerador, Adapter $adapter) {

       // $adapter = $this->getServiceLocator()->get('AdapterDb');  
        $sql = new Sql($adapter, 'pendencia');
        $select = $sql->select();
       //$select->from('pendencia');
        $select->where(array('grande_gerador_fk' => $id_grande_gerador)); // $select already has the from('foo') applied  nome_cliente like “g%”;
       // $select->where(array('grande_gerador_fk' => $id_grande_gerador, 'pendencia_descricao' => "F"));
      // $filtro = 'F';
        //$select->where("pendencia_descricao LIKE '%$for%' OR pendencia_descricao LIKE '%$for%' OR pendencia_descricao LIKE '%$for%'");
      //  $select->where("WHERE grande_gerador_fk = '$id_grande_gerador' ");
        //$select->where('pendencia_descricao LIKE  F%');
        //orderna por orden de data decrescente
        $select->order('pendencia_data DESC');
        $select->order('pendencia_id DESC');
        

        $selectString = $sql->getSqlStringForSqlObject($select);
        return $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);            

//        echo '<pre>';
//        var_dump($rowset);
//        echo '</pre>';

      //  return $rowset;
        //  return $this->tableGateway->select($sql);
        //$row = $rowset->current();
        if (!$row)
            throw new \Exception("Não foi encontrado contado de id = {$id}");
        return $row;
    }
    /**
     * Retonar a ultima pendencia enviado ao grande gerador
     * @param type $id_grande_gerador
     * @param \Zend\Db\Adapter\Adapter $adapter
     * @return type
     * @throws \Exception
     */
    public function findUltimaPendenciaGrandeGerador($id_grande_gerador, Adapter $adapter) {

       // $adapter = $this->getServiceLocator()->get('AdapterDb');  
     /*  
        $select = new Select($adapter);
        $select->from(array('pendencia'),array('pendencia_id'));
       // $select->where('condition');
        $answer=$adapter->fetchOne($select);
      * 
      * 
      * $select->from(array($table),array('max($column)'));
      * 
       */ 
        
       // $this, array(new Zend_Db_Expr('max(id)'))
        $sql = new Sql($adapter, 'pendencia');
        $select = $sql->select();
       // $select->from(array('pendencia'),array('pendencia_id'));
       //$select->from('pendencia');
          $select->where(array('grande_gerador_fk' => $id_grande_gerador));
        $select->group('grande_gerador_fk');
          $select->columns(array(new Expression('max(pendencia_id) as pendencia_id'), new Expression('max(pendencia_data) as pendencia_data'), 'grande_gerador_fk', 'pendencia_descricao')); // $select already has the from('foo') applied  nome_cliente like “g%”;
       // $select->columns(array('max(pendencia_id)')); // $select already has the from('foo') applied  nome_cliente like “g%”;
       // $select already has the from('foo') applied  nome_cliente like “g%”;
       // $select->where(array('grande_gerador_fk' => $id_grande_gerador, 'pendencia_descricao' => "F"));
      // $filtro = 'F';
        //$select->where("pendencia_descricao LIKE '%$for%' OR pendencia_descricao LIKE '%$for%' OR pendencia_descricao LIKE '%$for%'");
      //  $select->where("WHERE grande_gerador_fk = '$id_grande_gerador' ");
        //$select->where('pendencia_descricao LIKE  F%');
        //orderna por orden de data decrescente

      //  $select->order('pendencia_id DESC');
        

        $selectString = $sql->getSqlStringForSqlObject($select);
         $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);            
        
      
         $row = $results->current();
//           echo '<pre>';
//        var_dump($row['pendencia_id']);
//        echo '</pre>';
//        
        
            $id = (int) $row['pendencia_id'];
            $rowset = $this->tableGateway->select(array('pendencia_id' => $id));
            $row = $rowset->current();

        
        
        return $row;
        
      //  exit();

      //  return $rowset;
        //  return $this->tableGateway->select($sql);
        //$row = $rowset->current();
        if (!$row)
            throw new \Exception("Não foi encontrado contado de id = {$id}");

        return $row;
    }

    /**
     * Exclui o residuo para coleta PELO id
     * @param type $id
     */
    public function deleteResiduoParaColeta($id) {
        $id = (int) $id;

        try {
            $this->tableGateway->delete(array('residuo_para_coleta_id' => $id));
        } catch (Exception $e) {
            $pdoException = $e->getPrevious();
            //  var_dump($e);
            echo "<br>exceção ao deletar";
            exit;
        }
    }

//    public function save($id) {
//        $id = (int) $id;
//        $rowset = $this->tableGateway->select(array('redisuo_para_coleta_id' => $id));
//        $row = $rowset->current();
//        if (!$row)
//            throw new \Exception("Não foi encontrado contado de id = {$id}");
//
//        return $row;
//    }

    public function atualizar(Pendencia $pendencia) {
        $data = array(
            'grande_gerador_fk' => $pendencia->grande_gerador_fk,
            'pendencia_descricao' => $pendencia->pendencia_descricao,
            'pendencia_email' => $pendencia->pendencia_email,
            'pendencia_data' => $pendencia->pendencia_data,
            'pendencia_email' => $pendencia->pendencia_email,
                //'codigo' => $prestadora->codigo,
                // 'descricao' => strtoupper($prestadora->descricao)
        );
        $cod = $pendencia->pendencia_id;

        try {
            $this->tableGateway->update($data, array('pendencia_id' => $cod));
//                echo '<pre>';
//                var_dump($data);
//                echo '<pre>';
//                exit;
        } catch (Exception $e) {

            echo '<pre>';
            var_dump($e);
            echo '<pre>';
            exit;
            throw new \Exception("Grande Gerador ID# $codGerador não lozalizado no banco de dados!");
            exit;
        }
    }

    public function save(Pendencia $pendencia) {
        $data = array(
            'grande_gerador_fk' => $pendencia->grande_gerador_fk,
            'pendencia_descricao' => $pendencia->pendencia_descricao,
            'pendencia_email' => $pendencia->pendencia_email,
            'pendencia_data' => $pendencia->pendencia_data,
            'pendencia_email' => $pendencia->pendencia_email,
        );

        try {
            // $this->tableGateway->update(array('grande_gerador_id' => $grandegerador->grande_gerador_id));
            $this->tableGateway->insert($data);

            //   return 'inseriu';
//                echo '<pre>';
//                var_dump($grandegerador->grande_gerador_id);
//                echo '<pre>';
//                exit;
        } catch (Exception $e) {
            $pdoException = $e->getPrevious();
            var_dump($e);
            echo "<br>exceção ao salvar";
            //  exit;
        }
    }

}
