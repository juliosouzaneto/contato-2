<?php

// namespace de localizacao do nosso model

namespace Residuo\Model;

// import Zend\Db
use Zend\Db\Adapter\Adapter,
    Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\TableGateway,
    Zend\Db\TableGateway\AbstractTableGateway;

class ResiduoTable extends AbstractTableGateway {

    protected $tableGateway;

    /**
     * Contrutor com dependencia do Adapter do Banco
     *
     * @param \Zend\Db\Adapter\Adapter $adapter
     */
    public function __construct(Adapter $adapter) {
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Residuo());
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
     * @return \Model\Contato
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
            'emp_prest_insc_estadual' => $prestadora->emp_prest_insc_estadual
            //'codigo' => $prestadora->codigo,
           // 'descricao' => strtoupper($prestadora->descricao)
        );

        $codPrestadora = (int) $prestadora->emp_prest_id;

        if ($codPrestadora == 0) {
            try {
                $this->insert($data);
            } catch (Exception $e) {
                $pdoException = $e->getPrevious();
                var_dump($e);
                exit;
            }
        } else {
            if ($this->getOrgao($codPrestadora)) {
                $this->update($data, array('emp_prest_id' => $codPrestadora));
            } else {
                throw new \Exception("Orgao ID# $codPrestadora não lozalizado no banco de dados!");
            }
        }
    }

}
