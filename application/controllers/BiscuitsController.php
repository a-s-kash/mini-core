<?php
use core\Controller;

class BiscuitsController extends Controller
{
    public function actionForesee()
    {



        $log = (new \models\entity\PredictionMessageLog());

        $message = (new \models\entity\PredictionMessage())
            ->addPredictionMessageLog($log)
        ;

        d([
            'BiscuitsController action Foresee',
            $message,
        ]);

        $this->view->generate('foresee_biscuits', [

        ]);
    }
}
