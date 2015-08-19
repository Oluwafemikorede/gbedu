<?php

use Helpers\Assets;
use Helpers\Url;
use Helpers\Hooks;
use Helpers\Session;

?>


<body class="bg-info dker" style="background: url(<?php echo Url::templatePath().'images/signin.jpg'; ?>); background-size: cover;
    background-position: 50% 50%; ">
  <section id="content" class="m-t-lg wrapper-md animated fadeInUp">    
    <div class="container aside-xl">
      <a class="navbar-brand block" href="<?php echo DIR; ?>"><span class="h1 font-bold">Gbedu</span></a>
      <section class="m-b-lg">
        <header class="wrapper text-center">
          <strong>Sign in to get in touch</strong>
        </header>
        <form action="" method="post">
          <div class="form-group">
            <input type="email" placeholder="Email" name="email" class="form-control rounded input-lg text-center no-border">
          </div>
          <div class="form-group">
             <input type="password" name="password" placeholder="Password" class="form-control rounded input-lg text-center no-border">
          </div>
          <button type="submit" class="btn btn-lg btn-warning lt b-white b-2x btn-block btn-rounded"><i class="icon-arrow-right pull-right"></i><span class="m-r-n-lg">Sign in</span></button>
          <div class="text-center m-t m-b"><a href="<?php echo DIR.'account/forgotpassword'; ?>"><small>Forgot password?</small></a></div>
          <div class="line line-dashed"></div>
          <p class="text-muted text-center"><small>Do not have an account?</small></p>
          <a href="<?php echo DIR.'account/signup'; ?>" class="btn btn-lg btn-info btn-block rounded">Create an account</a>
        </form>
      </section>
    </div>
  </section>
