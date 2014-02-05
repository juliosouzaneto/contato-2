<?php

namespace Login\Model;

//// import Model\GrandeGerador
//use Login\Model\Login,
//    Login\Model\LoginTable;
//// import Zend\Db
//use Zend\Db\ResultSet\ResultSet,
//    Zend\Db\TableGateway\TableGateway;

class Login {


    public $login_usuario;
    public $login_senha;
    public $login_id;


    public function exchangeArray($data) {
         echo "<br> Entrou no construtor Residuo";
        $this->login_usuario = (!empty($data['login_usuario'])) ? $data['login_usuario'] : null;
        $this->login_senha = (!empty($data['login_senha'])) ? $data['login_senha'] : null;   
        $this->login_id = (!empty($data['login_id'])) ? $data['login_id'] : null;   
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
