<?php

namespace Prestadora\Model;

class Veiculo {

    public $veiculo_id;
    public $veiculo_placa;
    public $veiculo_capacidade;
    public $veiculo_cor;
    public $veiculo_modelo;
    public $veiculo_ano;
    public $veiculo_est_conserv;
    public $veiculo_resp_legal;
    public $emp_prestadora_fk;


    public function exchangeArray($data) {
      //  $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->veiculo_id = (!empty($data['veiculo_id'])) ? $data['veiculo_id'] : null;
        $this->veiculo_placa = (!empty($data['veiculo_placa'])) ? $data['veiculo_placa'] : null;
        $this->veiculo_capacidade = (!empty($data['veiculo_capacidade'])) ? $data['veiculo_capacidade'] : null;
        $this->veiculo_cor = (!empty($data['veiculo_cor'])) ? $data['veiculo_cor'] : null;
        $this->veiculo_modelo = (!empty($data['veiculo_modelo'])) ? $data['veiculo_modelo'] : null;
        $this->veiculo_ano = (!empty($data['veiculo_ano'])) ? $data['veiculo_ano'] : null;
        $this->veiculo_est_conserv = (!empty($data['veiculo_est_conserv'])) ? $data['veiculo_est_conserv'] : null;
        $this->veiculo_resp_legal = (!empty($data['veiculo_resp_legal'])) ? $data['veiculo_resp_legal'] : null;
        $this->emp_prestadora_fk = (!empty($data['emp_prestadora_fk'])) ? $data['emp_prestadora_fk'] : null;
    }

   /* public function getInputFilter() {
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
                        'name' => 'veiculo_capacidade',
                        'required' => true,
      
                        'validators' => array(
                            array(
                                'name' => 'Int',
                          
                            ),
                        ),
            )));

//            $inputFilter->add($factory->createInput(array(
//                        'name' => 'title',
//                        'required' => true,
//                        'filters' => array(
//                            array('name' => 'StripTags'),
//                            array('name' => 'StringTrim'),
//                        ),
//                        'validators' => array(
//                            array(
//                                'name' => 'StringLength',
//                                'options' => array(
//                                    'encoding' => 'UTF-8',
//                                    'min' => 1,
//                                    'max' => 100,
//                                ),
//                            ),
//                        ),
//            )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }*/

//    public function cadastrarAction() {
//        $form = new OrgaoForm();
////$form->setAttribute('action', $this->url('contact/process'));
////$form->setAttribute('method', 'post');
//        $form->setAttribute('class', 'search_form general_form');
//
//        $request = $this->getRequest();
//        if ($request->isPost()) {
//
////instanciando o model orgao
//            $orgao = new Orgao();
//
////pegando os dados postados
//            $data = $request->getPost();
//
//            $form->setInputFilter($orgao->getInputFilter());
//            $form->setData($data);
//
//            if ($form->isValid()) {
//                $orgao->exchangeArray($data);
//                $this->getOrgaoTable()->saveOrgao($orgao);
//
//                $this->flashMessenger()->addMessage(array('success' => 'Orgão cadastrado com sucesso!'));
//                $this->redirect()->toUrl('cadastrar');
//            }
//        }
//    }


}
