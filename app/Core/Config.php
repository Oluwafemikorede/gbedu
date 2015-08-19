<?php
namespace Core;

use Helpers\Session;

/*
 * config - an example for setting up system settings
 * When you are done editing, rename this file to 'config.php'
 *
 * @author David Carr - dave@simplemvcframework.com
 * @author Edwin Hoksberg - info@edwinhoksberg.nl
 * @version 2.2
 * @date June 27, 2014
 * @date updated May 18 2015
 */
class Config
{
    public function __construct()
    {

        //turn on output buffering
        ob_start();

        define('DS', DIRECTORY_SEPARATOR);


        if(ENVIRONMENT == 'development'){
            define('DIR', 'http://localhost/gbedu/');
            define('UPLOAD_PATH' , BASE_PATH.DS.'app'.DS.'templates'.DS.'default'.DS.'images'.DS);
            define('RESOURCE_PATH' , BASE_PATH.DS.'app'.DS.'templates'.DS.'default'.DS);
        } else {
            define('DIR', 'http://gbedumobile.com/new/');
            define('UPLOAD_PATH' , BASE_PATH.DS.'new'.DS.'app'.DS.'templates'.DS.'default'.DS.'images'.DS);
        }

        //set default controller and method for legacy calls
        define('DEFAULT_CONTROLLER', 'Home');
        define('DEFAULT_METHOD', 'index');

        //set the default template
        define('TEMPLATE', 'default');

        //facebook app settings
        define('APP_ID' , '822756641153927');
        define('APP_SECRET' , 'bfac2e687036cd8d06c4d75a9b1c127d');

        //set a default language
        define('LANGUAGE_CODE', 'en');

        //database details ONLY NEEDED IF USING A DATABASE
        define('DB_TYPE', 'mysql');
        define('DB_HOST', '127.0.0.1');
        if(ENVIRONMENT == 'development'){
            define('DB_NAME', 'gbedu');
            define('DB_USER', 'root');
            define('DB_PASS', 'root');
        } else {
            define('DB_NAME', 'gbedumobile');
            define('DB_USER', 'gbedu_user');
            define('DB_PASS', 'pa55w0rd');
        }
        define('PREFIX', 'smvc_');

        //set prefix for sessions
        define('SESSION_PREFIX', 'gbedu_');

        //optionall create a constant for the name of the site
        define('SITETITLE', 'Gbedu');

        
        //turn on custom error handling
        set_exception_handler('Core\Logger::ExceptionHandler');
        set_error_handler('Core\Logger::ErrorHandler');

        //set timezone
        date_default_timezone_set('Africa/Lagos');

        //start sessions
        Session::init();
    }
}
