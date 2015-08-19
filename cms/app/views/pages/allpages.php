
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
				<li><a href="javascript:;">All Pages</a></li>
			</ul>


			
			<div class="row-fluid sortable">	
				<div class="box span12">
					<div class="box-header">
						<h2><i class="halflings-icon white align-justify"></i>
						<span class="break"></span>All Pages</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered condensed">
							  <thead>
								  <tr>
									  <th>Page Name</th>
									  <th>Page Slug</th>
									  <th>Content</th>
									  <th>Date</th>
									  <th>Action</th>                                          
								  </tr>
							  </thead>   
							  <tbody>
							  <?php if(count($pages_contents > 1 )){
							  			foreach($pages_contents as $item){ ?>
								<tr>
									<td>

									<?php 
									if($item->content_page_id != $item->content_subto){
									 echo "<strong>__</strong>".$item->page_name;
									 } else {
									 echo $item->page_name;
									 	} ?></td>
									<td><?php echo $item->page_alias; ?></td>
									<td><?php echo \helpers\document::get_word(strip_tags($item->content_content), 10); ?></td>
									<td><?php echo date("M d, Y", $item->content_created); ?></td>
									<td>
										<div class="btn-group">
							<button class="btn btn-small">Option</button>
							<button class="btn btn-small dropdown-toggle" data-toggle="dropdown">
							<span class="caret"></span></button>
							<ul class="dropdown-menu">
								<li><a href="<?php echo DIR.'page/edit/'.$item->content_page_id; ?>">
								<i class="halflings-icon  tag"></i> Edit Page Details</a></li>
								<li>
								<li><a href="<?php echo DIR.'page/allpagesedit/'.$item->content_id; ?>">
								<i class="halflings-icon  tag"></i> Edit Content</a></li>
								<li><a 
								href="<?php echo DIR.'page/delete/'.$item->content_page_id; ?>"
								onclick="return confirm('Are you sure?');">
								<i class="halflings-icon  download-alt"></i> Delete</a></li>
								
							</ul>
						</div>
									</td>                                       
								</tr>
						<?php }
						} else {
							echo 'No record in table';
							} ?>
								             
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
		

	
	<div class="clearfix"></div>
	
