
			
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
				<li><a href="javascript:;">Add Course Category</a></li>
			</ul>



			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon white edit"></i><span class="break"></span>Add Category</h2>
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
							

							 <div class="control-group">
								<label class="control-label" for="selectError3">Category Name</label>
								<div class="controls">
								<input type="text" name="title" class="input-xlarge" value="<?php echo $category_data->title; ?>">

								</div>
							  </div>

							  <!--  -->
							  <!-- <div class="control-group">
							  <label class="control-label" for="date01">Sort Order</label>
							  <div class="controls">
								<input type="text" name="sort_order" class="input-xlarge" value="<?php echo $page_data->sort_order; ?>" >
							  </div>
							</div> -->

							<div class="control-group">
							  <label class="control-label" for="date01">Slug</label>
							  <div class="controls">
								<input type="text" class="input-xlarge" value="<?php echo $category_data->slug; ?>" >
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
						<h2><i class="halflings-icon white user"></i><span class="break"></span>Course Categories</h2>
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
								  <th>Slug</th>
								  <!-- <th>Sort Order</th> -->
								  <!-- <th>Page Alias</th> -->
								  <!-- <th>Date</th> -->
								  <th>Actions</th>
							  </tr>
						  </thead>   
						  <tbody>
						   <?php foreach($coursecategory as $item){ ?>
							<tr>
								<td><?php echo $item->title; ?></td>
								<td class="center"><?php echo $item->slug; ?></td>
								<!-- <td class="center"><?php echo $item->sort_order; ?></td> -->
								<!-- <td class="center"><?php echo $item->page_alias; ?></td> -->
								
								<td class="center">
									<div class="btn-group">
							<button class="btn btn-small">Option</button>
							<button class="btn btn-small dropdown-toggle" data-toggle="dropdown">
							<span class="caret"></span></button>
							<ul class="dropdown-menu">
								<li><a href="<?php echo DIR.'dashboard/editcoursecategory/'.$item->id; ?>">
								<i class="halflings-icon  tag"></i> Edit Record</a></li>
								<li><a 
								href="<?php echo DIR.'dashboard/coursecategory'; ?>?action=delete&amp;id=<?php echo $item->id; ?>"
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
	
	