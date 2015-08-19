
			
			<!-- start: Content -->
			<div id="content" class="span10">
			
			
			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="<?php echo DIR.'dashboard'; ?>">Home</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li><a href="javascript:;">SMS</a></li>
			</ul>



			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon white edit"></i><span class="break"></span>SMS</h2>
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
								<label class="control-label" for="selectError3">SMS Group: </label>
								<div class="controls">
								  <select name="group_id">
								  	<option value="">---</option>
								  <?php foreach($groups as $item){ ?>
									<option value="<?php echo $item->id; ?>"><?php echo $item->title; ?></option>
								  <?php } ?>
									</select>
								</div>
							  </div>

							<!--    <div class="control-group hidden-phone">
							  <label class="control-label" for="textarea2">Subject</label>
							  <div class="controls">
								<input class="span6" name="subject" value="" placeholder="Mail Subject">
							  </div>
							</div> -->

							<!-- <div class="control-group">
							  <label class="control-label" for="date01">Subject</label>
							  <div class="controls">
								<input type="text" name="subject" class="input-xlarge" value="" placeholder="Mail Subject" >
							  </div>
							</div>
 -->
							  
							  <div class="control-group hidden-phone">
							  <label class="control-label" for="textarea2">Message</label>
							  <div class="controls">
								<textarea name="content" id="textarea2" rows="3" class="span6 textcounter"></textarea>
									<div id="showData"></div>

							  </div>
							</div>

							 <!--  -->
							

							<div class="form-actions">
							  <button type="submit" class="btn btn-primary">Send</button>
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
	
	