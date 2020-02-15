<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Micro;
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

try {

    /**
     * The FactoryDefault Dependency Injector automatically registers the services that
     * provide a full stack framework. These default services can be overidden with custom ones.
     */
    $di = new FactoryDefault();

    /**
     * Include Autoloader
     */
    include APP_PATH . '/config/loader.php';

    /**
     * Include Services
     */
    include APP_PATH . '/config/services.php';
    /**
     * Get config service for use in inline setup below
     */
    $config = $di->get('config');

    /**
     * Starting the application
     * Assign service locator to the application
     */
    $app = new Micro($di);

    /**
     * Include Application
     */
    include APP_PATH . '/app.php';

    /**
     * Handle the request
     */
    $app->handle($_SERVER["REQUEST_URI"]);

} catch (\Exception $e) {

    if ('production' === env('APPLICATION_ENV')) {
        $di->get('logger')->error($e->getMessage());
    } else {
        echo $e->getMessage() . '<br>';
        echo '<pre>' . $e->getTraceAsString() . '</pre>';
    }
}
