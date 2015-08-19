<?php
namespace Controllers;

use Core\View;
use Core\Controller;

use Helpers\Session;
use Helpers\Url;
use Helpers\Gump;
use Helpers\Auth;
use Helpers\Paginator;

use Models\User;
use Models\Album;
use Models\Post;

/*
 * Welcome controller
 *
 * @author David Carr - dave@simplemvcframework.com
 * @version 2.2
 * @date June 27, 2014
 * @date updated May 18 2015
 */
class Playlist extends Controller
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
    public function index($parameter)
    {
        $this->data['title'] = 'Home';

        $albumModel = new Album;
        // $albumitemModel = new \Models\Albumitem;

        // $this->data['slider'] = $albumModel->name('homes');

        $total = count(Album::type('playlist'));   

        $pages = new Paginator('10','p');
        $this->data['playlists'] = Album::type('playlist', $pages->getLimit() );
        $pages->setTotal($total);
        $path = DIR.'playlist?';  
        $this->data['page_links'] = $pages->pageLinks($path,null);

        View::renderTemplate('header', $this->data);
        View::renderTemplate('sidebar', $this->data);
        View::render('playlist/index.playlist', $this->data);
        View::renderTemplate('footer', $this->data);
    }


     /**
     * Define Index page title and load template files
     */
    public function listen($parameter)
    {
        $playlistSlug = $parameter[0];
        $albumModel = new Album;
        $this->data['playlist'] = Album::row('album_slug',$playlistSlug);

        $this->data['songs']    = \Models\Playlist::items($this->data['playlist']->album_id);

        $this->data['title'] = 'Listen ';

        // $albumModel = new \Models\Album;
        // $albumitemModel = new \Models\Albumitem;

        // $this->data['slider'] = $albumModel->name('homes');

        View::renderTemplate('header', $this->data);
        View::renderTemplate('sidebar', $this->data);
        View::render('playlist/listen.playlist', $this->data);
        View::renderTemplate('footer', $this->data);
    }


   
}
