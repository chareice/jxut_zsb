<?php
    function smarty_function_wysiwyg($params, $smarty)
    {
        $name = '';
        $value = '';

        if (isset($params['name']))
            $name = $params['name'];

        if (isset($params['value']))
            $value = $params['value'];

        $fckeditor = new FCKEditor($name);
        $fckeditor->BasePath = '/js/fckeditor/';
        $fckeditor->ToolBarSet = "Basic";
        $fckeditor->Height = 500;
        $fckeditor->Value = $value;

        return $fckeditor->CreateHtml();
    }
?>
