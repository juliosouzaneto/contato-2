<?php

namespace GrandeGerador\Model;

// import Model\GrandeGerador
use GrandeGerador\Model\GrandeGerador,
    GrandeGerador\Model\GrandeGeradorTable;
// import Zend\Db
use Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\TableGateway;

use Zend\InputFilter\Factory as InputFactory;     // <-- Add this import
use Zend\InputFilter\InputFilter;                 // <-- Add this import
use Zend\InputFilter\InputFilterAwareInterface;   // <-- Add this import
use Zend\InputFilter\InputFilterInterface;        // <-- Add this import


class GrandeGerador implements InputFilterAwareInterface {

    public $grande_gerador_id;
    public $grande_gerador_razao_social;
    public $grande_gerador_cnpj;
    public $grande_gerador_endereco;
    public $grande_gerador_rua;
    public $grande_gerador_cep;
    public $grande_gerador_telefone;
    public $grande_gerador_email;
    public $grande_gerador_resp_legal;
    public $grande_gerador_nome_fantasia;
    public $grande_gerador_situacao;
    public $grande_gerador_data_cadastro;
    public $grande_gerador_senha;
    public $grande_gerador_atividade_principal;
    public $grande_gerador_codigo_atividade_principal;
    public $emp_prestadora_fk;

    public function exchangeArray($data) {


//        echo '<pre>';
//
//                var_dump($data);
//                echo '</pre>';
        // echo "<br> Entrou no construtor GrandeGerador";
        $this->grande_gerador_id = (!empty($data['grande_gerador_id'])) ? $data['grande_gerador_id'] : null;
       
        $this->grande_gerador_razao_social = (!empty($data['grande_gerador_razao_social'])) ? $data['grande_gerador_razao_social'] : null;
        $this->grande_gerador_cep = (!empty($data['grande_gerador_cep'])) ? $data['grande_gerador_cep'] : null;
        $this->grande_gerador_email = (!empty($data['grande_gerador_email'])) ? $data['grande_gerador_email'] : null;
        $this->grande_gerador_endereco = (!empty($data['grande_gerador_endereco'])) ? $data['grande_gerador_endereco'] : null;
        $this->grande_gerador_resp_legal = (!empty($data['grande_gerador_resp_legal'])) ? $data['grande_gerador_resp_legal'] : null;
        $this->grande_gerador_rua = (!empty($data['grande_gerador_rua'])) ? $data['grande_gerador_rua'] : null;
        $this->grande_gerador_telefone = (!empty($data['grande_gerador_telefone'])) ? $data['grande_gerador_telefone'] : null;
        $this->grande_gerador_cnpj = (!empty($data['grande_gerador_cnpj'])) ? $data['grande_gerador_cnpj'] : null;
        $this->grande_gerador_nome_fantasia = (!empty($data['grande_gerador_nome_fantasia'])) ? $data['grande_gerador_nome_fantasia'] : null;
        $this->grande_gerador_situacao = (!empty($data['grande_gerador_situacao'])) ? $data['grande_gerador_situacao'] : null;
        $this->grande_gerador_data_cadastro = (!empty($data['grande_gerador_data_cadastro'])) ? $data['grande_gerador_data_cadastro'] : null;
        $this->grande_gerador_senha = (!empty($data['grande_gerador_senha'])) ? $data['grande_gerador_senha'] : null;
        $this->grande_gerador_atividade_principal = (!empty($data['grande_gerador_atividade_principal'])) ? $data['grande_gerador_atividade_principal'] : null;
        $this->grande_gerador_codigo_atividade_principal = (!empty($data['grande_gerador_codigo_atividade_principal'])) ? $data['grande_gerador_codigo_atividade_principal'] : null;
        $this->emp_prestadora_fk = (!empty($data['emp_prestadora_fk'])) ? $data['emp_prestadora_fk'] : null;
    }

    public function exchangeArray2($data) {
        // echo "<br> Entrou no construtor GrandeGerador";

        $this->grande_gerador_cnpj = (!empty($data['grande_gerador_cnpj'])) ? $data['grande_gerador_cnpj'] : null;

//        echo '<pre>';
//
//        var_dump($this->grande_gerador_cnpj);
//        echo '</pre>';
    }
    
    
      // Add content to this method:
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name'     => 'id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'grande_gerador_nome_fantasia',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            )));

      

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
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
