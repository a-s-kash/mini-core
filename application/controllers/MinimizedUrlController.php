<?php

use core\App;
use models\entity\MiniLink;
use models\repository\MiniLinkRepository;

class MinimizedUrlController extends core\Controller
{
    public function actionIndex()
    {
        $linkLifeTime = \core\App::currentDateTime()
            ->modify('+2 hour')
        ;

        $minimizedLink = '';

        if ($post = $_POST['MinimizedUrl']) {

            $linkLifeTime = new DateTime($post['life_time'], new \DateTimeZone(App::config()->getParams('date_time_zone')));

            $newMiniLinkKey = (new MinimizedUrlModel())
                ->makeNewMinimizedKey()
            ;

            $MiniLinkRepository = new MiniLinkRepository();
            $originalLink = addslashes($post['original_link']);

            /** @var MiniLink $miniLink */
            if(!$miniLink = $MiniLinkRepository->findAll(["original_link = '$originalLink'"])[0]){
                $miniLink = (new MiniLink())
                    ->setOriginalLink($originalLink)
                    ->setMinimizedLinkKey($newMiniLinkKey)
                    ->setLifeTime($linkLifeTime->getTimestamp())
                ;

                $MiniLinkRepository->push($miniLink);
            } else if($linkLifeTime->getTimestamp() > $miniLink->getLifeTime()){
                $MiniLinkRepository->push($miniLink
                    ->setOriginalLink($originalLink)
                    ->setMinimizedLinkKey($newMiniLinkKey)
                    ->setLifeTime($linkLifeTime->getTimestamp())
                );
            }

            $minimizedLink = $miniLink->makeMinimizedLink();
        }

        $this->view->generate('main', [
            'defaultLifeTime' => $linkLifeTime
                ->format("Y-m-d\TH:00"),
            'minimizedLink' => $minimizedLink,
        ]);
    }

    public function actionStatisticsFollowing()
    {
        $miniLinks = (new MiniLinkRepository)->findAll();

        /** @var MiniLink $miniLink */
        foreach ($miniLinks as $miniLink){
            if((new DateTime())->getTimestamp() > $miniLink->getLifeTime()){
                $miniLink->timeIsOver = true;
            }

            $miniLink->makeMinimizedLink();
            $miniLink->makeClickLinks();
        }

        $this->view->generate('statistics_following_to_the_links', [
            'miniLinks' => $miniLinks
        ]);
    }
}
