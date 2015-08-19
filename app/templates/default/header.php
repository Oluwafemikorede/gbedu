<?php

use Helpers\Assets;
use Helpers\Url;
use Helpers\Hooks;
use Helpers\Session;

use Models\Page;

//initialise hooks
$hooks = Hooks::get();
?>
<!DOCTYPE html>
<html lang="en" class="app">
<head>  
  <meta charset="utf-8" />
  <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  

  <title><?php echo $title.' | '.SITETITLE; ?></title>

    <?php
    Assets::css(array(
    Url::templatePath() . 'js/jPlayer/jplayer.flat.css',
    Url::templatePath() . 'css/bootstrap.css',
    Url::templatePath() . 'css/animate.css',
    Url::templatePath() . 'css/font-awesome.min.css',
    Url::templatePath() . 'css/simple-line-icons.css',
    Url::templatePath() . 'css/font.css',
    Url::templatePath() . 'css/app.css'
  ));

  //hook for plugging in css
  $hooks->run('css');
  ?>


 
    <!--[if lt IE 9]>
    <?php
    Assets::js(array(
    Url::templatePath() . 'js/ie/html5shiv.js',
    Url::templatePath() . 'js/ie/respond.min.js',
    Url::templatePath() . 'js/ie/excanvas.js'
  ));
  ?>
  <![endif]-->
<!-- 
  <script type="text/javascript" src="http://hosted.musesradioplayer.com/mrp.js"></script>
<script type="text/javascript">
MRP.insert({
'url':'http://icestream.coolwazobiainfo.com:8000/coolfm-lagos',
'codec':'mp3',
'volume':100,
'autoplay':true,
'buffering':5,
'title':'Cool FM',
'bgcolor':'#FFFFFF',
'skin':'mcclean',
'width':180,
'height':60
});
</script>
 -->
</head>
<?php Session::notification(); ?>