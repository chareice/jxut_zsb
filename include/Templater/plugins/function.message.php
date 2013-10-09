<?php
    function smarty_function_message($params, $smarty)
    {
        $name = '';
        $value = '';

        if (isset($params['name']))
            $name = $params['name'];

        if (isset($params['value']))
            $value = $params['value'];

        $fckeditor = new FCKEditor($name);
        $fckeditor->BasePath = '/js/fckeditor/';
        $fckeditor->ToolBarSet= "Default";
        $fckeditor->Height = 600;
		$fckeditor->Width = 800;
        $fckeditor->Value = $value;

        return $fckeditor->CreateHtml();
    }
?>
