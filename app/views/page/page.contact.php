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

    <!-- Begin page content -->
    <div class="inner-page">
       <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.2265782909244!2d3.3807606000000083!3d6.618749900000004!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x103b930795f22b71%3A0xc41bc17a7567a8d8!2s16+Emmanuel+Keshi%2C+Lagos!5e0!3m2!1sen!2sng!4v1435415296793" width="100%" height="350" frameborder="0" style="border:0"></iframe>

    <div class="container ">
      
      <div class="col-md-12">

        <div class="page-header">
          <h3>Contact Us Page</h3>
        </div>
        <form class="evet-form" method="post" accept="" action="">
           <div class="form-group col-md-4">
            <input type="text" class="form-control" id="" name="name" placeholder="Name">
          </div>

          <div class="form-group col-md-4">
            <input type="email" class="form-control" id="" name="email" placeholder="Email Address">
          </div>

          <div class="form-group col-md-4">
            <input type="tel" class="form-control" id="" name="phone" placeholder="Phone Number">
          </div>

          <div class="form-group col-md-12">
            <textarea class="form-control" id="" name="case" rows="10" placeholder="Case Description ...."></textarea>
          </div>

          <div class="form-group col-md-12">
            <button class="btn btn-evet-gold">SEND REQUEST</button>
          </div>

        </form>
      </div>      

    </div>

    </div>