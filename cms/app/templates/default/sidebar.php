<?php

use Helpers\Assets;
use Helpers\Url;
use Helpers\Session;
use Helpers\Document;
use Helpers\Hooks;
use Models\Category;

//initialise hooks
$hooks = Hooks::get();
?>
<body>
		<!-- start: Header -->
	<div class="navbar">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="index.html"><span>Admin</span></a>
								
				<!-- start: Header Menu -->
				<div class="nav-no-collapse header-nav">
					<ul class="nav pull-right">
						<!-- start: User Dropdown -->
						<li class="dropdown">
							<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
								<i class="halflings-icon white user"></i> <?php echo $auth->user_firstname; ?>
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu">
								<li class="dropdown-menu-title">
 									<span>Account Settings</span>
								</li>
								<li><a href="<?php echo DIR.'account/profile'; ?>"><i class="halflings-icon user"></i> Profile</a></li>
								<li><a href="<?php echo DIR.'account/logout'; ?>"><i class="halflings-icon off"></i> Logout</a></li>
							</ul>
						</li>
						<!-- end: User Dropdown -->
					</ul>
				</div>
				<!-- end: Header Menu -->
				
			</div>
		</div>
	</div>
	<!-- start: Header -->
		<div class="container-fluid-full">
		<div class="row-fluid">
			<!-- start: Main Menu -->
			<div id="sidebar-left" class="span2">
				<div class="nav-collapse sidebar-nav">
					<ul class="nav nav-tabs nav-stacked main-menu">
						<li><a href="<?php echo DIR.'dashboard'; ?>"><i class="icon-bar-chart"></i><span class="hidden-tablet"> Dashboard</span></a></li>
						<li>
							<a class="dropmenu" href="javascript:;"><i class="icon-folder-close-alt"></i><span class="hidden-tablet"> Artist</a>
							<ul>
								<li><a class="submenu" href="<?php echo DIR.'artist'; ?>"><i class="icon-file-alt"></i><span class="hidden-tablet"> View</span></a></li>
								<li><a class="submenu" href="<?php echo DIR.'artist/add'; ?>"><i class="icon-file-alt"></i><span class="hidden-tablet"> Add</span></a></li>
							</ul>	
						</li>

						<li>
							<a class="dropmenu" href="javascript:;"><i class="icon-folder-close-alt"></i><span class="hidden-tablet"> Songs</a>
							<ul>
								<li><a class="submenu" href="<?php echo DIR.'song'; ?>"><i class="icon-bar-chart"></i><span class="hidden-tablet"> All Songs</span></a></li>	
								<li><a class="submenu" href="<?php echo DIR.'song/add'; ?>"><i class="icon-bar-chart"></i><span class="hidden-tablet"> Add Song</span></a></li>	
								<li><a class="submenu" href="<?php echo DIR.'song/playlist'; ?>"><i class="icon-bar-chart"></i><span class="hidden-tablet"> Playlists</span></a></li>	
								<li><a class="submenu" href="<?php echo DIR.'song/album'; ?>"><i class="icon-bar-chart"></i><span class="hidden-tablet"> Album</span></a></li>	
							</ul>
						</li>
						
						<li><a class="dropmenu"  href="javascript:;"><i class="icon-bar-chart"></i><span class="hidden-tablet"> Page</span></a>
						<ul>
								<li><a class="submenu" href="<?php echo DIR.'page'; ?>"><i class="icon-file-alt"></i><span class="hidden-tablet"> Add New</span></a></li>
								<li><a class="submenu" href="<?php echo DIR.'page/allpages'; ?>"><i class="icon-file-alt"></i><span class="hidden-tablet"> All Pages</span></a></li>
						</ul>
						</li>
						<li><a class="dropmenu"  href="javascript:;"><i class="icon-bar-chart"></i><span class="hidden-tablet"> Category</span></a>
							<ul>
								<li><a class="submenu" href="<?php echo DIR.'category'; ?>"><i class="icon-bar-chart"></i><span class="hidden-tablet"> View</span></a></li>	
								<li><a class="submenu" href="<?php echo DIR.'category/item'; ?>"><i class="icon-bar-chart"></i><span class="hidden-tablet"> Add</span></a></li>	
							</ul>
						</li>
						<li><a class="dropmenu"  href="javascript:;"><i class="icon-bar-chart"></i><span class="hidden-tablet"> Posts</span></a>
						<ul>
								<li>
								<!-- <a class="submenu" href="<?php echo DIR.'post'; ?>"><i class="icon-file-alt"></i><span class="hidden-tablet"> View</span></a> -->
								 <div class="control-group">
								<label class="control-label" style="color: #fff" >View By Category</label>
								<div class="controls">
									<select name="SelectPOSTURL">
									<option>Select Module</option>
										 <?php $modules = Category::module(); foreach($modules as $grp){ ?>
											<option	value="<?php echo DIR.'post/'.$grp->category_slug.'/'.$grp->category_title; ?>"><?php echo $grp->category_slug; ?></option>
										 <?php } ?>
								  </select>
								</div>
							  </div>

								</li>
								<li>


								 <div class="control-group">
								<label class="control-label" style="color: #fff" >Add Post</label>
								<div class="controls">
									<select name="SelectURL">
									<option>Select Module</option>
										 <?php $modules = Category::module(); foreach($modules as $grp){ ?>
											<option	value="<?php echo DIR.'post/add/'.$grp->category_slug; ?>"><?php echo $grp->category_slug; ?></option>
										 <?php } ?>
								  </select>
								</div>
							  </div>


							  <!-- <a class="submenu" href="<?php echo DIR.'post/add'; ?>"><i class="icon-file-alt"></i><span class="hidden-tablet"> Add</span></a></li> -->
						</ul>
						</li>
						
						<li><a class="dropmenu"  href="javascript:;"><i class="icon-bar-chart"></i><span class="hidden-tablet"> SMS</span></a>
							<ul>
								<li><a class="submenu" href="<?php echo DIR.'sms/view'; ?>"><i class="icon-bar-chart"></i><span class="hidden-tablet"> View</span></a></li>	
								<li><a class="submenu" href="<?php echo DIR.'sms'; ?>"><i class="icon-bar-chart"></i><span class="hidden-tablet"> Send</span></a></li>	
								<li><a class="submenu" href="<?php echo DIR.'sms/add'; ?>"><i class="icon-bar-chart"></i><span class="hidden-tablet"> Add</span></a></li>	
								<li><a class="submenu" href="<?php echo DIR.'sms/group'; ?>"><i class="icon-bar-chart"></i><span class="hidden-tablet"> Groups</span></a></li>	
							</ul>
						</li>
						<li><a class="dropmenu"  href="javascript:;"><i class="icon-bar-chart"></i><span class="hidden-tablet"> Newsletter</span></a>
							<ul>
								<li><a class="submenu" href="javascript:;"><i class="icon-bar-chart"></i><span class="hidden-tablet"> Send Newsletter</span></a></li>	
								<li><a class="submenu" href="<?php echo DIR.'newsletter/page'; ?>"><i class="icon-bar-chart"></i><span class="hidden-tablet"> View Pages</span></a></li>	
								<li><a class="submenu" href="<?php echo DIR.'newsletter/createpage'; ?>"><i class="icon-bar-chart"></i><span class="hidden-tablet"> Create Page</span></a></li>	
							</ul>
						</li>
					
						

						
						<li><a href="javascript:;>" class="dropmenu"><i class="icon-bar-chart"></i><span class="hidden-tablet"> Album</span></a>
							<ul>
								<li><a class="submenu" href="<?php echo DIR.'album'; ?>"><i class="icon-bar-chart"></i><span class="hidden-tablet"> View</span></a></li>	
								<li><a class="submenu" href="<?php echo DIR.'album/video'; ?>"><i class="icon-bar-chart"></i><span class="hidden-tablet"> Videos</span></a></li>	
								<li><a class="submenu" href="<?php echo DIR.'album/image'; ?>"><i class="icon-bar-chart"></i><span class="hidden-tablet"> Image</span></a></li>	
							</ul>
						</li>	
						<!-- <li><a href="<?php echo DIR.'media'; ?>"><i class="icon-bar-chart"></i><span class="hidden-tablet"> Media</span></a></li>	 -->
						<!-- <li><a href="<?php echo DIR.'media/filemanager'; ?>"><i class="icon-bar-chart"></i><span class="hidden-tablet"> File Manager</span></a></li>	 -->
						<!-- <li><a href="<?php echo DIR.'plugins'; ?>"><i class="icon-bar-chart"></i><span class="hidden-tablet"> Plugins</span></a></li>	 -->
						<li><a class="submenu"  href="<?php echo DIR.'site/settings'; ?>"><i class="icon-bar-chart"></i><span class="hidden-tablet"> Site Settings</span></a>
						</li>	

						
					</ul>
				</div>
			</div>
			<!-- end: Main Menu -->
			
			<noscript>
				<div class="alert alert-block span10">
					<h4 class="alert-heading">Warning!</h4>
					<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" 
					target="_blank">JavaScript</a> enabled to use this site.</p>
				</div>
			</noscript>

			<?php 
			// echo $success;
			// if(null !== \helpers\session::get('success')){
			// 	$success = \helpers\session::get('success'); 
			// }
			$sm = \helpers\session::get('success');
			// var_dump($sm);

			if(isset($sm) && $sm != '' && !empty($sm)){
				$success = $sm;
			}
			?>

			<?php if(isset($success) && $success != ''){ 

			 ?>
				<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert">×</button>
							<strong>Success!</strong> <?php echo $success; ?>
						</div>
			<?php } else if(isset($error) && $error != '') { ?>
			<div class="alert alert-error">
							<button type="button" class="close" data-dismiss="alert">×</button>
							<strong>Error!</strong><br>
							 <?php if(is_array($error)){

							 		foreach ($error as $key => $value) {
							 			echo $key + 1;
							 			echo '. '.$value.'<br>';
							 		}
							 	} else {
							 			echo $error;
							 		}  
							 	?>
						</div>

			<?php } ?>




			