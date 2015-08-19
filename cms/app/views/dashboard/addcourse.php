			
			<!-- start: Content -->
			<div id="content" class="span10">
			
			
			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="<?php echo DIR.'dashboard'; ?>">Home</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li>
					<a href="<?php echo DIR.'dashboard/courses'; ?>">Courses</a>
					<i class="icon-angle-right"></i>
				</li>
				<li><a href="javascript:;">Add Course</a></li>
			</ul>


			
			
			
			
			


				<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon white edit"></i><span class="break"></span>Add Course</h2>
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
								<label class="control-label" for="selectError3">Select Tutor</label>
								<div class="controls">
								  <select name="tutor_id" required>
								  	<?php foreach($tutors as $item){ ?>
									<option value="<?php echo $item->id; ?>" <?php if($course_data->tutor_id == $item->id){ ?> selected="selected" <?php } ?> ><?php echo $item->institution; ?></option>
									<?php } ?>
									<!--  -->
									</select>
								</div>
							  </div>


							   <div class="control-group">
								<label class="control-label" for="selectError3">Course Category</label>
								<div class="controls">
								  <select name="category_id" required>
								  	<?php foreach($course_category as $item){ ?>
									<option value="<?php echo $item->id; ?>" <?php if($course_data->category_id == $item->id){ ?> selected="selected" <?php } ?>  ><?php echo $item->title; ?></option>
									<?php } ?>
									<!--  -->
									</select>
								</div>
							  </div>


							  <div class="control-group">
								<label class="control-label" for="selectError3">Proficiency Level</label>
								<div class="controls">
								  <select name="proficiency_id" required>
								  	<?php foreach($course_proficiency as $item){ ?>
									<option value="<?php echo $item->id; ?>" <?php if($course_data->proficiency_id == $item->id){ ?> selected="selected" <?php } ?> ><?php echo $item->title; ?></option>
									<?php } ?>
								
									</select>
								</div>
							  </div>

							  <div class="control-group">
							  <label class="control-label" for="date01">Course Title</label>
							  <div class="controls">
								<input type="text" name="title" class="input-xlarge" id="date01" value="<?php echo $course_data->title; ?>">
							  </div>
							</div>


							<div class="control-group hidden-phone">
							  <label class="control-label" for="textarea2">Description</label>
							  <div class="controls">
								<textarea class="cleditor" name="description" id="textarea2" rows="3"><?php echo $course_data->description; ?></textarea>
							  </div>
							</div>


							<div class="control-group hidden-phone">
							  <label class="control-label" for="textarea2">Excerpt</label>
							  <div class="controls">
								<textarea class="cleditor" name="excerpt" id="textarea2" rows="3"><?php echo $course_data->excerpt; ?></textarea>
							  </div>
							</div>


							<div class="control-group hidden-phone">
							  <label class="control-label" for="textarea2">Course Outline</label>
							  <div class="controls">
								<textarea class="cleditor" name="course_outline" id="textarea2" rows="3"><?php echo $course_data->course_outline; ?></textarea>
							  </div>
							</div>


							<div class="control-group">
							  <label class="control-label" for="date01">Amount</label>
							  <div class="controls">
								<input type="text" name="amount" class="input-xlarge" value="<?php echo $course_data->amount; ?>" placeholder="Add Amount">
								<!-- <input type="text" class="input-xlarge datepicker" id="date01" value="02/16/12"> -->
							  </div>
							</div>


							<div class="control-group">
							  <label class="control-label" for="date01">Course Duration</label>
							  <div class="controls">
								<input type="text" name="duration" class="input-xlarge" value="<?php echo $course_data->duration; ?>" placeholder="duration">
								<!-- <input type="text" class="input-xlarge datepicker" id="date01" value="02/16/12"> -->
							  </div>
							</div>

							<div class="control-group">
							  <label class="control-label" for="date01">Discount(%)</label>
							  <div class="controls">
								<input type="text" name="discount" class="input-xlarge" id="date01" value="<?php echo $course_data->discount; ?>" placeholder="Discount">
								<!-- <input type="text" class="input-xlarge datepicker" id="date01" value="02/16/12"> -->
							  </div>
							</div>

							  <div class="control-group">
								<label class="control-label" for="selectError3">Status</label>
								<div class="controls">
								  <select name="status" required>
									<option value="" > --- </option>
									<option value="online" <?php if($course_data->status == 'online'){ ?> selected="selected" <?php } ?> > online </option>
									<option value="offline" <?php if($course_data->status == 'offline'){ ?> selected="selected" <?php } ?> > offline </option>
									</select>
								</div>
							  </div>



							<div class="control-group">
								<label class="control-label">Course Image Upload</label>
								<div class="controls">
								  <input type="file" name="image">
								  <img src="<?php echo PIC_PATH.$course_data->image; ?>" width="150">
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
	
	