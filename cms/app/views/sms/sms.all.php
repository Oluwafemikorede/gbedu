
			
			<!-- start: Content -->
			<div id="content" class="span10">
			
			
			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="<?php echo DIR.'dashboard'; ?>">Home</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li><a href="<?php echo DIR.'sms/view'; ?>">SMS</a></li>
			</ul>


			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon white user"></i><span class="break"></span>SMS Records</h2>
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
								  <th>GROUP</th>
								  <th>Firstname</th>
								  <th>Lastname</th>
								  <th>Phone</th>
								  <th>Actions</th>
							  </tr>
						  </thead>   
						  <tbody>
						   <?php foreach($sms as $item){ ?>
							<tr>
								<td><?php echo $item->title; ?></td>
								<td><?php echo $item->firstname; ?></td>
								<td><?php echo $item->lastname; ?></td>
								<td><?php echo $item->phone; ?></td>
								<td class="center">
									<div class="btn-group">
							<button class="btn btn-small">Option</button>
							<button class="btn btn-small dropdown-toggle" data-toggle="dropdown">
							<span class="caret"></span></button>
							<ul class="dropdown-menu">
								<li><a href="<?php echo DIR.'sms/add?edit&amp;ed_id='.$item->id; ?>">
								<i class="halflings-icon  tag"></i> Edit Record</a></li>
								<li><a 
								href="<?php echo DIR.'sms/view'; ?>?action=delete&amp;id=<?php echo $item->id; ?>"
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
		
	
	<div class="clearfix"></div>
	
	