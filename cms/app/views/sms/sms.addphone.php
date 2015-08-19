
			
			<!-- start: Content -->
			<div id="content" class="span10">
			
			
			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="<?php echo DIR.'dashboard'; ?>">Home</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li><a href="<?php echo DIR.'sms'; ?>">SMS</a></li>
			</ul>



			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon white edit"></i><span class="break"></span>Add Record</h2>
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
							  <label class="control-label" for="date01">Select Group</label>
							  <div class="controls">
							  <select name="group_id">
							  	<option value="">----</option>
							  	<?php foreach($groups as $item){ ?>
							  	<option value="<?php echo $item->id; ?>" <?php if($smsdata->group_id == $item->id){ ?> selected="selected" <?php } ?> ><?php echo $item->title; ?></option>
							  	<?php } ?>
							  </select>
							  </div>
							</div>
							
							<div class="control-group">
								<p>Single Record</p>
							</div>
							
							<div class="control-group">
							  <label class="control-label" for="date01">Firstname</label>
							  <div class="controls">
								<input type="text" name="firstname" required class="input-xlarge" value="<?php echo $smsdata->firstname; ?>" 
								placeholder="Firstname">
							  </div>
							</div>

							<div class="control-group">
							  <label class="control-label" for="date01">Lastname</label>
							  <div class="controls">
								<input type="text" name="lastname" required class="input-xlarge" value="<?php echo $smsdata->lastname; ?>" 
								placeholder="Lastname">
							  </div>
							</div>

							<div class="control-group">
							  <label class="control-label" for="date01">Phone</label>
							  <div class="controls">
								<input type="text" name="phone" required class="input-xlarge" value="<?php echo $smsdata->phone; ?>" 
								placeholder="Phone">
							  </div>
							</div>

							<div class="control-group"><p>Upload Multiple Record(Excel)</p></div>


							<div class="control-group">
								<label class="control-label" for="selectError3"></label>
								<div class="controls">
									<input type="file" name="excel"><br>
								</div>
							  </div>

							<div class="form-actions">
							  <button type="submit" class="btn btn-primary">Save/Upload</button>
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
	
	