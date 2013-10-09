<?php
    function smarty_function_geturl($params, $smarty)
    {
        $action     = isset($params['action']) ? $params['action'] : null;
        $controller = isset($params['controller']) ? $params['controller'] : null;

        $helper = Zend_Controller_Action_HelperBroker::getStaticHelper('url');

     	$url="http://".$_SERVER['HTTP_HOST'];
		$url .= $helper->simple($action, $controller);

        return $url;
    }
?>