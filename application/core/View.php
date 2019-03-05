<?php

namespace core;

class View
{

    /** @var string */
    public $defaultTemplateViewPatch = 'template_view.php';

    /**
     * @param string $content_view
     * @param array|null $data
     * @param string|null $template_view
     */
    public function generate(string $content_view, array $data = null, string $template_view = null)
    {
        $data['content_view'] = $content_view . '.php';

        if(is_array($data)) {
            extract($data);
        }

        if(is_null($template_view)){
            $template_view = $this->defaultTemplateViewPatch;
        }

        include App::helper()->getPrepareAppPatch("views/$template_view");
    }
}
