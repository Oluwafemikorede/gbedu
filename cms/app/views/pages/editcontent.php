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
					<a href="<?php echo DIR.'pages/allpages'; ?>">Pages </a>
					<i class="icon-angle-right"></i>
				</li>
				<li><a href="javascript:;">Content</a></li>
			</ul>



			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon white edit"></i><span class="break"></span>Edit Page Content</h2>
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
								<label class="control-label" >Name Of Page: </label>
								<div class="controls">
								<input type="text" name="pagename" class="span6" value="<?php echo $page_data->page_name; ?>">
								</div>
							  </div>


							  <div class="control-group">
								<label class="control-label" >Page is a sub-link to: </label>
								<div class="controls">
								  <select name="subto">
								  	<option value="">---Select Page---</option>
								 <?php foreach($pages as $item){ ?>
									<option value="<?php echo $item->page_id; ?>" <?php if($page_data->content_subto == $item->page_id){ echo "selected='selected'"; } ?> ><?php echo $item->page_name; ?></option>
								 <?php } ?>
									</select>
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label" for="selectError3">Plugin</label>
								<div class="controls">
								<input type="text" name="plugin" class="span6" value="<?php echo $page_data->content_plugin; ?>">

								</div>
							  </div>


							   <div class="control-group hidden-phone">
							  <label class="control-label" for="excerpt">Excerpt</label>
							  <div class="controls">
								<textarea name="excerpt" class="tinymce" id="excerpt" rows="5"><?php echo $page_data->content_excerpt; ?></textarea>
							  <!-- <textarea class="cleditor" required="required" name="content"><?php //echo $page_data->content_content; ?></textarea> -->
							  
							  </div>
							</div>

							  <div class="control-group hidden-phone">
							  <label class="control-label" for="textarea2">Content</label>
							  <div class="controls">
								<textarea name="content" class="tinymce" id="textarea2" rows="10"><?php echo $page_data->content_body; ?></textarea>
							  <!-- <textarea class="cleditor" required="required" name="content"><?php //echo $page_data->content_content; ?></textarea> -->
							  
							  </div>
							</div>

							<div class="control-group">
								<label class="control-label" for="selectError3">Page Banner</label>
								<div class="controls">
									<!-- <input type="text" name="image1" class="span6" value="<?php echo $page_data->content_image1; ?>"> -->
									<input type="file" name="image1_extra"><br>
									<?php echo Assets::image($page_data->content_banner,'','width: 100px'); ?>

									<!-- <img src="<?php //echo PIC_PATH.$page_data->content_image1; ?>" width="100" > -->
								</div>
							  </div>



							  <div class="control-group">
								<label class="control-label" for="selectError3">Thumbnail</label>
								<div class="controls">
								<input type="file" name="image2_extra"><br>
									<?php echo Assets::image($page_data->content_thumbnail,'','width: 100px'); ?>
								</div>
							  </div>


							  <div class="control-group">
								<label class="control-label">Homepage</label>
								<div class="controls">
								  <label class="checkbox inline">
									<input type="checkbox" name="homepage" value="0" <?php if($page_data->content_homepage != 0){ echo "checked"; } ?> >
									Article on homepage
									</label>
								  <label class="checkbox inline">
									<input type="checkbox" name="header_menu" value="1" <?php if($page_data->content_header_menu != 0){ echo "checked"; } ?>>
									Not on Header Menu
								  </label>

								  <label class="checkbox inline">
									<input type="checkbox" name="footer_menu" value="1" <?php if($page_data->content_footer_menu != 0){ echo "checked"; } ?>>
									Not on Footer Menu
								  </label>
								</div>
							  </div>
							  


							  <div class="control-group">
								<label class="control-label" for="selectError3">Redirect URL</label>
								<div class="controls">
								<input type="text" name="redirecturl" class="span6" value="<?php echo $page_data->content_redirecturl; ?>">
								</div>
							  </div>


							  <div class="control-group">
								<label class="control-label" for="selectError3">Album</label>
								<div class="controls">
								<select name="album" data-placeholder="Select Album">
										<option value="">----</option>
									<?php foreach($album_group as $alb){ ?>
										<option <?php if($alb->album_id == $page_data->content_album){ echo "selected='selected'"; } ?> value="<?php echo $alb->album_id; ?>"><?php echo $alb->album_name; ?></option>
									<?php } ?>
								</select>
								</div>
							  </div>



							  <strong>SEARCH ENGINE OPTIMIZATION</strong><hr>

							  <div class="control-group">
								<label class="control-label">Meta Keywords</label>
								<div class="controls">
								<input type="text" name="meta_keywords" class="span6" value="<?php echo $page_data->content_meta_keywords; ?>">
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label">Meta Title</label>
								<div class="controls">
								<input type="text" name="meta_title" class="span6" value="<?php echo $page_data->content_meta_title; ?>">
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label">Meta Description</label>
								<div class="controls">
								<input type="text" name="meta_description" class="span6" value="<?php echo $page_data->content_meta_description; ?>">
								<small>Not longer than 160 characters</small>
								</div>
							  </div>

							  <div class="control-group">
							  <label class="control-label" for="date01">Sort Order</label>
							  <div class="controls">
								<input type="text" name="sort_order" class="input-xlarge" value="<?php echo $page_data->content_sort_order; ?>" >
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
	
	