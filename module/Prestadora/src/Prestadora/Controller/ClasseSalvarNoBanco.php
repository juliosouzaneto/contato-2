/****Aquivo Controller****/
<?php

namespace Planejamento\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Planejamento\Form\OrgaoForm;
use Planejamento\Model\Orgao;

class OrgaoController extends AbstractActionController {

    protected $orgaoTable;

    public function getOrgaoTable() {
        if (!$this->orgaoTable) {
            $sm = $this->getServiceLocator();
            $this->orgaoTable = $sm->get('orgao_table');
        }
        return $this->orgaoTable;
    }

    public function indexAction() {

        $messages = $this->flashMessenger()->getMessages();
        $pageNumber = (int) $this->params()->fromQuery('pagina');
        if ($pageNumber == 0) {
            $pageNumber = 1;
        }

        $orgaos = $this->getOrgaoTable()->fetchAll($pageNumber);

        return new ViewModel(array(
            'messages' => $messages,
            'orgaos' => $orgaos,
            'titulo' => 'Orgão'
        ));
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

        $messages = $this->flashMessenger()->getMessages();

        $view = new ViewModel(array(
            'messages' => $messages,
            'titulo' => 'Orgão',
            'subtitulo' => 'Cadastrar',
            'form' => $form
        ));
        $view->setTemplate('planejamento/orgao/form.phtml');
        return $view;
    }

    public function editarAction() {
        $id = $this->params('id');

        $orgao = $this->getOrgaoTable()->getOrgao($id);
        $form = new OrgaoForm();
        $form->setBindOnValidate(false);
        $form->bind($orgao);
        $form->get('submit')->setLabel('EDITAR');
        $form->setAttribute('class', 'search_form general_form');

        $request = $this->getRequest();
        if ($request->isPost()) {

//pegando os dados postados
            $data = $request->getPost();

            $form->setInputFilter($orgao->getInputFilter());
            $form->setData($data);

            if ($form->isValid()) {
                $orgao->exchangeArray($data);
                $this->getOrgaoTable()->saveOrgao($orgao);

                $this->flashMessenger()->addMessage(array('success' => 'Orgão editado com sucesso!'));
                $this->redirect()->toUrl('../../orgao');
            }
        }

        $messages = $this->flashMessenger()->getMessages();

        $view = new ViewModel(array(
            'messages' => $messages,
            'titulo' => 'Orgão',
            'subtitulo' => 'Editar',
            'form' => $form
        ));
        $view->setTemplate('planejamento/orgao/form.phtml');
        return $view;
    }

    public function excluirAction() {
        $id = $this->params('id');

        $this->getOrgaoTable()->removeOrgao($id);

        $this->flashMessenger()->addMessage(array('success' => 'Orgão excluido com sucesso!'));
        $this->redirect()->toUrl('../../orgao');
    }

}
?>




/****Arquivo OrgaoTable****/

<?php

namespace Planejamento\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class OrgaoTable extends AbstractTableGateway {

    protected $table = 'pla_orgao';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Orgao());
        $this->initialize();
    }

    public function fetchAll($pageNumber = 1, $countPerPage = 10) {
        $select = new Select();
        $select->from(array('orgao' => $this->table))
                ->join(array('orgaotce' => 'pla_orgaotce'), 'orgao.codorgaotce = orgaotce.codorgaotce', array('descricaoorgaotce' => 'descricao'), 'INNER')
                ->order('orgaotce.descricao, orgao.descricao');

        $adapter = new DbSelect($select, $this->adapter, $this->resultSetPrototype);

        $paginator = new Paginator($adapter);
        $paginator->setCurrentPageNumber($pageNumber);
        $paginator->setItemCountPerPage($countPerPage);
        return $paginator;
    }

    public function getOrgao($codorgao) {
        $codorgao = (int) $codorgao;

        $rowSet = $this->select(array('codorgao' => $codorgao));
        $row = $rowSet->current();

        if (!$row) {
            throw new \Exception("Orgao ID# $codorgao não encontrado!");
        }
        return $row;
    }

    public function saveOrgao(Orgao $orgao) {
        $data = array(
            'ano' => $orgao->ano,
            'codorgaotce' => $orgao->codorgaotce,
            'codigo' => $orgao->codigo,
            'descricao' => strtoupper($orgao->descricao)
        );

        $codorgao = (int) $orgao->codorgao;

        if ($codorgao == 0) {
            try {
                $this->insert($data);
            } catch (Exception $e) {
                $pdoException = $e->getPrevious();
                var_dump($e);
                exit;
            }
        } else {
            if ($this->getOrgao($codorgao)) {
                $this->update($data, array('codorgao' => $codorgao));
            } else {
                throw new \Exception("Orgao ID# $codorgao não lozalizado no banco de dados!");
            }
        }
    }

    public function removeOrgao($codorgao) {
        $codorgao = (int) $codorgao;

        if ($this->getOrgao($codorgao)) {
            $this->delete(array('codorgao' => $codorgao));
        } else {
            throw new \Exception("Orgao ID# $codorgao não lozalizado no banco de dados!");
        }
    }

}
?>