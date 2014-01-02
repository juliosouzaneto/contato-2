<?php

// namespace de localizacao do nosso model

namespace Contato\Model;

// import Zend\Db
use //Zend\Db\Adapter\Adapter,
   // Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\TableGateway;


class ContatoTable {

    protected $tableGateway;
    
    private function getContatoTable()
{
    return $this->getServiceLocator()->get('ModelContato');
}

 public function saveContato(Contato $contato) {
     $contato->id = 11;
        $data = array(
            'nome' => $contato->nome,
            'telefone_principal' => $contato->telefone_principal,
            'id' => $contato->id,
           // 'descricao' => strtoupper($contato->descricao)
        );
        
        echo "<br>Metodo saveContato";

     //   $codorgao = (int) $contato->codorgao;

       // if ($codorgao == 0) {
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
//        }
    }

    /**
     * Contrutor com dependencia do Adapter do Banco
     *
     * @param \Zend\Db\Adapter\Adapter $adapter
     */
//    public function __construct(Adapter $adapter) {
//        $resultSetPrototype = new ResultSet();
//        $resultSetPrototype->setArrayObjectPrototype(new Contato());
//
//        $this->tableGateway = new TableGateway('contatos', $adapter, null, $resultSetPrototype);
//    }

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    /**
     * Recuperar todos os elementos da tabela contatos
     *
     * @return ResultSet
     */
    public function fetchAll() {
         echo "<br> Entrou no metódo fetchall contatoTable";
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
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row)
            throw new \Exception("Não foi encontrado contado de id = {$id}");

        return $row;
    }
    
    
    

}
