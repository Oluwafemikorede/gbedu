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
				<a href="javascript:;">Add Song</a>
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
								<label class="control-label" for="selectError3">Artist</label>
								<div class="controls">
								  <select name="artist_id" required>
									<option value="">---Attach Artist---</option>
								  	<?php foreach($artist as $item){ ?>
									<option value="<?php echo $item->user_id; ?>"><?php echo $item->user_stagename; ?></option>
									<?php } ?>
									</select>
								</div>
							  </div>
							

							 <div class="control-group">
								<label class="control-label" for="selectError3">Genre</label>
								<div class="controls">
								  <select name="genre_id" required="required">
									<option value="">---Select Genre---</option>
								  	<?php foreach($genre as $item){ ?>
									<option value="<?php echo $item->category_id; ?>"><?php echo $item->category_title; ?></option>
									<?php } ?>
									</select>
								</div>
							  </div>



							 <div class="control-group">
								<label class="control-label" for="selectError1">Tag Music</label>
								<div class="controls">
								  <select name="tags[]" id="selectError1" multiple data-rel="chosen">
								  <?php foreach($tags as $value){?>
									<option value="<?php echo $value->category_id; ?>"><?php echo $value->category_title; ?></option>
								  <?php } ?>
								  </select>
								</div>
							  </div>

							<div class="control-group">
							  <label class="control-label" for="date01">Title</label>
							  <div class="controls">
								<input type="text" name="title" class="input-xlarge" id="date01" value="" placeholder="Add Song Title">
							  </div>
							</div>

							<div class="control-group">
								<label class="control-label">Upload Mp3</label>
								<div class="controls">
								  <input type="file" name="mp3" required="required">
								</div>
							  </div>


							<div class="control-group">
								<label class="control-label">Song Cover</label>
								<div class="controls">
								  <input type="file" name="image" required="required">
								</div>
							  </div>
							   
							<div class="control-group hidden-phone">
							  <label class="control-label" for="textarea2">Description</label>
							  <div class="controls">
								<textarea class="input-xlarge" name="description" id="textarea2" rows="5"></textarea>
							  </div>
							</div>


							<div class="control-group">
								<label class="control-label" for="selectError3">Status</label>
								<div class="controls">
								  <select name="status_id" required="required">
								  	<option value="" >---Select Status---</option>
								  	<?php foreach($status as $item){ ?>
									<option value="<?php echo $item->status_id; ?>" ><?php echo $item->status_title; ?></option>
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
	
	