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
        $resultSetPrototype->setArrayObjectPrototype(new ResiduoParaColeta());
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
        $rowset = $this->tableGateway->select(array('residuo_para_coleta_id' => $id));
        $row = $rowset->current();
        if (!$row)
            throw new \Exception("Não foi encontrado contado de id = {$id}");

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

    public function atualizar(ResiduoParaColeta $residuoColeta) {
        $data = array(
            'grande_gerador_fk' => $residuoColeta->grande_gerador_fk,
            'residuo_para_coleta_umido_desc' => $residuoColeta->residuo_para_coleta_umido_desc,
            'residuo_para_coleta_umido_qtd_gerada' => $residuoColeta->residuo_para_coleta_umido_qtd_gerada,
            'residuo_para_coleta_umido_peso' => $residuoColeta->residuo_para_coleta_umido_peso,
            'residuo_para_coleta_umido_tipo_acodic' => $residuoColeta->residuo_para_coleta_umido_tipo_acodic,
            'residuo_para_coleta_umido_nome_cooperativa' => $residuoColeta->residuo_para_coleta_umido_nome_cooperativa,
            'residuo_para_coleta_umido_local_destinacao' => $residuoColeta->residuo_para_coleta_umido_local_destinacao,
            'residuo_para_coleta_solido_desc' => $residuoColeta->residuo_para_coleta_solido_desc,
            'residuo_para_coleta_solido_qtd_gerada' => $residuoColeta->residuo_para_coleta_solido_qtd_gerada,
            'residuo_para_coleta_solido_peso' => $residuoColeta->residuo_para_coleta_solido_peso,
            'residuo_para_coleta_solido_tipo_acodic' => $residuoColeta->residuo_para_coleta_solido_tipo_acodic,
            'residuo_para_coleta_solido_nome_cooperativa' => $residuoColeta->residuo_para_coleta_solido_nome_cooperativa,
            'residuo_para_coleta_solido_local_destinacao' => $residuoColeta->residuo_para_coleta_solido_local_destinacao,
                //'codigo' => $prestadora->codigo,
                // 'descricao' => strtoupper($prestadora->descricao)
        );
        $cod = $residuoColeta->residuo_para_coleta_id;

            try {
                  $this->tableGateway->update($data, array('residuo_para_coleta_id' => $cod));
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
    public function save(ResiduoParaColeta $residuoColeta) {
        $data = array(
            'grande_gerador_fk' => $residuoColeta->grande_gerador_fk,
            'residuo_para_coleta_umido_desc' => $residuoColeta->residuo_para_coleta_umido_desc,
            'residuo_para_coleta_umido_qtd_gerada' => $residuoColeta->residuo_para_coleta_umido_qtd_gerada,
            'residuo_para_coleta_umido_peso' => $residuoColeta->residuo_para_coleta_umido_peso,
            'residuo_para_coleta_umido_tipo_acodic' => $residuoColeta->residuo_para_coleta_umido_tipo_acodic,
            'residuo_para_coleta_umido_nome_cooperativa' => $residuoColeta->residuo_para_coleta_umido_nome_cooperativa,
            'residuo_para_coleta_umido_local_destinacao' => $residuoColeta->residuo_para_coleta_umido_local_destinacao,
            'residuo_para_coleta_solido_desc' => $residuoColeta->residuo_para_coleta_solido_desc,
            'residuo_para_coleta_solido_qtd_gerada' => $residuoColeta->residuo_para_coleta_solido_qtd_gerada,
            'residuo_para_coleta_solido_peso' => $residuoColeta->residuo_para_coleta_solido_peso,
            'residuo_para_coleta_solido_tipo_acodic' => $residuoColeta->residuo_para_coleta_solido_tipo_acodic,
            'residuo_para_coleta_solido_nome_cooperativa' => $residuoColeta->residuo_para_coleta_solido_nome_cooperativa,
            'residuo_para_coleta_solido_local_destinacao' => $residuoColeta->residuo_para_coleta_solido_local_destinacao,
                //'codigo' => $prestadora->codigo,
                // 'descricao' => strtoupper($prestadora->descricao)
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
