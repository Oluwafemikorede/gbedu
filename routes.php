<?php
use Core\Router;

 Router::any('welcome/(:any)', '\Controllers\Home@yes');
?>