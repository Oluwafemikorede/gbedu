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
					<a href="<?php echo DIR.'category'; ?>">Category</a>
					<i class="icon-angle-right"></i>
				</li>
				<li>
					<a href="javascript:;">Add</a>
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
						  <?php if($page_section != 'edit'){ ?>
						  	<div class="control-group">
							  <label class="control-label" for="typeahead">Category Group </label>
							  <div class="controls">
								<input type="text" name="category_slug" class="span6 typeahead" id="typeahead" data-provide="typeahead" data-items="4" 
								data-source='[
								<?php $grp_count = count($category_groups);

								$i=0;	foreach($category_groups as $item){ 
									if($i == 0){
										echo '"'.$item->category_slug.'"';
									} else {
										echo ',"'.$item->category_slug.'"';
									}
								 $i++;} 
								 ?>
								]'>
								<p class="help-block">Start typing to activate auto complete!</p>
							  </div>
							</div>
						<?php } ?>



							 <div class="control-group">
								<label class="control-label" for="selectError3">Item</label>
								<div class="controls">
								<input type="text" name="category_title" class="input-xlarge" value="<?php echo $category->category_title; ?>">

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