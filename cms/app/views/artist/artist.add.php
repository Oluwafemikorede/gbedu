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
					<a href="<?php echo DIR.'artist'; ?>">Home</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li><a href="javascript:;">Artist</a></li>
			</ul>


				<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon white edit"></i><span class="break"></span>Add Artist</h2>
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
							  <label class="control-label" for="date01">Original Name</label>
							  <div class="controls">
								<input type="text" name="firstname" required="required" class="input-xlarge" value="<?php echo $user_data->user_firstname; ?>">
							  </div>
							</div>


							<div class="control-group hidden-phone">
							  <label class="control-label" for="textarea2">Stage Name</label>
							  <div class="controls">
								<input type="text" required="required" name="stagename" class="input-xlarge" value="<?php echo $user_data->user_stagename; ?>">
							  </div>
							</div>


							<div class="control-group hidden-phone">
							  <label class="control-label" for="textarea2">Twitter Handle</label>
							  <div class="controls">
								<input type="text" required name="twitter_handle" class="input-xlarge" value="<?php echo $user_data->twitter_handle; ?>">
							  </div>
							</div>

							<div class="control-group hidden-phone">
							  <label class="control-label" for="textarea2">Gender</label>
							  <div class="controls">
									<select name="gender" class="form-control" >
					                  <option>Select Option</option>
					                  <option value="Male">Male</option>
					                  <option value="Female">Female</option>
					                </select>
			                  </div>

			                </div>


							<div class="control-group hidden-phone">
							  <label class="control-label" for="textarea2">Bio</label>
							  <div class="controls">
							  <textarea class="cleditor" name="bio"><?php echo $user_data->user_bio; ?></textarea>
							  </div>
							</div>



							<div class="control-group">
								<label class="control-label">Picture</label>
								<div class="controls">
								  <?php if(is_file(BASE_PATH.DS.'app/templates/default/'.$user_data->user_image)){ ?>
									<input type="file" name="image" >
								  <?php } else { ?>
								  <input type="file" name="image" required="required" >
								  <?php } ?>
								  <?php echo Assets::imageThumb($user_data->user_image,'','width: 100px'); ?>
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
	
	