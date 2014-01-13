<?php

// namespace de localizacao do nosso model

namespace GrandeGerador\Model;

// import Zend\Db
use Zend\Db\Adapter\Adapter,
    Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\TableGateway,
    Zend\Db\TableGateway\AbstractTableGateway;

class ResiduoParaColetaTable extends AbstractTableGateway {

    protected $tableGateway;

    /**
     * Contrutor com dependencia do Adapter do Banco
     *
     * @param \Zend\Db\Adapter\Adapter $adapter
     */
    public function __construct(Adapter $adapter) {
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new GrandeGerador());
        $this->tableGateway = new TableGateway('residuo_para_coleta', $adapter, null, $resultSetPrototype);
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
        $rowset = $this->tableGateway->select(array('redisuo_para_coleta_id' => $id));
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
        $rowset = $this->tableGateway->select(array('redisuo_para_coleta_id' => $id));
        $row = $rowset->current();
        if (!$row)
            throw new \Exception("Não foi encontrado contado de id = {$id}");

        return $row;
    }

    public function savePrestadora(ResiduoParaColeta $prestadora) {
        $data = array(
            'residuo_para_coleta_umido_desc' => $prestadora->residuo_para_coleta_umido_desc,
            'residuo_para_coleta_umido_qtd_gerada' => $prestadora->residuo_para_coleta_umido_qtd_gerada,
            'residuo_para_coleta_umido_peso' => $prestadora->residuo_para_coleta_umido_peso,
            'residuo_para_coleta_umido_tipo_acodic' => $prestadora->residuo_para_coleta_umido_tipo_acodic,
            'residuo_para_coleta_umido_nome_cooperativa' => $prestadora->residuo_para_coleta_umido_nome_cooperativa,
            'residuo_para_coleta_seco_desc' => $prestadora->residuo_para_coleta_seco_desc,
            'residuo_para_coleta_seco_qtd_gerada' => $prestadora->residuo_para_coleta_seco_qtd_gerada,
            'residuo_para_coleta_seco_peso' => $prestadora->residuo_para_coleta_seco_peso,
            'residuo_para_coleta_seco_tipo_acodic' => $prestadora->residuo_para_coleta_seco_tipo_acodic,
            'residuo_para_coleta_seco_nome_cooperativa' => $prestadora->residuo_para_coleta_seco_nome_cooperativa,
            'residuo_para_coleta_seco_local_destinacao' => $prestadora->residuo_para_coleta_seco_local_destinacao,
                //'codigo' => $prestadora->codigo,
                // 'descricao' => strtoupper($prestadora->descricao)
        );

        $codPrestadora = (int) $prestadora->residuo_para_coleta_id;

        // if ($codPrestadora == 0) {
        try {
            $this->insert($data);
        } catch (Exception $e) {
            $pdoException = $e->getPrevious();
            var_dump($e);
            exit;
        }
//        } else {
//            if ($this->getOrgao($codPrestadora)) {
//                $this->update($data, array('residuo_para_coleta_id' => $codPrestadora));
//            } else {
//                throw new \Exception("Orgao ID# $codPrestadora não lozalizado no banco de dados!");
//            }
//        }
    }

}
