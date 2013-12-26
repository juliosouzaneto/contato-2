<?php

namespace Prestadora\Model;

class Prestadora {

    public $emp_prest_id;
    public $emp_prest_cnpj;
    public $emp_prest_insc_estadual;
    public $emp_prest_email;
    public $emp_prest_telefone;
    public $emp_prest_celular;
    public $emp_prest_data_cadastro;
    public $emp_prest_resp_legal;
    public $emp_prest_resp_legal_rg;
    public $emp_prest_resp_legal_emissor_rg;
    public $emp_prest_resp_legal_uf_orgao_emissor;

//    function __construct($emp_prest_id, $emp_prest_cnpj, $emp_prest_insc_estadual, $emp_prest_email, $emp_prest_telefone, $emp_prest_celular, $emp_prest_data_cadastro, $emp_prest_resp_legal, $emp_prest_resp_legal_rg, $emp_prest_resp_legal_emissor_rg, $emp_prest_resp_legal_uf_orgao_emissor) {
//
//
//        $this->emp_prest_id = $emp_prest_id;
//        $this->emp_prest_cnpj = $emp_prest_cnpj;
//        $this->emp_prest_insc_estadual = $emp_prest_insc_estadual;
//        $this->emp_prest_email = $emp_prest_email;
//        $this->emp_prest_telefone = $emp_prest_telefone;
//        $this->emp_prest_celular = $emp_prest_celular;
//        $this->emp_prest_data_cadastro = $emp_prest_data_cadastro;
//        $this->emp_prest_resp_legal = $emp_prest_resp_legal;
//        $this->emp_prest_resp_legal_rg = $emp_prest_resp_legal_rg;
//        $this->emp_prest_resp_legal_emissor_rg = $emp_prest_resp_legal_emissor_rg;
//        $this->emp_prest_resp_legal_uf_orgao_emissor = $emp_prest_resp_legal_uf_orgao_emissor;
//    }

    public function exchangeArray($data) {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->emp_prest_id = (!empty($data['emp_prest_id'])) ? $data['emp_prest_id'] : null;
        $this->emp_prest_cnpj = (!empty($data['emp_prest_cnpj'])) ? $data['emp_prest_cnpj'] : null;
        $this->emp_prest_insc_estadual = (!empty($data['emp_prest_insc_estadual'])) ? $data['emp_prest_insc_estadual'] : null;
        $this->emp_prest_email = (!empty($data['emp_prest_email'])) ? $data['emp_prest_email'] : null;
        $this->emp_prest_telefone = (!empty($data['emp_prest_telefone'])) ? $data['emp_prest_telefone'] : null;
        $this->emp_prest_celular = (!empty($data['emp_prest_celular'])) ? $data['emp_prest_celular'] : null;
        $this->emp_prest_data_cadastro = (!empty($data['emp_prest_data_cadastro'])) ? $data['emp_prest_data_cadastro'] : null;
        $this->emp_prest_resp_legal = (!empty($data['emp_prest_resp_legal'])) ? $data['emp_prest_resp_legal'] : null;
        $this->emp_prest_resp_legal_rg = (!empty($data['emp_prest_resp_legal_rg'])) ? $data['emp_prest_resp_legal_rg'] : null;
        $this->emp_prest_resp_legal_emissor_rg = (!empty($data['emp_prest_resp_legal_emissor_rg'])) ? $data['emp_prest_resp_legal_emissor_rg'] : null;
        $this->emp_prest_resp_legal_uf_orgao_emissor = (!empty($data['emp_prest_resp_legal_uf_orgao_emissor'])) ? $data['emp_prest_resp_legal_uf_orgao_emissor'] : null;
    }

}
