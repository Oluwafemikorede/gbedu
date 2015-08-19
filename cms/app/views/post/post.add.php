<?php

use Helpers\Assets;
use Helpers\Url;
use Helpers\Session;
use Helpers\Document;
use Helpers\Hooks;
use Models\Category;

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
					<a href="<?php echo DIR.'post'; ?>">Post</a>
					<i class="icon-angle-right"></i>
				</li>
				<li>
					<a href="javascript:;">Add</a>
				</li>
			</ul>



			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon white edit"></i><span class="break"></span>Add Post</h2>
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
								<label class="control-label" for="selectError2">Post Category</label>
								<div class="controls">
									<select name="post_category_id" data-placeholder="Select Category" id="selectError2" data-rel="chosen">
										<!-- <option value=""></option> -->
										 <?php foreach($post_category as $item){ ?>
													<option <?php if($item->category_id == $post->post_category_id){ echo "selected='selected'"; } ?> 
													value="<?php echo $item->category_id; ?>"><?php echo $item->category_title; ?></option>
										 <?php } ?>
										
								  </select>
								</div>
							  </div>

							 <div class="control-group">
								<label class="control-label" for="selectError3">Post Title</label>
								<div class="controls">
								<input type="text" name="post_title" class="input-xlarge" value="<?php echo $post->post_title; ?>">

								</div>
							  </div>




							<div class="control-group">
							  <label class="control-label" for="textarea2">Excerpt</label>
							  <div class="controls">
								<textarea name="post_excerpt" class="cleditor" id="textarea2" rows="3"><?php echo $post->post_excerpt; ?></textarea>
							  </div>

							</div>


							  <div class="control-group">
							  <label class="control-label" for="textarea2">Body</label>
							  <div class="controls">
								<textarea name="post_body" class="cleditor" id="textarea2" rows="3"><?php echo $post->post_body; ?></textarea>
							  </div>
							</div>

							<div class="control-group">
								<label class="control-label" for="selectError3">Link</label>
								<div class="controls">
									<input type="text" name="post_link" class="span6" value="<?php echo $post->post_link; ?>">
								</div>
							</div>
 


							  <div class="control-group">
								<label class="control-label" for="selectError3">Post Image</label>
								<div class="controls">
								<input type="file" name="image"><br>
								<?php if($post->post_image != ''){ ?>
									<img src="<?php echo Assets::image($post->post_image); ?>" width="100" >
								<?php } ?>
								</div>
							  </div>
									

							  


							 

							


							  <div class="control-group">
								<label class="control-label" for="selectError3">Post Album</label>
								<div class="controls">
								<select name="post_album_id" data-placeholder="Select Album">
										<option value="">----</option>
									<?php foreach($album_group as $alb){ ?>
										<option <?php if($alb->album_id == $post->post_album_id){ echo "selected='selected'"; } ?> value="<?php echo $alb->album_id; ?>"><?php echo $alb->album_name; ?></option>
									<?php } ?>
								</select>
								</div>
							  </div>



							  <strong>POST SEO</strong><hr>

							  <div class="control-group">
								<label class="control-label">Meta Keywords</label>
								<div class="controls">
								<input type="text" name="meta_keywords" class="span6" value="<?php echo $page_data->page_content_meta_keywords; ?>">
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label">Meta Title</label>
								<div class="controls">
								<input type="text" name="meta_title" class="span6" value="<?php echo $page_data->page_content_meta_title; ?>">
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
	
	