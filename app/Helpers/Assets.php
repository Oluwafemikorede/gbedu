<?php
namespace Helpers;

use Helpers\Url;
use Models\Page;

/**
 * Assets static helper
 *
 * @author volter9
 * @author QsmaPL
 * @date 27th November, 2014
 * @date May 18 2015
 */

class Assets
{
    /**
     * @var array Asset templates
     */
    protected static $templates = array
    (
        'js'  => '<script src="%s" type="text/javascript"></script>',
        'css' => '<link href="%s" rel="stylesheet" type="text/css">'
    );

    /**
     * Common templates for assets.
     *
     * @param string|array $files
     * @param string       $template
     */
    protected static function resource($files, $template)
    {
        $template = self::$templates[$template];

        if (is_array($files)) {
            foreach ($files as $file) {
                echo sprintf($template, $file) . "\n";
            }
        } else {
            echo sprintf($template, $files) . "\n";
        }
    }

    /**
     * Output script
     *
     * @param array|string $file
     */
    public static function js($files)
    {
        static::resource($files, 'js');
    }

    /**
     * Output stylesheet
     *
     * @param string $file
     */
    public static function css($files)
    {
        static::resource($files, 'css');
    }

     /**
     * Output full image
     *
     * @param string $file
     */
    public static function image($path, $class = '', $style= ''){
    
        if(is_file(RESOURCE_PATH.$path) && $path != ''){
                echo '<img src="'.Url::templatePath().$path.'" class="'.$class.'"" style="'.$style.'" />';
        } else {
            echo '';
        }
    }


    /**
     * Output full image
     *
     * @param string $file
     */
    public static function showBg($path){
    
        if(is_file(RESOURCE_PATH.$path) && $path != ''){
                echo Url::templatePath().$path;
        } else {
                echo '';
        }
    }

    public static function download($path){
        $filepath = BASE_PATH.DS.'app/templates'.DS.TEMPLATE.DS.$path;
        
        if(file_exists($filepath) && $path != ''){
                $filename = 'Project Document'.time(); // of course find the exact filename....        
                header('Pragma: public');
                header('Expires: 0');
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header('Cache-Control: private', false); // required for certain browsers 
                // header('Content-Type: application/pdf');

                header('Content-Disposition: attachment; filename="'. basename($filepath) . '";');
                header('Content-Transfer-Encoding: binary');
                header('Content-Length: ' . filesize($filepath));
                readfile($filepath);
                exit;
                // return Url::templatePath().$path;
        } else {
            return '';
        }
    }


    public static function file($path){
        if(file_exists(BASE_PATH.DS.'app/templates'.DS.TEMPLATE.DS.$path) && $path != '')
            return Url::templatePath().$path;
        else 
            return '';
        
    }

    /**
     * Output thumbnail image
     *
     * @param string $file
     */
    public static function showThumb($path,$class='',$style=''){
        $img_array = explode('/', $path);

        $imgFilePath = BASE_PATH.DS.'app/templates/default/'.$img_array[0].DS.'thumb_'.$img_array[1];
        $imgSrc      = Url::templatePath().$img_array[0].DS.'thumb_'.$img_array[1];
        
        if(is_file($imgFilePath) && $path != ''){
            echo '<img src="'.$imgSrc.'" class="'.$class.'"" style="'.$style.'" />';     
        }
    }

    public static function activeClass($path = '',$style_class) 
    {
        $uri = parse_url($_SERVER['QUERY_STRING'], PHP_URL_PATH);
        $uri = trim($uri, ' /');
        $parts = explode('/', $uri);

        $last_url_path = end($parts);

        if($path == 'home' && $last_url_path ==''){
            return $style_class;
            
        }

         if($last_url_path == $path){
            return $style_class;
         }
    }

    public static function header($topmenu){
        // var_dump($topmenu);

        foreach($topmenu as $link){ 
           $topmenu2 = Page::otherMenu($link->page_id);
        if(count($topmenu2) > 0){ 
           $header .= '<li class="'.Assets::activeClass($link->page_alias, 'active').' page_item dropdown">';
           $header .=   '<a href="'.DIR.$link->page_alias.'" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" >';
       } else {
           $header .= '<li class="'.Assets::activeClass($link->page_alias, 'active').' page_item">';
           $header .=   "<a href='".DIR.$link->page_alias."' >";
       }
           $header .=  $link->page_name;
           $header .=  "</a>";
             
                    $topmenu2 = Page::otherMenu($link->page_id);

                    if(count($topmenu2) > 0){ 
                        $header .=  '<ul class="dropdown-menu">';
                         foreach($topmenu2 as $link2){ 
                            $header .=  '<li>';
                            $header .=  '<a href="'.DIR.$link->page_alias.'/'.$link2->page_alias.'" >';
                            $header .=  $link2->page_name;
                            $header .=  '</a>';

                            //check for third level menu
                            $topmenu3 = Page::otherMenu($link2->page_id);
                            if(count($topmenu3) > 0){ 
                                $header .=  '<ul id="nav_menu_3">';
                                    foreach($topmenu3 as $link3){ 
                                        $header .=  '<li>';
                                        $header .=  '<a href="'.DIR.$link->page_alias.'/'.$link2->page_alias.'/'.$link3->page_alias.'; >';
                                        $header .=  $link3->page_name;
                                        $header .=  '</a>';
                                        $header .=  '</li>';
                                    }
                                $header .=  '</ul>';
                            }


                            $header .=  '</li>';
                            } 
                       $header .=  '</ul>';
                    } 
            $header .=  '</li>';                          
        } 

        return $header;
    }
}
