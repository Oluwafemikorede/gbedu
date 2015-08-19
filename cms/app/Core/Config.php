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
            define('DIR', 'http://localhost/gbedu/cms/');
            define('ROOT_DIR', 'http://localhost/gbedu/app/templates/default/');
            define('UPLOAD_PATH' , BASE_PATH.DS.'app'.DS.'templates'.DS.'default'.DS.'images'.DS);
            define('DEL_PATH' , BASE_PATH.DS.'app'.DS.'templates'.DS.'default'.DS);
        } else {
            


            define('UPLOAD_PATH' , BASE_PATH.DS.'new'.DS.'app'.DS.'templates'.DS.'default'.DS.'images'.DS);
        }

        //set default controller and method for legacy calls
        define('DEFAULT_CONTROLLER', 'Dashboard');
        define('DEFAULT_METHOD', 'index');

        //set the default template
        define('TEMPLATE', 'default');

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
            define('DB_NAME', 'evetsand_db');
            define('DB_USER', 'evetsand_user');
            define('DB_PASS', 'pa55w0rd');
        }
        define('PREFIX', 'smvc_');

        //set prefix for sessions
        define('SESSION_PREFIX', 'evets_');

        //optionall create a constant for the name of the site
        define('SITETITLE', 'Gbedu');


        //SET UPLOAD PATH FOR FILES AND IMAGES
        define('EXCEL_PATH' , BASE_PATH.DS.'app'.DS.'templates'.DS.'default'.DS.'img'.DS);


        //turn on custom error handling
        set_exception_handler('Core\Logger::ExceptionHandler');
        set_error_handler('Core\Logger::ErrorHandler');

        //set timezone
        date_default_timezone_set('Africa/Lagos');

        //start sessions
        Session::init();
    }
}
