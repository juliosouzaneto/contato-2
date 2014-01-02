<?php

namespace GrandeGerador\Model;

// import Model\GrandeGerador
use GrandeGerador\Model\GrandeGerador,
    GrandeGerador\Model\GrandeGeradorTable;
// import Zend\Db
use Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\TableGateway;

class GrandeGerador {


    public $grande_gerador_id;
    public $grande_gerador_razao_social;
    public $grande_gerador_cnpj;
    public $grande_gerador_endereco;
    public $grande_gerador_rua;
    public $grande_gerador_cep;
    public $grande_gerador_telefone;
    public $grande_gerador_email;
    public $grande_gerador_resp_legal;
    public $emp_prestadora_fk;

    public function exchangeArray($data) {
         echo "<br> Entrou no construtor GrandeGerador";
        $this->grande_gerador_id = (!empty($data['grande_gerador_id'])) ? $data['grande_gerador_id'] : null;
        
        $this->grande_gerador_cnpj = (!empty($data['grande_gerador_cnpj'])) ? $data['grande_gerador_cnpj'] : null;
        $this->grande_gerador_razao_social = (!empty($data['grande_gerador_razao_social'])) ? $data['grande_gerador_razao_social'] : null;
        $this->grande_gerador_cep = (!empty($data['grande_gerador_cep'])) ? $data['grande_gerador_cep'] : null;
        $this->grande_gerador_email = (!empty($data['grande_gerador_email'])) ? $data['grande_gerador_email'] : null;
        $this->grande_gerador_endereco = (!empty($data['grande_gerador_endereco'])) ? $data['grande_gerador_endereco'] : null;
        $this->grande_gerador_resp_legal = (!empty($data['grande_gerador_resp_legal'])) ? $data['grande_gerador_resp_legal'] : null;
        $this->grande_gerador_rua = (!empty($data['grande_gerador_rua'])) ? $data['grande_gerador_rua'] : null;
        $this->grande_gerador_telefone = (!empty($data['grande_gerador_telefone'])) ? $data['grande_gerador_telefone'] : null;
        $this->emp_prestadora_fk = (!empty($data['emp_prestadora_fk'])) ? $data['emp_prestadora_fk'] : null;
       
        
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
