
			
			<!-- start: Content -->
			<div id="content" class="span10">
			
			
			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="<?php echo DIR.'dashboard'; ?>">Home</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li><a href="javascript:;">Site Settings</a></li>
			</ul>


<?php if(!isset($delete_set)){  ?>
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon white edit"></i><span class="break"></span>Edit Site Settings</h2>
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
							  <label class="control-label" for="date01">Preference</label>
							  <div class="controls">
								<input type="text" name="title" class="input-xlarge" 
								value="<?php echo $site_data->site_preference; ?>" placeholder="Type Preference">
							  </div>
							</div>


							<div class="control-group">
							  <label class="control-label" for="date01">Value</label>
							  <div class="controls">
								<textarea name="value" class="input-xlarge" placeholder="Value"><?php echo $site_data->site_value; ?></textarea>
							  </div>
							</div>

							<div class="control-group">
							  <label class="control-label" for="date01">File</label>
							  <div class="controls">
								<input type="file" name="image" class="input-xlarge" >
								<?php if($site_data->site_file != ''){ ?>
									<img src="<?php echo PIC_PATH.$site_data->site_file; ?>" width="80">
								<?php } ?>
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
<?php } ?>







			
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon white user"></i><span class="break"></span>Site Settings Records</h2>
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
								  <th>Value</th>
								  <th>File/Image</th>
								  <th>Actions</th>
							  </tr>
						  </thead>   
						  <tbody>
						   <?php foreach($settings as $item){ ?>
							<tr>
								<td><?php echo $item->site_preference; ?></td>
								<td class="center"><?php echo $item->site_value; ?></td>
								<td class="center">
									<?php if($item->site_file != ''){ ?>
										<img src="<?php echo PIC_PATH.$item->site_file; ?>" width="80" >
									<?php } ?>
								</td>
								
								<td class="center">
									<div class="btn-group">
							<button class="btn btn-small">Option</button>
							<button class="btn btn-small dropdown-toggle" data-toggle="dropdown">
							<span class="caret"></span></button>
							<ul class="dropdown-menu">
									<li><a href="<?php echo DIR.'site/edit/'.$item->site_id; ?>">
								<i class="halflings-icon  tag"></i> Edit Record</a></li>
								<li><a 
								href="<?php echo DIR.'site/delete/'.$item->site_id; ?>"
								onclick="return confirm('Are you sure?');">
								<i class="halflings-icon  download-alt"></i> Delete</a></li>
							</ul>
						</div>
								</td>
							</tr>
						<?php } ?>
							
						  </tbody>
					  </table>            
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
	
	