<?php

namespace GrandeGerador\Model;

// import Model\GrandeGerador
use GrandeGerador\Model\Pendencia,
    GrandeGerador\Model\PendenciaTable;
// import Zend\Db
use Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\TableGateway;

class Pendencia {

    public $pendencia_id;
    public $pendencia_descricao;
    public $pendencia_email;
    public $pendencia_data;
    public $grande_gerador_fk;

    public function exchangeArray($data) {

        $this->pendencia_id = (!empty($data['pendencia_id'])) ? $data['pendencia_id'] : null;
        $this->pendencia_descricao = (!empty($data['pendencia_descricao'])) ? $data['pendencia_descricao'] : null;
        $this->pendencia_email = (!empty($data['pendencia_email'])) ? $data['pendencia_email'] : null;
        $this->pendencia_data = (!empty($data['pendencia_data'])) ? $data['pendencia_data'] : null;
        $this->grande_gerador_fk = (!empty($data['grande_gerador_fk'])) ? $data['grande_gerador_fk'] : null;
        //        echo '<pre>';
//
//                var_dump($data);
//                echo '</pre>';
        // echo "<br> Entrou no construtor GrandeGerador";
    }

    public function exchangeArray2($data) {
        // echo "<br> Entrou no construtor GrandeGerador";

        $this->grande_gerador_cnpj = (!empty($data['grande_gerador_cnpj'])) ? $data['grande_gerador_cnpj'] : null;

        echo '<pre>';

        var_dump($this->grande_gerador_cnpj);
        echo '</pre>';
    }
}
