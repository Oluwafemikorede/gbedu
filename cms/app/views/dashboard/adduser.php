			
			<!-- start: Content -->
			<div id="content" class="span10">
			
			
			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="<?php echo DIR.'dashboard'; ?>">Home</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li><a href="javascript:;">Add User</a></li>
			</ul>


			
			
			
			
			


				<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon white edit"></i><span class="break"></span>Add User</h2>
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
								<label class="control-label" for="selectError3">Select Role</label>
								<div class="controls">
								  <select name="role" required>
								  	<?php foreach($user_roles as $item){ ?>
									<option value="<?php echo $item->id; ?>" <?php if($user_data->role == $item->id){ ?> selected="selected" <?php } ?> ><?php echo $item->title; ?></option>
									<?php } ?>
									<!--  -->
									</select>
								</div>
							  </div>


							   <!--  -->

							  <div class="control-group">
							  <label class="control-label" for="date01">First Name</label>
							  <div class="controls">
								<input type="text" name="fname" class="input-xlarge" value="<?php echo $user_data->firstname; ?>">
							  </div>
							</div>


							<div class="control-group hidden-phone">
							  <label class="control-label" for="textarea2">Last Name</label>
							  <div class="controls">
								<input type="text" name="lname" class="input-xlarge" value="<?php echo $user_data->lastname; ?>">
							  </div>
							</div>



							<div class="control-group hidden-phone">
							  <label class="control-label" for="textarea2">Email</label>
							  <div class="controls">
								<input type="text" name="email"
								 class="input-xlarge" value="<?php echo $user_data->email; ?>">
							  </div>
							</div>



							<div class="control-group hidden-phone">
							  <label class="control-label" for="textarea2">Phone</label>
							  <div class="controls">
								<input type="text" name="phone"
								 class="input-xlarge" value="<?php echo $user_data->phone; ?>">
							  </div>
							</div>

							<div class="control-group">
								<label class="control-label">User Photo</label>
								<div class="controls">
								  <input type="file" name="image">
								  <img src="<?php echo PIC_PATH.$user_data->image; ?>" width="150">
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
	
	