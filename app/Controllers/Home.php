<?php
namespace Controllers;

use Core\View;
use Core\Controller;

use Helpers\Session;
use Helpers\Url;
use Helpers\Gump;
use Helpers\Auth;

use Models\User;
use Models\Post;

/*
 * Welcome controller
 *
 * @author David Carr - dave@simplemvcframework.com
 * @version 2.2
 * @date June 27, 2014
 * @date updated May 18 2015
 */
class Home extends Controller
{

    /**
     * Call the parent construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->language->load('Welcome');
    }

    /**
     * Define Index page title and load template files
     */
    public function index()
    {
        $this->data['title'] = 'Home';

        // $albumModel = new \Models\Album;
        // $albumitemModel = new \Models\Albumitem;

        // $this->data['slider'] = $albumModel->name('homes');

        View::renderTemplate('header2', $this->data);
        View::render('home/home.index', $this->data);
        View::renderTemplate('footer2', $this->data);
    }


   
}
