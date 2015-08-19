
			
			<!-- start: Content -->
			<div id="content" class="span10">
			
			
			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="<?php echo DIR.'dashboard'; ?>">Home</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li><a href="javascript:;">Add Newsletter Page</a></li>
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
								<label class="control-label" for="selectError3">Page Title</label>
								<div class="controls">
								<input type="text" name="title" class="span6" value="<?php echo $page_data->title; ?>">

								</div>
							  </div>

							   <div class="control-group">
								<label class="control-label">Author</label>
								<div class="controls">
								<input type="text" name="author" class="span6" value="<?php echo $page_data->author; ?>">
								</div>
							  </div>

							
							  <div class="control-group">
							  <label class="control-label" for="textarea2">Content</label>
							  <div class="controls">
								<textarea name="content" class="tinymce" id="textarea2" rows="5"><?php echo $page_data->content; ?></textarea>
							  </div>
							</div>

														<div class="control-group">
								<label class="control-label" for="selectError3">Image</label>
								<div class="controls">
									<input type="file" name="image"><br>
									<img src="<?php echo PIC_PATH.$page_data->image; ?>" width="100" >
								</div>
							  </div>


							  <strong>SEARCH ENGINE OPTIMIZATION</strong><hr>
							  <div class="control-group">
								<label class="control-label">Meta Keywords</label>
								<div class="controls">
								<input type="text" name="meta_keywords" class="span6" value="<?php echo $page_data->meta_keywords; ?>">
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label">Meta Title</label>
								<div class="controls">
								<input type="text" name="meta_title" class="span6" value="<?php echo $page_data->meta_title; ?>">
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label">Meta Description</label>
								<div class="controls">
								<input type="text" name="meta_description" class="span6" value="<?php echo $page_data->meta_description; ?>">
								<small>Not longer than 160 characters</small>

								</div>
							  </div>

							  <div class="control-group">
							  <label class="control-label" for="date01">Sort Order</label>
							  <div class="controls">
								<input type="text" name="sort_order" class="input-xlarge" value="<?php echo $page_data->sort_order; ?>" >
							  </div>
							</div>

							<div class="control-group">
							  <label class="control-label" for="date01">Page URL</label>
							  <div class="controls">
								<input type="text" class="input-xlarge" disabled value="<?php echo DIR.'cq/'.$page_data->slug; ?>" >
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
	
		</div><!--/#content.span10-->
		</div><!--/fluid-row-->
		
	<div class="clearfix"></div>
	
	