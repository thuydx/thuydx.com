<?php
chdir(dirname(__DIR__));

defined('WEB_ROOT')
|| define('WEB_ROOT', realpath(dirname(dirname(__FILE__))));

defined('ZF2_LIBRARY')
|| define('ZF2_LIBRARY', realpath((getenv('ZF2_PATH')?:'vendor\ZendFramework\library')));
defined('DOCTRINE_LIBRARY')
|| define('DOCTRINE_LIBRARY', realpath((getenv('DOCTRINE_PATH')?:'vendor\Doctrine')));

defined('APPLICATION_ENV')
|| define('APPLICATION_ENV', getenv('APPLICATION_ENV'));

set_include_path(implode(PATH_SEPARATOR,array(
    ZF2_LIBRARY,
    DOCTRINE_LIBRARY,
    get_include_path(),
)));

require_once 'Zend/Loader/AutoloaderFactory.php';
Zend\Loader\AutoloaderFactory::factory();
if (!($env = APPLICATION_ENV)) {
    $env = 'local';
}

$appConfig = include 'config/application.config.php';

$listenerOptions  = new Zend\Module\Listener\ListenerOptions($appConfig['module_listener_options']);
$defaultListeners = new Zend\Module\Listener\DefaultListenerAggregate($listenerOptions);
$defaultListeners->getConfigListener()->addConfigGlobPath("config/autoload/{,*.}{global,local}.config.php");

$moduleManager = new Zend\Module\Manager($appConfig['modules']);
$moduleManager->events()->attachAggregate($defaultListeners);
$moduleManager->loadModules();

// Create application, bootstrap, and run
$bootstrap   = new Zend\Mvc\Bootstrap($defaultListeners->getConfigListener()->getMergedConfig());
$application = new Zend\Mvc\Application;
$bootstrap->bootstrap($application);
$application->run()->send();
