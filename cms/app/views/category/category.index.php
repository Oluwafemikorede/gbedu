<?php

use Helpers\Assets;
use Helpers\Url;
use Helpers\Session;
use Helpers\Document;
use Helpers\Hooks;

//initialise hooks
$hooks = Hooks::get();
?>			<div id="content" class="span10">
			
			
			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="<?php echo DIR.'dashboard'; ?>">Home</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li><a href="javascript:;">Post</a></li>
			</ul>


			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon white user"></i><span class="break"></span>Media Items</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <!-- <th>User</th> -->
								  <!-- <th>Section</th> -->
								  <th>Category</th>
								  <th>Group</th>
								  <!-- <th>Title</th> -->
								  <!-- <th>Excerpt</th> -->
								  <!-- <th>Image</th> -->
								  <th>Actions</th>
							  </tr>
						  </thead>   
						  <tbody>
						   <?php foreach($category as $item){ ?>
							<tr>
								<td class="center"><?php echo $item->category_title; ?></td>
								<td class="center"><?php echo $item->category_slug; ?></td>
								<td class="center">
									<div class="btn-group">
							<button class="btn btn-small">Option</button>
							<button class="btn btn-small dropdown-toggle" data-toggle="dropdown">
							<span class="caret"></span></button>
							<ul class="dropdown-menu">
								<li><a href="<?php echo DIR.'category/edit/'.$item->category_id; ?>"><i class="halflings-icon  tag"></i> Edit Record</a></li>
								<li><a href="<?php echo DIR.'category/delete/'.$item->category_id; ?>" onclick="return confirm('Are you sure?');"><i class="halflings-icon  download-alt"></i> Delete</a></li>
							</ul>
						</div>
								</td>
							</tr>
						<?php } ?>
							
						  </tbody>
					  </table>  

					  <?php echo $page_links; ?> 

					</div>
				</div><!--/span-->
			
			</div><!--/row-->
			
			
			


				
    

	</div><!--/.fluid-container-->
	
			<!-- end: Content -->
		</div><!--/#content.span10-->
		</div><!--/fluid-row-->
		
	<div class="modal hide fade" id="myModal">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">×</button>
			<h3>Settings</h3>
		</div>
		<div class="modal-body">
			<p>Here settings can be configured...</p>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn" data-dismiss="modal">Close</a>
			<a href="#" class="btn btn-primary">Save changes</a>
		</div>
	</div>
	
	<div class="clearfix"></div>
	
	