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
    public $emp_prest_nome_fantasia;

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
        $this->emp_prest_nome_fantasia = (!empty($data['emp_prest_nome_fantasia'])) ? $data['emp_prest_nome_fantasia'] : null;
    }

    public function getInputFilter() {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                        'name' => 'id',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'Int'),
                        ),
            )));

            $inputFilter->add($factory->createInput(array(
                        'name' => 'artist',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ),
                        'validators' => array(
                            array(
                                'name' => 'StringLength',
                                'options' => array(
                                    'encoding' => 'UTF-8',
                                    'min' => 1,
                                    'max' => 100,
                                ),
                            ),
                        ),
            )));

            $inputFilter->add($factory->createInput(array(
                        'name' => 'title',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ),
                        'validators' => array(
                            array(
                                'name' => 'StringLength',
                                'options' => array(
                                    'encoding' => 'UTF-8',
                                    'min' => 1,
                                    'max' => 100,
                                ),
                            ),
                        ),
            )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

    public function cadastrarAction() {
        $form = new OrgaoForm();
//$form->setAttribute('action', $this->url('contact/process'));
//$form->setAttribute('method', 'post');
        $form->setAttribute('class', 'search_form general_form');

        $request = $this->getRequest();
        if ($request->isPost()) {

//instanciando o model orgao
            $orgao = new Orgao();

//pegando os dados postados
            $data = $request->getPost();

            $form->setInputFilter($orgao->getInputFilter());
            $form->setData($data);

            if ($form->isValid()) {
                $orgao->exchangeArray($data);
                $this->getOrgaoTable()->saveOrgao($orgao);

                $this->flashMessenger()->addMessage(array('success' => 'Orgão cadastrado com sucesso!'));
                $this->redirect()->toUrl('cadastrar');
            }
        }
    }


}
