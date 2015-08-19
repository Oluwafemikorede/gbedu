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
				<li><a href="javascript:;">Edit Page</a></li>
			</ul>



			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon white edit"></i><span class="break"></span>Edit</h2>
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
								<label class="control-label" for="selectError3">Page Name</label>
								<div class="controls">
								<input type="text" name="pagename" class="input-xlarge" value="<?php echo $page_data->page_name; ?>">

								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label" for="selectError3">Category</label>
								<div class="controls">
								  <select name="category">
								  <?php foreach($page_categories as $item){ ?>
									<option value="<?php echo $item->category_id; ?>" <?php if($page_data->page_category_id == $item->category_id){ echo "selected='selected'"; } ?>><?php echo $item->category_title; ?></option>
								  <?php } ?>
									</select>
								</div>
							  </div>



							 <div class="control-group">
								<label class="control-label" for="selectError3">Parent</label>
								<div class="controls">
								  <select name="parent_page">
								  <option value="">----</option>
								  <?php foreach($parent_page as $item){ ?>
									<option value="<?php echo $item->page_id; ?>" <?php if($page_data->page_id == $item->page_id){ echo "selected='selected'"; } ?>><?php echo $item->page_name; ?></option>
								  <?php } ?>
									</select>
								</div>
							  </div>


							  <!-- <div class="control-group">
							  <label class="control-label" for="textarea2">Content</label>
							  <div class="controls">
								<textarea name="content" class="cleditor" id="textarea2" rows="3"><?php echo $page_data->page_content_content; ?></textarea>
							  </div>
							</div> -->



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
	
	