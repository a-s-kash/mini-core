<?php
use core\Controller;

class BiscuitsController extends Controller
{
    public function actionForesee()
    {


        $this->view->generate('foresee_biscuits', [

        ]);
    }
}
