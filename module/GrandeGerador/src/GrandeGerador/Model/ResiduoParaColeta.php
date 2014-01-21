<?php

namespace GrandeGerador\Model;

// import Model\GrandeGerador
use GrandeGerador\Model\GrandeGerador,
    GrandeGerador\Model\GrandeGeradorTable;
// import Zend\Db
use Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\TableGateway;

class ResiduoParaColeta {

    public $residuo_para_coleta_id;
    public $residuo_para_coleta_umido_desc;
    public $residuo_para_coleta_umido_qtd_gerada;
    public $residuo_para_coleta_umido_peso;
    public $residuo_para_coleta_umido_tipo_acodic;
    public $residuo_para_coleta_umido_nome_cooperativa;
    public $residuo_para_coleta_umido_local_destinacao;
    public $residuo_para_coleta_solido_desc;
    public $residuo_para_coleta_solido_qtd_gerada;
    public $residuo_para_coleta_solido_peso;
    public $residuo_para_coleta_solido_tipo_acodic;
    public $residuo_para_coleta_solido_nome_cooperativa;
    public $residuo_para_coleta_solido_local_destinacao;
    public $grande_gerador_fk;

    public function exchangeArray($data) {

        $this->residuo_para_coleta_id = (!empty($data['residuo_para_coleta_id'])) ? $data['residuo_para_coleta_id'] : null;
        $this->residuo_para_coleta_umido_desc = (!empty($data['residuo_para_coleta_umido_desc'])) ? $data['residuo_para_coleta_umido_desc'] : null;
        $this->residuo_para_coleta_umido_qtd_gerada = (!empty($data['residuo_para_coleta_umido_qtd_gerada'])) ? $data['residuo_para_coleta_umido_qtd_gerada'] : null;
        $this->residuo_para_coleta_umido_peso = (!empty($data['residuo_para_coleta_umido_peso'])) ? $data['residuo_para_coleta_umido_peso'] : null;
        $this->residuo_para_coleta_umido_tipo_acodic = (!empty($data['residuo_para_coleta_umido_tipo_acodic'])) ? $data['residuo_para_coleta_umido_tipo_acodic'] : null;
        $this->residuo_para_coleta_umido_nome_cooperativa = (!empty($data['residuo_para_coleta_umido_nome_cooperativa'])) ? $data['residuo_para_coleta_umido_nome_cooperativa'] : null;
        $this->residuo_para_coleta_umido_local_destinacao = (!empty($data['residuo_para_coleta_umido_local_destinacao'])) ? $data['residuo_para_coleta_umido_local_destinacao'] : null;
        $this->residuo_para_coleta_solido_desc = (!empty($data['residuo_para_coleta_solido_desc'])) ? $data['residuo_para_coleta_solido_desc'] : null;
        $this->residuo_para_coleta_solido_qtd_gerada = (!empty($data['residuo_para_coleta_solido_qtd_gerada'])) ? $data['residuo_para_coleta_solido_qtd_gerada'] : null;
        $this->residuo_para_coleta_solido_peso = (!empty($data['residuo_para_coleta_solido_peso'])) ? $data['residuo_para_coleta_solido_peso'] : null;
        $this->residuo_para_coleta_solido_tipo_acodic = (!empty($data['residuo_para_coleta_solido_tipo_acodic'])) ? $data['residuo_para_coleta_solido_tipo_acodic'] : null;
        $this->residuo_para_coleta_solido_nome_cooperativa = (!empty($data['residuo_para_coleta_solido_nome_cooperativa'])) ? $data['residuo_para_coleta_solido_nome_cooperativa'] : null;
        $this->residuo_para_coleta_solido_local_destinacao = (!empty($data['residuo_para_coleta_solido_local_destinacao'])) ? $data['residuo_para_coleta_solido_local_destinacao'] : null;
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

//    public $emp_prest_id;
//    public $emp_prest_cnpj;
//    public $emp_prest_insc_estadual;
//    public $emp_prest_email;
//    public $emp_prest_telefone;
//    public $emp_prest_celular;
//    public $emp_prest_data_cadastro;
//    public $emp_prest_resp_legal;
//    public $emp_prest_resp_legal_rg;
//    public $emp_prest_resp_legal_emissor_rg;
//    public $emp_prest_resp_legal_uf_orgao_emissor;
//
//    public function exchangeArray($data) {
//          echo "<br> Entrou no construtor grande gerador";
//        $this->id = (!empty($data['id'])) ? $data['id'] : null;
//        $this->emp_prest_id = (!empty($data['emp_prest_id'])) ? $data['emp_prest_id'] : null;
//        $this->emp_prest_cnpj = (!empty($data['emp_prest_cnpj'])) ? $data['emp_prest_cnpj'] : null;
//        $this->emp_prest_insc_estadual = (!empty($data['emp_prest_insc_estadual'])) ? $data['emp_prest_insc_estadual'] : null;
//        $this->emp_prest_email = (!empty($data['emp_prest_email'])) ? $data['emp_prest_email'] : null;
//        $this->emp_prest_telefone = (!empty($data['emp_prest_telefone'])) ? $data['emp_prest_telefone'] : null;
//        $this->emp_prest_celular = (!empty($data['emp_prest_celular'])) ? $data['emp_prest_celular'] : null;
//        $this->emp_prest_data_cadastro = (!empty($data['emp_prest_data_cadastro'])) ? $data['emp_prest_data_cadastro'] : null;
//        $this->emp_prest_resp_legal = (!empty($data['emp_prest_resp_legal'])) ? $data['emp_prest_resp_legal'] : null;
//        $this->emp_prest_resp_legal_rg = (!empty($data['emp_prest_resp_legal_rg'])) ? $data['emp_prest_resp_legal_rg'] : null;
//        $this->emp_prest_resp_legal_emissor_rg = (!empty($data['emp_prest_resp_legal_emissor_rg'])) ? $data['emp_prest_resp_legal_emissor_rg'] : null;
//        $this->emp_prest_resp_legal_uf_orgao_emissor = (!empty($data['emp_prest_resp_legal_uf_orgao_emissor'])) ? $data['emp_prest_resp_legal_uf_orgao_emissor'] : null;
//    }
}
