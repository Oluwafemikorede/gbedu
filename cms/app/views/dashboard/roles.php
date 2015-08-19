
			<!-- start: Content -->
			<div id="content" class="span10">
			
			
			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="<?php echo DIR.'dashboard'; ?>">Home</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li><a href="javascript:;">Courses</a></li>
			</ul>

		
			
			<div class="row-fluid sortable">	
				<div class="box span12">
					<div class="box-header">
						<h2><i class="halflings-icon white align-justify"></i>
						<span class="break"></span>Courses</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-bordered table-striped table-condensed">
							  <thead>
								  <tr>
									  <th>Id</th>
									  <th>Category</th>
									  <th>Tutor</th>
									  <th>Course Title</th>
									  <th>Duration</th>
									  <th>Description</th>                                          
									  <th>Amount</th>                                          
									  <th>Discount</th>                                          
									  <th>Proficiency Level</th>                                          
									  <th>Action</th>                                          
								  </tr>
							  </thead>   
							  <tbody>
							  <?php foreach($courses as $item){ ?>
								<tr>
									<td><?php echo $item->id; ?></td>
									<td class="center"><?php echo $item->category; ?></td>
									<td class="center"><?php echo $item->institution; ?></td>
									<td class="center"><?php echo $item->title; ?></td>
									<td class="center"><?php echo $item->duration; ?></td>
									<td class="center"><?php echo $item->description; ?></td>
									<td class="center"><?php echo \helpers\document::price($item->amount); ?></td>
									<td class="center"><?php echo $item->discount.'%'; ?></td>
									<td class="center"><?php echo $item->proficiency; ?></td>
									<td class="center">
										<div class="btn-group">
							<button class="btn btn-small">Option</button>
							<button class="btn btn-small dropdown-toggle" data-toggle="dropdown">
							<span class="caret"></span></button>
							<ul class="dropdown-menu">
								<li><a href="<?php echo DIR.'dashboard/editcourse/'.$item->id; ?>">
								<i class="halflings-icon  tag"></i> Edit Record</a></li>
								<li><a 
								href="<?php echo DIR.'dashboard/courses/delete/'.$item->id; ?>"
								onclick="return confirm('Are you sure?');">
								<i class="halflings-icon  download-alt"></i> Delete</a></li>
							</ul>
						</div>
									</td>                                       
								</tr>
							   <?php } ?>
							  </tbody>
						 </table>  
						 <div class="pagination pagination-centered">

						 <?php echo $page_links; ?>

						</div>     
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
	
	