<?php

use Helpers\Assets;
use Helpers\Url;
use Helpers\Hooks;
use Models\Page;

//initialise hooks
$hooks = Hooks::get();
?>

    <?php  Assets::js(array( Url::templatePath() . 'js/modernizr.js'));  ?>
<style type="text/css">
      html {
        height: auto;
      }
    </style>

    <div class="container inner-page">
      
      

      <div class="col-md-9">
        <div class="page-header">
          <h5><?php echo $pagedetails->page_name; ?></h5>
          <div style="background: url('<?php echo Assets::image('images/evet-slider.png','','',true); ?>') no-repeat; height: 319px;
  background-size: contain;  ">



          </div>

        </div>
        <?php echo $pagedetails->page_content_content; ?>
      </div>

      <div class="col-md-3 sidebar-container">
        <!-- <h3>Sidebar</h3> -->
        <ul class="sidebar-links">
          <li><a href="$" class="active">Home</a></li>
          <li><a href="$">About Us</a></li>
          <li><a href="$">How it Works</a></li>
          <li><a href="$">Link Title</a></li>
          <li><a href="$">Another Link</a></li>
        </ul>

        <div class="contact-section">
          <h5 class="title">Contact info</h5>
          
          <h6><i class="fa fa-home"></i> Address</h6> 
          <p>Address Here </p>
          
          <h6><i class="fa fa-phone"></i> Phone Numbers</h6> 
          <p>Phone Here </p>
          
          <h6><i class="fa fa-envelope"></i> Email Address</h6> 
          <p> Mail Here </p>
        </div>

      </div>

    </div>

   