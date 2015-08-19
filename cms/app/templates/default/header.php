<?php

use Helpers\Assets;
use Helpers\Url;
use Helpers\Hooks;
use Models\Page;
use Helpers\Style;

//initialise hooks
$hooks = Hooks::get();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	
	<!-- start: Meta -->
	<meta charset="utf-8">
	  <title><?php echo $title.' | '.SITETITLE; ?></title>
     <!-- <base href="<?php //echo \helpers\url::get_template_path(); ?>"> -->
	<meta name="description" content="Exolve Technologies Content Management System">
	<meta name="author" content="Exolve Technologies">
	<!-- end: Meta -->
	
	<!-- start: Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- end: Mobile Specific -->
	
	<!-- start: CSS -->
<!-- 	<link id="bootstrap-style" href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/" rel="stylesheet">
	<link id="base-style" href="css/.css" rel="stylesheet">
	<link id="base-style-responsive" href="css/.css" rel="stylesheet">
	<link href='' rel='stylesheet' type='text/css'> -->
	 <?php
    Assets::css(array(
        Url::templatePath() . 'css/bootstrap.min.css',
        Url::templatePath() . 'css/bootstrap-responsive.min.css',
        Url::templatePath() . 'css/style.css',
        Url::templatePath() . 'css/style-responsive.css',
        'http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext'
    ));

    //hook for plugging in css
    $hooks->run('css');
    ?>
	<!-- end: CSS -->
	

	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<link id="ie-style" href="css/ie.css" rel="stylesheet">
	<![endif]-->
	
	<!--[if IE 9]>
		<link id="ie9style" href="css/ie9.css" rel="stylesheet">
	<![endif]-->

	 <!-- CSS -->
   
		
	<!-- start: Favicon -->
	<link rel="shortcut icon" href="img/favicon.ico">
<?php
Assets::js(array(
    Url::templatePath() . 'tinymce/tinymce.min.js',
));

//hook for plugging in javascript
$hooks->run('js');

?>

	<!-- end: Favicon -->
<script type="text/javascript">
tinymce.init({
    selector: ".tinymce",
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
   ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
 });
</script>

		
</head>
