<?php
    set_include_path("/www/include");

    require "block.php";
    if(!isallow()){
        die("access denied");
    }//ip访问限制，白名单文件为 ../allowip.json

    require_once "../include/Zend/Loader/Autoloader.php";
	Zend_Loader_Autoloader::getInstance()->setFallbackAutoloader(true);
    // load the application configuration
    $config = new Zend_Config_Ini('../setting.ini', 'development');
    Zend_Registry::set('config', $config);

    // create the application logger
    $logger = new Zend_Log(new Zend_Log_Writer_Stream($config->logging->file));
    Zend_Registry::set('logger', $logger);

    // connect to the database
    $params = array('host'     => $config->database->hostname,
                    'username' => $config->database->username,
                    'password' => $config->database->password,
                    'dbname'   => $config->database->database,
					'charset'   => $config->database->charset
					);
    $db = Zend_Db::factory($config->database->type, $params);
    Zend_Registry::set('db', $db);

    // setup application authentication
    $auth = Zend_Auth::getInstance();
    $auth->setStorage(new Zend_Auth_Storage_Session());

    // handle the user request
    $controller = Zend_Controller_Front::getInstance();
    $controller->setControllerDirectory($config->paths->base .
                                        '/include/Controllers');
    $controller->registerPlugin(new CustomControllerAclManager($auth));

    // setup the view renderer
    $vr = new Zend_Controller_Action_Helper_ViewRenderer();
    $vr->setView(new Templater());
    $vr->setViewSuffix('tpl');
    Zend_Controller_Action_HelperBroker::addHelper($vr);

    //setup the route for tags space 2012-2-6
	$route = new Zend_Controller_Router_Route('news/tag/:tag/*',
	                                           array('controller'=>'news',
												     'action'    =>'tag'));
	$controller->getRouter()->addRoute('tagspace',$route);
	
	$controller->dispatch();
