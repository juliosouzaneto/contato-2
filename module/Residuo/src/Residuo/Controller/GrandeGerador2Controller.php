<?php

namespace GrandeGerador\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class GrandeGerador2Controller extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }


}

