<?php

namespace GrandeGerador\Model;

// import Model\GrandeGerador
use GrandeGerador\Model\ResiduosGeradosHasGrandeGerador,
    GrandeGerador\Model\ResiduosGeradosHasGrandeGeradorTable;
// import Zend\Db
use Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\TableGateway;

class ResiduosGeradosHasGrandeGerador {  
    public $residuos_gerados_grande_gerador_id;
    public $residuos_gerados_grande_gerador_qtd_dia;
    public $residuos_gerados_grande_gerador_peso_espc;
    public $grande_gerador_fk;
    public $grande_gerador_fk_nome;
    public $residuo_fk;
    public $residuo_fk_descricao;
   

    public function exchangeArray($data) {
        
          echo '<pre>';

                var_dump($data);
                echo '</pre>';
        // echo "<br> Entrou no construtor GrandeGerador";
        $this->residuos_gerados_grande_gerador_id = (!empty($data['residuos_gerados_grande_gerador_id'])) ? $data['residuos_gerados_grande_gerador_id'] : null;
        
        $this->residuos_gerados_grande_gerador_qtd_dia = (!empty($data['residuos_gerados_grande_gerador_qtd_dia'])) ? $data['residuos_gerados_grande_gerador_qtd_dia'] : null;
        $this->residuos_gerados_grande_gerador_peso_espc = (!empty($data['residuos_gerados_grande_gerador_peso_espc'])) ? $data['residuos_gerados_grande_gerador_peso_espc'] : null;
        $this->grande_gerador_fk = (!empty($data['grande_gerador_fk'])) ? $data['grande_gerador_fk'] : null;
        $this->residuo_fk = (!empty($data['residuo_fk'])) ? $data['residuo_fk'] : null;
        
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
