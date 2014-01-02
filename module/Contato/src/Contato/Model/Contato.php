<?php

namespace Contato\Model;

// import Model\Contato
use Contato\Model\Contato,
    Contato\Model\ContatoTable;
 
// import Zend\Db
use Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\TableGateway;


class Contato {

    public $id;
    public $nome;
    public $telefone_principal;
    public $telefone_secundario;
    public $data_criacao;
    public $data_atualizacao;

    public function exchangeArray($data) {
         echo "<br> Entrou no construtor contato";
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->nome = (!empty($data['nome'])) ? $data['nome'] : null;
        $this->telefone_principal = (!empty($data['telefone_principal'])) ? $data['telefone_principal'] : null;
        $this->telefone_secundario = (!empty($data['telefone_secundario'])) ? $data['telefone_secundario'] : null;
        $this->data_criacao = (!empty($data['data_criacao'])) ? $data['data_criacao'] : null;
        $this->data_atualizacao = (!empty($data['data_atualizacao'])) ? $data['data_atualizacao'] : null;
    }

  

}
