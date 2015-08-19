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
				<li><a href="javascript:;">Edit Album Item</a></li>
			</ul>


			
			
			
			
			

				<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon white edit"></i><span class="break"></span>Edit Record</h2>
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
								  	<?php foreach($album_categories as $item){ ?>
									<option value="<?php echo $item->category_id; ?>" <?php if($media->media_category_id == $item->category_id){ echo 'selected="selected"'; } ?> ><?php echo $item->category_title; ?></option>
									<?php } ?>
									<!--  -->
									</select>
								</div>
							  </div>

							  <div class="control-group">
							  <label class="control-label" for="date01">Title</label>
							  <div class="controls">
								<input type="text" name="title" class="input-xlarge" value="<?php echo $media->media_title; ?>" >
							  </div>
							</div>



							<div class="control-group">
								<label class="control-label">File Upload</label>
								<div class="controls">
								  <input type="file" name="image">
								</div>
								<div class="controls">
									<?php if($media->category_title == 'image'){ 
										echo Assets::image($media->media_file,'','width: 200px');
										} else {
											if(Assets::media($media->media_file) == true){
												echo "<a href='".ROOT_DIR.$media->media_file."' target='_blank'>View in Browser</a>";
											} else {
												echo 'File does not exist';
											}
									 } 
									 ?>
								</div>
							  </div>

							   
							<div class="control-group hidden-phone">
							  <label class="control-label" for="textarea2">Description</label>
							  <div class="controls">
								<textarea class="cleditor" name="description" id="textarea2" rows="3"><?php echo $media->media_description; ?></textarea>
							  </div>
							</div>


							<div class="control-group">
							  <label class="control-label" for="date01">Youtube Link</label>
							  <div class="controls">
								<input type="text" name="youtubelink" class="input-xlarge" value="<?php echo $media->media_youtubelink; ?>" placeholder="Add Youtube Link">
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
	
	