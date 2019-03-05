<?php

namespace core;

use models\entity\ClickLink;
use models\repository\ClickLinkRepository;
use models\repository\MiniLinkRepository;

class Route
{
    /** @var string  */
    private $defaultControllerName = 'main';

    /** @var string  */
    private $defaultActionName = 'index';

    /** @var string */
    protected $routes;

    /** @var array  */
    private $getParams = [];

    /** @var Controller */
    public $controller;

    public function __construct()
    {
        $requestUrl = explode('?', $_SERVER['REQUEST_URI']);
        $routes = explode('/', $requestUrl[0]);
        $this->routes = array_filter($routes, function($element) {
            return !empty($element);
        });
        $this->getParams = $requestUrl[0];
    }

    protected function launchRouting(): void
    {
        $controllerName = $this->prepareName($this->routes[1] ?? $this->defaultControllerName);

        $modelName = $controllerName . 'Model';
        $controllerName .= 'Controller';

        if(!$this->declareClass($controllerName, 'controllers')){
            self::ErrorPage404();
        }

        $this->declareClass($modelName, 'models');

        $actionName = 'action' . $this->prepareName($this->routes[2] ?? $this->defaultActionName);

        $controller = new $controllerName;

        if(method_exists($controller, $actionName)) {
            $controller->$actionName();
        } else Route::ErrorPage404();

        $this->controller = $controller;
    }

    protected function checkFollowingToTheLink()
    {
        if(count($this->routes) != 1
            || ($routeLen = iconv_strlen($this->routes[1])) > 5
            || $routeLen < 3
        ){
            return null;
        }

        $minimizedLinkKey = $this->divideMiniLinkKey($this->routes[1]);
        $miniLinkRepository = new MiniLinkRepository();

        if(!$miniLink = $miniLinkRepository->findByMinimizedLinkKey($minimizedLinkKey)){
            return null;
        }

        if(App::currentDateTime()->getTimestamp() > $miniLink->getLifeTime()){
            return null;
        }

//        d([
//            'if',
//            $miniLink
//        ]);

        $ClickLink = (new ClickLink())
            ->setMiniLinkId($miniLinkRepository->getLastId())
            ->setTimeFollowedOnLink(App::currentDateTime()->getTimestamp())
        ;

        (new ClickLinkRepository())->push($ClickLink);

        echo '
        <script type="text/javascript">
          document.location.replace("'.$miniLink->getOriginalLink().'");
        </script>';
//
//        (new ClickLinkRepository())->push($ClickLink);
//        header("Status: 302");
//        header('Location: ' . $miniLink->getOriginalLink(), TRUE, 301);
//        exit;
    }

    private function declareClass($className, $direction): ? bool
    {
        $classFile = $className . '.php';
        $classPath = App::helper()->getPrepareAppPatch("$direction/$classFile");

        if(!file_exists($classPath)) {
            return false;
        }

        include $classPath;

        return true;
    }

    private function prepareName(string $incompleteName):string
    {
        $incompleteName = ucwords(strtolower($incompleteName), "-") ;
        return str_replace("-", "", $incompleteName);
    }

    private function divideMiniLinkKey(string $miniLinkKey): string
    {
        $out = [];
        preg_match_all('~(\d+)?(?(1)|\D+)~', $miniLinkKey, $arr);

        foreach ($arr[0] as $item) {
            ctype_digit($item) ? $out['int'] = $item : $out['txt'] = $item;
        }

        return implode('-', [
            $out['int'],
            $out['txt'][0],
            $out['txt'][1]
        ]);
    }

    public static function ErrorPage404(): void
    {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/error-page/404';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header("Location: " . $host);
    }
}
