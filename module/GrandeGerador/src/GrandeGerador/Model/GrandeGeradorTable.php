<?php

// namespace de localizacao do nosso model

namespace GrandeGerador\Model;

// import Zend\Db
//Zend\Db\Adapter\Adapter,
use Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\TableGateway;

class GrandeGeradorTable {

    protected $tableGateway;

    private function getGrandeGeradorTable() {
        return $this->getServiceLocator()->get('ModelGrandeGerador');
    }

    public function saveGrandeGerador(GrandeGerador $grandegerador) {
        // $grandegerador->grande_gerador_id= 13;
        //$grandegerador->emp_prestadora_fk = 6;
        echo '<br>código emp_prestadora_fk ';
        print_r($grandegerador->emp_prestadora_fk);
        echo '<br>código grande gerador ';
        print_r($grandegerador);
        // print_r($grandegerador->grande_gerador_razao_social);
        $data = array(
            'grande_gerador_razao_social' => $grandegerador->grande_gerador_razao_social,
            'grande_gerador_cnpj' => $grandegerador->grande_gerador_cnpj,
            'grande_gerador_endereco' => $grandegerador->grande_gerador_endereco,
            'grande_gerador_rua' => $grandegerador->grande_gerador_rua,
            'grande_gerador_cep' => $grandegerador->grande_gerador_cep,
            'grande_gerador_telefone' => $grandegerador->grande_gerador_telefone,
            'grande_gerador_email' => $grandegerador->grande_gerador_email,
            'grande_gerador_resp_legal' => $grandegerador->grande_gerador_resp_legal,
            'grande_gerador_nome_fantasia' => $grandegerador->grande_gerador_nome_fantasia,
            'grande_gerador_situacao' => $grandegerador->grande_gerador_situacao,
            'emp_prestadora_fk' => $grandegerador->emp_prestadora_fk,
                // 'descricao' => strtoupper($grandegerador->descricao)
        );


//        echo '<pre>';
//        var_dump($data);
//        echo '<pre>';
//        exit();

        echo "<br>Metodo saveGrandeGerador";
        try {
            // $this->tableGateway->update(array('grande_gerador_id' => $grandegerador->grande_gerador_id));
            $this->tableGateway->insert($data);
        } catch (Exception $e) {
            $pdoException = $e->getPrevious();
            var_dump($e);
            echo "<br>exceção ao salvar";
            //  exit;
        }
    }

    public function atualizarGrandeGerador(GrandeGerador $grandegerador) {

        echo '<br>código emp_prestadora_fk ';
        print_r($grandegerador->emp_prestadora_fk);
        echo '<br>código grande gerador ';
        print_r($grandegerador);
        // print_r($grandegerador->grande_gerador_razao_social);
        $data = array(
            'grande_gerador_razao_social' => $grandegerador->grande_gerador_razao_social,
            'grande_gerador_cnpj' => $grandegerador->grande_gerador_cnpj,
            'grande_gerador_endereco' => $grandegerador->grande_gerador_endereco,
            'grande_gerador_rua' => $grandegerador->grande_gerador_rua,
            'grande_gerador_cep' => $grandegerador->grande_gerador_cep,
            'grande_gerador_telefone' => $grandegerador->grande_gerador_telefone,
            'grande_gerador_email' => $grandegerador->grande_gerador_email,
            'grande_gerador_resp_legal' => $grandegerador->grande_gerador_resp_legal,
            'grande_gerador_nome_fantasia' => $grandegerador->grande_gerador_nome_fantasia,
            'grande_gerador_situacao' => $grandegerador->grande_gerador_situacao,
            'emp_prestadora_fk' => $grandegerador->emp_prestadora_fk,
                // 'descricao' => strtoupper($grandegerador->descricao)
        );
        echo "<br>Metodo atualizar grande gerador";

        $codGerador = $grandegerador->grande_gerador_id;
        //  exit;
        try {
            $this->tableGateway->update($data, array('grande_gerador_id' => $codGerador));
        } catch (Exception $e) {
            echo '<pre>';
            var_dump($e);
            echo '<pre>';
            exit;
            throw new \Exception("Grande Gerador ID# $codGerador não lozalizado no banco de dados!");
            exit;
        }
    }

    public function validaCamposGrandeGerador(GrandeGerador $grandegerador) {
        if ($grandegerador->emp_prestadora_fk == 0) {
            $this->flashMessenger()->addSuccessMessage("GrandeGerador de ID $id deletado com sucesso");
            return false;
        }

        return true;
    }

    /**
     * Contrutor com dependencia do Adapter do Banco
     *
     * @param \Zend\Db\Adapter\Adapter $adapter
     */
//    public function __construct(Adapter $adapter) {
//        $resultSetPrototype = new ResultSet();
//        $resultSetPrototype->setArrayObjectPrototype(new GrandeGerador());
//
//        $this->tableGateway = new TableGateway('grandegerador', $adapter, null, $resultSetPrototype);
//    }

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    /**
     * Recuperar todos os elementos da tabela GrandeGerador
     *
     * @return ResultSet
     */
    public function fetchAll() {
      //  echo "<br> Entrou no metódo fetchall GrandeGeradorTable";
        return $this->tableGateway->select();
    }

    /**
     * Recuperar todos os elementos da tabela Empresa Prestadora
     *
     * @return ResultSet
     */
    public function empresaPrestadorafetchAll() {
        echo "<br> Entrou no metódo fetchall GrandeGeradorTable";
        return $this->tableGateway->select();
    }

    /**
     * Localizar linha especifico pelo id da tabela GrandeGerador
     *
     * @param type $id
     * @return \Model\GrandeGeradoResiduoows \Exception
     */
    public function find($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('grande_gerador_id' => $id));
        $row = $rowset->current();
        if (!$row)
            throw new \Exception("Não foi encontrado contado de id = {$id}");

        return $row;
    }

    public function findCnpj($cnpj) {
        $cnpj = (string) $cnpj;
        $rowset = $this->tableGateway->select(array('grande_gerador_cnpj' => $cnpj));

//         echo '<pre>';
//            
//            var_dump($rowset);
//            echo '</pre>';

        $row = $rowset->current();
        if (!$row) {
            // throw new \Exception("Não foi encontrado grande gerador com o cnpj = {$cnpj}");
        }

        return $row;
    }

    public function deleteGrandeGerador($id) {
        $id = (int) $id;

        try {
            $this->tableGateway->delete(array('grande_gerador_id' => $id));
        } catch (Exception $e) {
            $pdoException = $e->getPrevious();
            //  var_dump($e);
            echo "<br>exceção ao salvar";
            exit;
        }
    }

}
