<?php

use Helpers\Assets;
use Helpers\Url;
use Helpers\Session;
use Helpers\Document;
use Helpers\Hooks;

//initialise hooks
$hooks = Hooks::get();
?>	

<!DOCTYPE html>
<html lang="en">
<head>
	
	<!-- start: Meta -->
	<meta charset="utf-8">
	<title><?php echo $title.' | '.SITETITLE; ?></title>
     <!-- <base href="<?php //echo Url::get_template_path(); ?>"><meta name="description" content="Bootstrap Metro Dashboard"> -->
	<meta name="author" content="Oluwafemi Korede">
	<meta name="keyword" content="Dashboard">
	<!-- end: Meta -->
	
	<!-- start: Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- end: Mobile Specific -->
	
	<!-- start: CSS -->
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
		
	<!-- start: Favicon -->
	<link rel="shortcut icon" href="img/favicon.ico">
	<!-- end: Favicon -->
	
			<style type="text/css">
			body { 
				background: url(<?php echo Url::templatePath().'img/bg-login.jpg'; ?>) !important; 
			}
		</style>
		
		
		
</head>

<body>

<?php if(isset($success) && $success != ''){ ?>
				<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert">×</button>
							<strong>Success!</strong> <?php echo $success; ?>
						</div>
			<?php } else if(isset($error) && $error != '') { ?>
			<div class="alert alert-error">
							<button type="button" class="close" data-dismiss="alert">×</button>
							<strong>Error!</strong> <?php echo $error; ?>
						</div>

			<?php } ?>


		<div class="container-fluid-full">
		<div class="row-fluid">
					
			<div class="row-fluid">
				<div class="login-box">
					<div class="icons">
						<a href="javascript:;"><i class="halflings-icon home"></i></a>
						<a href="javascript:;"><i class="halflings-icon cog"></i></a>
					</div>
					<h2>Login to your account</h2>
					
					<form class="form-horizontal" action="" method="post">
						<fieldset>
							
							<div class="input-prepend" title="Username">
								<span class="add-on"><i class="halflings-icon user"></i></span>
								<input class="input-large span10" name="email" id="username" type="text" placeholder="type username"/>
							</div>
							<div class="clearfix"></div>

							<div class="input-prepend" title="Password">
								<span class="add-on"><i class="halflings-icon lock"></i></span>
								<input class="input-large span10" name="password" id="password" type="password" placeholder="type password"/>
							</div>
							<div class="clearfix"></div>
							
							<label class="remember" for="remember"><input type="checkbox" id="remember" />Remember me</label>

							<div class="button-login">	
								<button type="submit" class="btn btn-primary">Login</button>
							</div>
							<div class="clearfix"></div>
					</form>
					<hr>
					<h3>Forgot Password?</h3>
					<p>
						No problem, <a href="javascript:;">click here</a> to get a new password.
					</p>	
				</div><!--/span-->
			</div><!--/row-->
			

	</div><!--/.fluid-container-->
	
		</div><!--/fluid-row-->
	
	<!-- start: JavaScript-->
<?php
Assets::js(array(
    Url::templatePath() . 'js/jquery-1.9.1.min.js',
    Url::templatePath() . 'js/jquery-migrate-1.0.0.min.js',
    Url::templatePath() . 'js/jquery-ui-1.10.0.custom.min.js',
    Url::templatePath() . 'js/jquery.ui.touch-punch.js',
    Url::templatePath() . 'js/modernizr.js',
    Url::templatePath() . 'js/bootstrap.min.js',
    Url::templatePath() . 'js/jquery.cookie.js',
    Url::templatePath() . 'js/fullcalendar.min.js',
    Url::templatePath() . 'js/jquery.dataTables.min.js',
    Url::templatePath() . 'js/excanvas.js',
    Url::templatePath() . 'js/jquery.flot.js',
    Url::templatePath() . 'js/jquery.flot.pie.js',
    Url::templatePath() . 'js/jquery.flot.stack.js',
    Url::templatePath() . 'js/jquery.flot.resize.min.js',
    Url::templatePath() . 'js/jquery.chosen.min.js',
    Url::templatePath() . 'js/jquery.uniform.min.js',
    Url::templatePath() . 'js/jquery.cleditor.min.js',
    Url::templatePath() . 'js/jquery.noty.js',
    Url::templatePath() . 'js/jquery.elfinder.min.js',
    Url::templatePath() . 'js/jquery.raty.min.js',
    Url::templatePath() . 'js/jquery.iphone.toggle.js',
    Url::templatePath() . 'js/jquery.uploadify-3.1.min.js',
    Url::templatePath() . 'js/jquery.gritter.min.js',
    Url::templatePath() . 'js/jquery.imagesloaded.js',
    Url::templatePath() . 'js/jquery.masonry.min.js',
    Url::templatePath() . 'js/jquery.knob.modified.js',
    Url::templatePath() . 'js/jquery.sparkline.min.js',
    Url::templatePath() . 'js/counter.js',
    Url::templatePath() . 'js/jquery.textareaCounter.plugin.js'
));

//hook for plugging in javascript
$hooks->run('js');

//hook for plugging in code into the footer
$hooks->run('footer');
?>
</body>
</html>
