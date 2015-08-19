<?php

use Helpers\Assets;
use Helpers\Url;
use Helpers\Session;
use Helpers\Document;
use Helpers\Hooks;

use Models\Song;
use Models\Playlist;

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
				<li><a href="#">Album/Playlist</a></li>
			</ul>


				<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon white edit"></i><span class="break"></span> Add </h2>
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
							  <label class="control-label" for="date01">Album Name</label>
							  <div class="controls">
								<input type="text" name="title" class="input-xlarge" id="date01" value="<?php echo $album_data->album_title; ?>" placeholder="Add Album Name">
							  </div>
							</div>
							<div class="control-group hidden-phone">
							  <label class="control-label" for="textarea2">Description</label>
							  <div class="controls">
								<textarea name="description" value="<?php echo $album_data->album_description; ?>" class="input-xlarge" id="textarea2" rows="3"></textarea>
							  </div>
							</div>

							<div class="control-group">
								<label class="control-label">Cover Photo</label>
								<div class="controls">
								  <input type="file" name="image">
								</div>
								<div class="controls">
									<?php //echo Assets::image($item->album_image,'','width: 120px'); ?>
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
			
			
			
			<div class="row-fluid sortable">	
				<div class="box span12">
					<div class="box-header">
						<h2><i class="halflings-icon white align-justify"></i><span class="break"></span>Playlists</h2>
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
									  <th>Title</th>
									  <th>Description</th>
									  <th>Cover</th>
									  <th>Type</th>
									  <th>Slug</th>
									  <th>Song Count</th>
									  <th>Date</th>
									  <th>Status</th>                                          
									  <th>Actions</th>                                          
								  </tr>
							  </thead>   
							  <tbody>

							  <?php foreach($albums as $item){ ?>
								<tr>
									<td class="center"><?php echo $item->album_name; ?></td>
									<td class="center"><?php echo $item->album_description; ?></td>
									<td class="center"><?php echo Assets::image($item->album_image,'','height: 80px'); ?></td>
									<td class="center"><?php echo $item->category_title; ?></td>
									<td class="center"><?php echo $item->album_slug; ?></td>
									<td class="center"><?php echo Playlist::itemCount($item->album_id); ?></td>
									<td class="center"><?php echo date('d/m/Y',$item->album_created); ?></td>
									<td class="center"><span class="label label-success">Active</span></td> 
									<td class="center">
									<div class="btn-group">
							<button class="btn btn-small">Option</button>
							<button class="btn btn-small dropdown-toggle" data-toggle="dropdown">
							<span class="caret"></span></button>
							<ul class="dropdown-menu">
								<li><a href="<?php echo DIR.'song/editalbum/'.$item->album_id; ?>"><i class="halflings-icon  tag"></i> Edit <?php echo ucfirst($item->category_title); ?></a></li>
								<?php 
								if($item->category_title == 'playlist'){ 
									$songUrl = DIR.'song/tagplaylist/'.$item->album_id;
								} else {
									$songUrl = DIR.'song/item/'.$item->album_id;
								}
								 ?>
								<li><a href="<?php echo $songUrl; ?>"><i class="halflings-icon  star"></i> Manage Songs</a></li>
								<li><a href="<?php echo DIR.'song/delete/album/'.$item->album_id; ?>" onclick="return confirm('Are you sure?');"><i class="halflings-icon  download-alt"></i> Delete</a></li>
								
								<!-- <li><a href="#"><i class="halflings-icon white tint"></i> Separated link</a></li> -->
							</ul>
						</div>
								</td>                                      
								</tr>
								<?php } ?>
								                        
							  </tbody>
						 </table>  
						<?php echo $pageLinks; ?>
					</div>
				</div><!--/span-->
			</div><!--/row-->

		


			
    

	</div><!--/.fluid-container-->
	
			<!-- end: Content -->
		</div><!--/#content.span10-->
		</div><!--/fluid-row-->
		
	<div class="clearfix"></div>
	
	