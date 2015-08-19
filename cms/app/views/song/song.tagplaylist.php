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
				<a href="<?php echo DIR.'song'; ?>">Songs</a>
				<i class="icon-angle-right"></i>
				</li>
				<li>
				<a href="javascript:;">Album Songs</a>
				</li>
			</ul>


			
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
								<label class="control-label" for="selectError1">Tag Music</label>
								<div class="controls">
								  <select name="tag_songs[]" id="selectError1" multiple data-rel="chosen">
								  <?php foreach($tag_songs as $value){?>
									<option value="<?php echo $value->song_id; ?>"><?php echo $value->song_title; ?></option>
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
			
			
			<div class="row-fluid sortable">	
				<div class="box span12">
					<div class="box-header">
						<h2><i class="halflings-icon white align-justify"></i><span class="break"></span>Playlist</h2>
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
									  <th>Genre</th>
									  <th>Title</th>
									  <th>Description</th>
									  <th>Cover</th>
									  <th>File</th>
									  <th>Date</th>
									  <th>Status</th>                                          
									  <!-- <th>Actions</th>                                           -->
								  </tr>
							  </thead>   
							  <tbody>

							  <?php foreach($songs as $item){ ?>
								<tr>
									
									<td class="center"><?php echo $item->category_title; ?></td>
									<td class="center"><?php echo $item->song_title; ?></td>
									<td class="center"><?php echo $item->song_description; ?></td>
									<td class="center"><?php echo Assets::image($item->song_image,'','width: 100px'); ?></td>
									<td class="center">
									<?php if(Assets::media($item->song_file) == true){
												echo "<a href='".ROOT_DIR.$item->song_file."' target='_blank'>View in Browser</a>";
											} else {
												echo 'File does not exist';
											}
									 ?>
									</td>
									<td class="center"><?php echo date("d/m/Y",$item->song_created); ?></td>
					
									<td class="center">
									<div class="btn-group">
							<button class="btn btn-small">Option</button>
							<button class="btn btn-small dropdown-toggle" data-toggle="dropdown">
							<span class="caret"></span></button>
							<ul class="dropdown-menu">
								<li><a 
								href="<?php echo DIR.'song/untag/'.$item->song_id.'/'.$item->playlist_album_id; ?>"
								onclick="return confirm('Are you sure?');">
								<i class="halflings-icon  download-alt"></i> Remove</a></li>
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
	
	