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
				<li>
				<a href="<?php echo DIR.'album'; ?>">Album</a>
				<i class="icon-angle-right"></i>
				</li>
				<li>
				<a href="javascript:;">Album Item</a>
				</li>
			</ul>


			
			
			
			
			<div class="row-fluid sortable">	
				<div class="box span12">
					<div class="box-header">
						<h2><i class="halflings-icon white align-justify"></i><span class="break"></span>Album Item</h2>
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
									  <th>Type</th>
									  <th>Name</th>
									  <th>Description</th>
									  <th>File</th>
									  <th>Date</th>
									  <th>Status</th>                                          
									  <th>Actions</th>                                          
								  </tr>
							  </thead>   
							  <tbody>

							  <?php foreach($albumitems as $item){ ?>
								<tr>
									
									<td class="center"><?php echo $item->category_title; ?></td>
									<td class="center"><?php echo $item->album_item_title; ?></td>
									<td class="center"><?php echo $item->album_item_description; ?></td>
									<td class="center">
									<?php if($item->album_item_file != ''){ ?>
										<img src="<?php echo PIC_PATH.$item->album_item_file; ?>" width="200">
									<?php } ?>
									</td>
									<td class="center"><?php echo date("F j, Y",$item->album_item_created); ?></td>
									<td class="center">

										<span class="label 
										<?php if($item->status_title == 'active'){ echo 'label-success'; } else { echo 'label-error'; } ?>">
										<?php echo $item->status_title; ?>
										</span>
									</td> 
									<td class="center">
									<div class="btn-group">
							<button class="btn btn-small">Option</button>
							<button class="btn btn-small dropdown-toggle" data-toggle="dropdown">
							<span class="caret"></span></button>
							<ul class="dropdown-menu">
								<li><a href="<?php echo DIR.'album/edit/'.$item->album_item_id; ?>">
								<i class="halflings-icon  tag"></i> Edit Record</a></li>
									<?php 
									if($item->status_title == 'active') {
											$status_url = DIR.'album/status/deactivate/'.$item->album_item_id;
											$status_text = 'De-activate';
										} else {
											$status_url = DIR.'album/status/activate/'.$item->album_item_id;
											$status_text = 'Activate';
									}
								?>
								<li><a href="<?php echo $status_url; ?>" onclick="return confirm('Are you sure?')">
								<i class="halflings-icon  tag"></i> <?php echo $status_text; ?></a></li>
								<?php 
									if($item->album_item_featured == 1) {
											$feature_url = DIR.'album/feature/unfeature/'.$item->album_item_id;
											$feature_text = 'Unfeature';
										} else {
											$feature_url = DIR.'album/feature/feature/'.$item->album_item_id;
											$feature_text = 'Feature';
									}
								?>
								<li><a href="<?php echo $feature_url; ?>" onclick="return confirm('Are you sure?')">
								<i class="halflings-icon  tag"></i> <?php echo $feature_text; ?> </a></li>
								<?php 
									if($item->album_item_featured == 2) {
											$side_feature_url = DIR.'album/feature/singlefeature/'.$item->album_item_id;
											$side_feature_text = 'Unfeature on Sidebar';
										} else {
											$side_feature_url = DIR.'album/feature/singlefeature/'.$item->album_item_id;
											$side_feature_text = 'Feature on Sidebar';
									}
								?>
								<li><a href="<?php echo $side_feature_url; ?>" onclick="return confirm('Are you sure?')">
								<i class="halflings-icon  tag"></i> <?php echo $side_feature_text; ?> </a></li>
								<li><a 
								href="<?php echo DIR.'album/deleteitem/'.$item->album_item_id; ?>"
								onclick="return confirm('Are you sure?');">
								<i class="halflings-icon  download-alt"></i> Delete</a></li>
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
		
	
	
	<div class="clearfix"></div>
	
	