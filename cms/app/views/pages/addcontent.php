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
				<li><a href="javascript:;">Content</a></li>
			</ul>



			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon white edit"></i><span class="break"></span>Map Pages</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
						  <fieldset>
							<!-- <div class="control-group">
							  <label class="control-label" for="typeahead">Auto complete </label>
							  <div class="controls">
								<input type="text" class="span6 typeahead" id="typeahead"  data-provide="typeahead" data-items="4" data-source='["Alabama","Alaska","Arizona","Arkansas","California","Colorado","Connecticut","Delaware","Florida","Georgia","Hawaii","Idaho","Illinois","Indiana","Iowa","Kansas","Kentucky","Louisiana","Maine","Maryland","Massachusetts","Michigan","Minnesota","Mississippi","Missouri","Montana","Nebraska","Nevada","New Hampshire","New Jersey","New Mexico","New York","North Dakota","North Carolina","Ohio","Oklahoma","Oregon","Pennsylvania","Rhode Island","South Carolina","South Dakota","Tennessee","Texas","Utah","Vermont","Virginia","Washington","West Virginia","Wisconsin","Wyoming"]'>
								<p class="help-block">Start typing to activate auto complete!</p>
							  </div>
							</div> -->
							

							 <!-- <div class="control-group">
								<label class="control-label" for="selectError3">Page Name</label>
								<div class="controls">
								<input type="text" name="pagename" class="input-xlarge" value="<?php echo $page_data->pagename; ?>">

								</div>
							  </div> -->

							  <div class="control-group">
								<label class="control-label" for="selectError3">Name Of Page: </label>
								<div class="controls">
								  <select name="page_id">
								  	<option value="">---Select Page---</option>
								  <?php foreach($pages as $item){ ?>
									<option value="<?php echo $item->id; ?>"><?php echo $item->pagename; ?></option>
								  <?php } ?>
									</select>
								</div>
							  </div>


							  <div class="control-group">
								<label class="control-label" for="selectError3">Page is a sub-link to: </label>
								<div class="controls">
								  <select name="subto">
								  	<option value="">---Select Page---</option>
								 <?php foreach($pages as $item){ ?>
									<option value="<?php echo $item->id; ?>"><?php echo $item->pagename; ?></option>
								 <?php } ?>
									</select>
								</div>
							  </div>

							  <div class="control-group hidden-phone">
							  <label class="control-label" for="textarea2">Content</label>
							  <div class="controls">
								<!-- <textarea class="tinymce" name="content" id="textarea2" rows="10"><?php echo $album_item->description; ?></textarea> -->
							  <textarea class="cleditor" required="required" name="content"><?php echo $album_item->description; ?></textarea>
							  	
							  </div>
							</div>

							  <div class="control-group">
							  <label class="control-label" for="date01">Sort Order</label>
							  <div class="controls">
								<input type="text" name="sort_order" class="input-xlarge" value="<?php echo $page_data->sort_order; ?>" >
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
	
	