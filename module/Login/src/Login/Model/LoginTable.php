<?php
 //$campo = $_POST['campo'];
// namespace de localizacao do nosso model

namespace Login\Model;

// import Zend\Db
use Zend\Db\Adapter\Adapter,
    Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\TableGateway,
    Zend\Db\TableGateway\AbstractTableGateway;

class LoginTable extends AbstractTableGateway {
    
   

    protected $tableGateway;

    /**
     * Contrutor com dependencia do Adapter do Banco
     *
     * @param \Zend\Db\Adapter\Adapter $adapter
     */
    public function __construct(Adapter $adapter) {
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Residuo());
        $this->tableGateway = new TableGateway('login', $adapter, null, $resultSetPrototype);
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
    public function find($user) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('login_usuario' => $user));
        $row = $rowset->current();
        if (!$row)
            throw new \Exception("Não foi encontrado contado de id = {$user}");

        return $row;
    }
    /**
     * Localizar todos os residios com tipo selecionado
     *
     * @param type $$tipo_resido_fk
     * @return \Model\Contato
     * @throws \Exception
     */
    public function listaResidoPorTipo($tipo_resido_fk) {
        $tipo_resido_fk = (int) $tipo_resido_fk;
        $listSet = $this->tableGateway->select(array('tipo_residuo_fk' => $tipo_resido_fk));
       // $row = $rowset->current();
        if (!$listSet)
            throw new \Exception("Não foi encontrado contado de id = {$tipo_resido_fk}");

        return $listSet;
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
