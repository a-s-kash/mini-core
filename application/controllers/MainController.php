<?php

/**
 * Class MainController
 *  /main/index
 */
class MainController extends core\Controller
{
    function actionIndex()
    {
        $this->view->generate('main', [
            'defaultLifeTime' => \core\App::currentDateTime()
                ->modify('+2 hour')
                ->format("Y-m-d\TH:00"),
            'minimizedLink' => null
        ]);
    }
}
