<?php

/**
 * Class MainController
 *  /main/index
 */
class MainController extends core\Controller
{
    function actionIndex()
    {
        $this->view->generate('main');
    }
}
