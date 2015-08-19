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
									  <th>Media Type</th>
									  <th>Media Name</th>
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
									<td class="center"><?php echo $item->media_title; ?></td>
									<td class="center"><?php echo $item->media_description; ?></td>
									<td class="center">
									<?php if($item->category_title == 'image'){ 
										echo Assets::image($item->media_file,'','width: 200px');
										} else {
											if(Assets::media($item->media_file) == true){
												echo "<a href='".ROOT_DIR.$item->media_file."' target='_blank'>View in Browser</a>";
											} else {
												echo 'File does not exist';
											}
									 } 
									 ?>
									</td>
									<td class="center"><?php echo date("d/m/Y",$item->media_created); ?></td>
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
								<li><a href="<?php echo DIR.'album/edit/'.$item->media_id; ?>">
								<i class="halflings-icon  tag"></i> Edit Record</a></li>
									<?php 
									if($item->status_title == 'active') {
											$status_url = DIR.'album/status/deactivate/'.$item->media_id;
											$status_text = 'De-activate';
										} else {
											$status_url = DIR.'album/status/activate/'.$item->media_id;
											$status_text = 'Activate';
									}
								?>
								<li><a href="<?php echo $status_url; ?>" onclick="return confirm('Are you sure?')">
								<i class="halflings-icon  tag"></i> <?php echo $status_text; ?></a></li>
								<li><a 
								href="<?php echo DIR.'album/delete/media/'.$item->media_id; ?>"
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


				<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon white edit"></i><span class="break"></span>Add Item</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
						  <fieldset>

							 <div class="control-group">
								<label class="control-label" for="selectError3">Media Type</label>
								<div class="controls">
								  <select name="category" required>
									<option value="">---Pick media type---</option>
								  	<?php foreach($category as $item){ ?>
									<option value="<?php echo $item->category_id; ?>"><?php echo $item->category_title; ?></option>
									<?php } ?>
									</select>
								</div>
							  </div>

							<div class="control-group">
								<label class="control-label" for="selectError3">Artist</label>
								<div class="controls">
								  <select name="artist" required>
									<option value="">---Attach Artist---</option>
								  	<?php foreach($artist as $item){ ?>
									<option value="<?php echo $item->user_id; ?>"><?php echo $item->user_stagename; ?></option>
									<?php } ?>
									</select>
								</div>
							  </div>


							 <div class="control-group">
								<label class="control-label" for="selectError1">Tag Music</label>
								<div class="controls">
								  <select id="selectError1" multiple data-rel="chosen">
									<option>Option 1</option>
									<option selected>Option 2</option>
									<option>Option 3</option>
									<option>Option 4</option>
									<option>Option 5</option>
								  </select>
								</div>
							  </div>

							<div class="control-group">
							  <label class="control-label" for="date01">Title</label>
							  <div class="controls">
								<input type="text" name="title" class="input-xlarge" id="date01" value="" placeholder="Add Album Name">
							  </div>
							</div>

							<div class="control-group">
								<label class="control-label">File Upload</label>
								<div class="controls">
								  <input type="file" name="image">
								</div>
							  </div>
							   
							<div class="control-group hidden-phone">
							  <label class="control-label" for="textarea2">Description</label>
							  <div class="controls">
								<textarea class="cleditor" name="description" id="textarea2" rows="3"></textarea>
							  </div>
							</div>


							<div class="control-group">
							  <label class="control-label" for="date01">Youtube Link</label>
							  <div class="controls">
								<input type="text" name="youtubelink" class="input-xlarge" value="" placeholder="Add Youtube Link">
							  </div>
							</div>

							<div class="control-group">
								<label class="control-label" for="selectError3">Status</label>
								<div class="controls">
								  <select name="status_id">
								  	<?php foreach($status as $item){ ?>
									<option value="<?php echo $item->status_id; ?>"><?php echo $item->status_title; ?></option>
									<?php } ?>
									</select>
								</div>
							  </div>



							<div class="form-actions">
							  <button type="submit" class="btn btn-primary">Save</button>
							  <button type="reset" class="btn">Cancel</button>
							</div>
						  </fieldset>
						</form>   

					</div>
				</div><!--/span-->

			</div><!--/row-->
    

	</div><!--/.fluid-container-->
	
			<!-- end: Content -->
		</div><!--/#content.span10-->
		</div><!--/fluid-row-->
		
	
	
	<div class="clearfix"></div>
	
	