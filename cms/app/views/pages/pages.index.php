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
				<li><a href="javascript:;">Add Pages</a></li>
			</ul>



			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon white edit"></i><span class="break"></span>Add Page</h2>
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


							  <div class="control-group">
							  <label class="control-label" for="textarea2">Content</label>
							  <div class="controls">
								<textarea name="content" class="cleditor" id="textarea2" rows="3"><?php echo $page_data->page_content_content; ?></textarea>
							  </div>
							</div>

														<div class="control-group">
								<label class="control-label" for="selectError3">Banner</label>
								<div class="controls">
									<!-- <input type="text" name="image1" class="span6" value="<?php echo $page_data->page_content_image1; ?>"> -->
									<input type="file" name="image1_extra"><br>
									<?php echo Assets::image($page_data->page_content_image1); ?>
									<!-- <img src="<?php //echo PIC_PATH.$page_data->page_content_image1; ?>" width="100" > -->
								</div>
							  </div>



							  <div class="control-group">
								<label class="control-label" for="selectError3">Thumbnail</label>
								<div class="controls">
								<!-- <input type="text" name="image2" class="span6" value="<?php echo $page_data->page_content_image2; ?>"> -->
								<input type="file" name="image2_extra"><br>
									<?php echo Assets::image($page_data->page_content_image2); ?>

									<!-- <img src="<?php //echo PIC_PATH.$page_data->page_content_image2; ?>" width="100" > -->

								</div>
							  </div>


							  <div class="control-group">
								<label class="control-label">Homepage</label>
								<div class="controls">
								  <label class="checkbox inline">
									<input type="checkbox" name="homepage" value="0" <?php if($page_data->page_content_homepage != 0){ echo "checked"; } ?> >
									Article on homepage
									</label>
								  <!-- <div style="clear:both"></div> -->
								  <label class="checkbox inline">
									<input type="checkbox" name="header_menu" value="1" <?php if($page_data->page_content_header_menu != 0){ echo "checked"; } ?>>
									Not on Header Menu
								  </label>

								  <label class="checkbox inline">
									<input type="checkbox" name="footer_menu" value="1" <?php if($page_data->page_content_footer_menu != 0){ echo "checked"; } ?>>
									Not on Footer Menu
								  </label>
								</div>
							  </div>
							  


							  <div class="control-group">
								<label class="control-label" for="selectError3">Redirect URL</label>
								<div class="controls">
								<input type="text" name="redirecturl" class="span6" value="<?php echo $page_data->page_content_redirecturl; ?>">
								</div>
							  </div>


							  <!-- <div class="control-group">
								<label class="control-label" for="selectError3">Album</label>
								<div class="controls">
								<input type="text" name="album" class="span6" value="<?php echo $page_data->page_content_album; ?>">
								</div>
							  </div> -->

							  <div class="control-group">
								<label class="control-label" for="selectError3">Album</label>
								<div class="controls">
								<select name="album" data-placeholder="Select Album">
										<option value="">----</option>
									<?php foreach($album_group as $alb){ ?>
										<option <?php if($alb->album_id == $page_data->page_content_album){ echo "selected='selected'"; } ?> value="<?php echo $alb->album_id; ?>"><?php echo $alb->album_name; ?></option>
									<?php } ?>
								</select>
								</div>
							  </div>



							  <strong>SEARCH ENGINE OPTIMIZATION</strong><hr>

							  <div class="control-group">
								<label class="control-label">Meta Keywords</label>
								<div class="controls">
								<input type="text" name="meta_keywords" class="span6" value="<?php echo $page_data->page_content_meta_keywords; ?>">
								<!-- <input type="file" name="image2_extra"> -->

								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label">Meta Title</label>
								<div class="controls">
								<input type="text" name="meta_title" class="span6" value="<?php echo $page_data->page_content_meta_title; ?>">
								<!-- <input type="file" name="image2_extra"> -->

								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label">Meta Description</label>
								<div class="controls">
								<input type="text" name="meta_description" class="span6" value="<?php echo $page_data->page_content_meta_description; ?>">
								<small>Not longer than 160 characters</small>

								</div>
							  </div>

							  <div class="control-group">
							  <label class="control-label" for="date01">Sort Order</label>
							  <div class="controls">
								<input type="text" name="sort_order" class="input-xlarge" value="<?php echo $page_data->page_content_sort_order; ?>" >
							  </div>
							</div>

							<div class="control-group">
							  <label class="control-label" for="date01">Slug</label>
							  <div class="controls">
								<input type="text" class="input-xlarge" value="<?php echo $page_data->page_alias; ?>" >
							  </div>
							</div>



							<!-- <div class="control-group">
								<label class="control-label">File Upload</label>
								<div class="controls">
								  <input type="file" name="image">
								</div>
							  </div>
 -->

							<div class="form-actions">
							  <button type="submit" class="btn btn-primary">Save</button>
							  <button type="reset" class="btn">Cancel</button>
							</div>
						  </fieldset>
						</form>   

					</div>
				</div><!--/span-->

			</div><!--/row-->







			
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon white user"></i><span class="break"></span>Pages</h2>
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
								  <th>Page Title</th>
								  <th>Category</th>
								  <th>Sort Order</th>
								  <th>Page Alias</th>
								  <!-- <th>Date</th> -->
								  <th>Actions</th>
							  </tr>
						  </thead>   
						  <tbody>
						   <?php foreach($pages as $item){ ?>
							<tr>
								<td><?php echo $item->page_name; ?></td>
								<td class="center"><?php echo $item->category_title; ?></td>
								<td class="center"><?php echo $item->page_sort_order; ?></td>
								<td class="center"><?php echo $item->page_alias; ?></td>
								
								<td class="center">
									<div class="btn-group">
							<button class="btn btn-small">Option</button>
							<button class="btn btn-small dropdown-toggle" data-toggle="dropdown">
							<span class="caret"></span></button>
							<ul class="dropdown-menu">
								<li><a href="<?php echo DIR.'page/edit/'.$item->page_id; ?>">
								<i class="halflings-icon  tag"></i> Edit Record</a></li>
								<li><a 
								href="<?php echo DIR.'page/delete/'.$item->page_id; ?>"
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
	
	