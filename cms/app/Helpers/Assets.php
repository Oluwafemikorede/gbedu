<?php
namespace Helpers;

use Helpers\Url;

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
    public static function image($path, $class = '', $style= '', $background = false){
    
        if(is_file(DEL_PATH.$path) && $path != ''){
            if($background == true) 
                return ROOT_DIR.'app/templates/default'.DS.$path;
            else
                return '<img src="'.ROOT_DIR.$path.'" class="'.$class.'"" style="'.$style.'" />';

        } else {
            return '';
        }
    }

    /**
     * check if media exists 
     *
     * @param string $file
     */
    public static function media($path){
    
        if(is_file(DEL_PATH.$path) && $path != '')
            return true;
        else 
            return false;
    
    }

    /**
     * Output thumbnail image
     *
     * @param string $file
     */
    public static function imageThumb($path){
        $img_array = explode('/', $path);
        $imgpath   = BASE_PATH.DS.'app/templates/default'.DS.$img_array[0].DS.'thumb_'.$img_array[1];
        $image     = ROOT_DIR.$img_array[0].DS.'thumb_'.$img_array[1];
        // var_dump($imgpath );

        if(is_file($imgpath) && $path != ''){
                return '<img src="'.$image.'" class="'.$class.'"" style="'.$style.'" />';
        } else {
                return '';
        }

        // return ROOT_DIR.'app/templates/default'.DS.$img_array[0].DS.'thumb_'.$img_array[1];     
    }
}
