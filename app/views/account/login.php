<?php

use Helpers\Assets;
use Helpers\Url;
use Helpers\Hooks;
use Helpers\Session;

//initialise hooks
$hooks = Hooks::get();
?>
    <!-- Begin page content -->
    <div class="container inner-page">

      <form action="" method="POST" class="form-signinBox no_marg">
        <div class="modal-content">
          <div class="modal-header">
            <!-- <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button> -->
            <h4 class="modal-title glo-title">Sign in</h4>
          </div>
          <div class="modal-body form-feedback">
            <p class="glo-title">
              <center><i class="fa fa-4x fa-user"></i></center>
            </p>
           
            <div class="form-group">
              <label>Email Address</label>
              <input type="email" placeholder="Ussername" name="email" required="required" class="width-100per">
            </div>

            <div class="form-group">
              <label>Password</label>
              <input type="password" placeholder="Password" name="password" required="required" class="width-100per">
            </div>

          </div>
          <div class="modal-footer">
            <a href="#" class="btn-link pull-left">forgot password? click here</a>
            <button class="btn btn-primary btn-evet-gold" name="login">Sign in <i class="fa fa-sign-in"></i></button>
          </div>
        </div>
      </form>

    </div>
