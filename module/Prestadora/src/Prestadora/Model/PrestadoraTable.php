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
        } catch (Exception $e) {
            $pdoException = $e->getPrevious();
            //  var_dump($e);
            echo "<br>exceção ao excluir prestadora";
            exit;
        }
    }

}
