<?php

use Helpers\Assets;
use Helpers\Url;
use Helpers\Session;
use Helpers\Document;
use Helpers\Hooks;

//initialise hooks
$hooks = Hooks::get();
?>
			<!-- start: Content -->
			<div id="content" class="span10">
			
			
			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="<?php echo DIR.'dashboard'; ?>">Home</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li><a href="javascript:;">All Users</a></li>
			</ul>

		
			
			<div class="row-fluid sortable">	
				<div class="box span12">
					<div class="box-header">
						<h2><i class="halflings-icon white align-justify"></i>
						<span class="break"></span>Artist</h2>
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
									  <!-- <th>ID</th> -->
									  <th>Real Name</th>
									  <th>Stage Name</th>
									  <th>Twitter Handle</th>
									  <th>Image</th>                                          
									  <th>Date</th>                                          
									  <th>Action</th>                                          
								  </tr>
							  </thead>   
							  <tbody>
							  <?php foreach($artist as $item){ ?>
								<tr>
									<!-- <td class="center"></td> -->
									<td class="center"><?php echo $item->user_firstname; ?></td>
									<td class="center"><?php echo $item->user_stagename; ?></td>
									<td class="center"><?php echo $item->twitter_handle; ?></td>
									<td class="center"><?php echo Assets::imageThumb($item->user_image,'','width: 100px'); ?></td>
									<td class="center"><?php echo date('Y-m-d',$item->user_created); ?></td>
									<td class="center">
										<div class="btn-group">
							<button class="btn btn-small">Option</button>
							<button class="btn btn-small dropdown-toggle" data-toggle="dropdown">
							<span class="caret"></span></button>
							<ul class="dropdown-menu">
								<li><a href="<?php echo DIR.'artist/edit/'.$item->user_id; ?>">
								<i class="halflings-icon  tag"></i> Edit</a></li>
								<?php 
									switch ($item->status_title) {
										case 'active':
											$status_url = DIR.'artist/status/deactivate/id='.$item->user_id;
											$status_text = 'De-activate';
											break;

										case 'inactive':
											$status_url = DIR.'artist/status/activate/id='.$item->user_id;
											$status_text = 'Activate';
											break;
											
										default:
											break;
									}
							
								?>
								<li><a href="<?php echo $status_url; ?>">
								<i class="halflings-icon  tag"></i> <?php echo $status_text; ?></a></li>
								<li><a 
								href="<?php echo DIR.'artist/delete/'.$item->user_id; ?>"
								onclick="return confirm('Are you sure?');">
								<i class="halflings-icon  download-alt"></i> Delete</a></li>
							</ul>
						</div>
									</td>                                       
								</tr>
							   <?php } ?>
							  </tbody>
						 </table>  
						 <div class="pagination pagination-centered">

						 <?php echo $pageLinks; ?>

						</div>     
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
	
	