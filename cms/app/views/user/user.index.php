
			<!-- start: Content -->
			<div id="content" class="span10">
			
			
			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="<?php echo DIR.'dashboard'; ?>">Home</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li><a href="javascript:;">All Users</a></li>
			</ul>

		
			
			<div class="row-fluid sortable">	
				<div class="box span12">
					<div class="box-header">
						<h2><i class="halflings-icon white align-justify"></i>
						<span class="break"></span>All Users</h2>
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
									  <th>ID</th>
									  <th>Name</th>
									  <th>Phone</th>
									  <th>Email</th>
									  <th>Logo</th>                                          
									  <th>Date</th>                                          
									  <th>Action</th>                                          
								  </tr>
							  </thead>   
							  <tbody>
							  <?php foreach($users as $item){ ?>
								<tr>
									<td class="center"></td>
									<td class="center"><?php echo $item->user_firstname.' '.$item->user_lastname; ?></td>
									<td class="center"><?php echo $item->user_phone; ?></td>
									<td class="center"><?php echo $item->user_email; ?></td>
									<td class="center"><img src="<?php echo PIC_PATH.$item->user_image; ?>" width="100" ></td>
									<td class="center"><?php echo $item->date_joined; ?></td>
									<td class="center">
										<div class="btn-group">
							<button class="btn btn-small">Option</button>
							<button class="btn btn-small dropdown-toggle" data-toggle="dropdown">
							<span class="caret"></span></button>
							<ul class="dropdown-menu">
								<li><a href="<?php echo DIR.'merchant/edit/'.$item->id; ?>">
								<i class="halflings-icon  tag"></i> Edit Record</a></li>
								<li><a href="<?php echo DIR.'merchant/budget/'.$item->id; ?>">
								<i class="halflings-icon  tag"></i> Budget</a></li>
								<li><a href="<?php echo DIR.'customer/addmany/'.$item->id; ?>">
								<i class="halflings-icon  tag"></i> Add Customers</a></li>
								<li><a href="<?php echo DIR.'customer/view/'.$item->id; ?>">
								<i class="halflings-icon  tag"></i> View Customers</a></li>
								<li><a 
								href="<?php echo DIR.'merchant?delete&amp;del_id='.$item->id; ?>"
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
	
	