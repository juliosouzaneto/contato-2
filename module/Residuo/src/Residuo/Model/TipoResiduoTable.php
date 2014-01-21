<?php

// namespace de localizacao do nosso model

namespace Residuo\Model;

// import Zend\Db
use  Zend\Db\Adapter\Adapter,
    Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\TableGateway,
    Zend\Db\TableGateway\AbstractTableGateway;


class TipoResiduoTable extends AbstractTableGateway {

    protected $tableGateway;
    
//    private function getTipoResiduoTableTable()
//{
//    return $this->getServiceLocator()->get('ModelResiduo');
//}

 public function saveGrandeGerador(GrandeGerador $grandegerador) {
    // $grandegerador->grande_gerador_id= 13;
     //$grandegerador->emp_prestadora_fk = 6;
     echo '<br>código emp_prestadora_fk ';
     //echo $grandegerador->emp_prestadora_fk;
     
     
     
     print_r( $grandegerador->emp_prestadora_fk);
     print_r( $grandegerador->grande_gerador_razao_social);
    
        $data = array(
            'grande_gerador_razao_social' => $grandegerador->grande_gerador_razao_social,
            'grande_gerador_nome_fantasia' => $grandegerador->grande_gerador_nome_fantasia,
            'grande_gerador_cnpj' => $grandegerador->grande_gerador_cnpj,
            'emp_prestadora_fk' => $grandegerador->emp_prestadora_fk,
            'grande_gerador_endereco' => $grandegerador->grande_gerador_endereco,
            'grande_gerador_cep' => $grandegerador->grande_gerador_cep,
           // 'descricao' => strtoupper($grandegerador->descricao)
        );
        
        echo "<br>Metodo saveGrandeGerador";

     //   $codorgao = (int) $grandegerador>codorgao;

       // if ($grandegerador->emp_prestadora_fk == -1) {
            try {
                          $this->tableGateway->insert($data);
            } catch (Exception $e) {
                         $pdoException = $e->getPrevious();
                  var_dump($e);
                echo "<br>exceção ao salvar";
                exit;
            }
//        } else {
//            if ($this->getOrgao($codorgao)) {
//                $this->update($data, array('codorgao' => $codorgao));
//            } else {
//                throw new \Exception("Orgao ID# $codorgao não lozalizado no banco de dados!");
//            }
    //    }
    }
    
    public  function  validaCamposGrandeGerador(GrandeGerador $grandegerador)
    {
        if($grandegerador->emp_prestadora_fk == 0)
        {
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
    public function __construct(Adapter $adapter) {
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new TipoResiduo());

        $this->tableGateway = new TableGateway('tipo_residuo', $adapter, null, $resultSetPrototype);
    }
    

//    public function __construct(TableGateway $tableGateway) {
//        $this->tableGateway = $tableGateway;
//    }

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
     * @return \Model\GrandeGerador
     * @throws \Exception
     */
    public function find($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('grande_gerador_id' => $id));
        $row = $rowset->current();
        if (!$row)
            throw new \Exception("Não foi encontrado contado de id = {$id}");

        return $row;
    }
    public function deleteGrandeGerador($id) {
        $id = (int) $id;
         
        try {
                      $this->tableGateway->delete(array('grande_gerador_id' => $id));
        } catch (Exception $e) {
                     $pdoException = $e->getPrevious();
              var_dump($e);
            echo "<br>exceção ao salvar";
            exit;
        }
    }
    
    
    

}
