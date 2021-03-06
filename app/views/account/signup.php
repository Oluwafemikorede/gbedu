<?php

use Helpers\Assets;
use Helpers\Url;
use Helpers\Hooks;
use Helpers\Session;

?>

<body class="bg-info dker" style="background: url(<?php echo Url::templatePath().'images/signin.jpg'; ?>); background-size: cover;
    background-position: 50% 50%; ">
  <section id="content" class="m-t-lg wrapper-md animated fadeInDown">
    <div class="container aside-xl">
      <a class="navbar-brand block" href="<?php echo DIR; ?>"><span class="h1 font-bold">Gbedu</span></a>
      <section class="m-b-lg">
        <header class="wrapper text-center">
          <strong>Sign up to find interesting thing</strong>
        </header>
        <form action="" method="post">
          <div class="form-group">
            <input placeholder="Name" name="firstname" class="form-control rounded input-lg text-center no-border">
          </div>
          <div class="form-group">
            <input type="email" name="email" placeholder="Email" class="form-control rounded input-lg text-center no-border">
          </div>
          <div class="form-group">
             <input type="password" name="password" placeholder="Password" class="form-control rounded input-lg text-center no-border">
          </div>
           <div class="form-group">
             <input type="password" name="password2" placeholder="Confirm Password" class="form-control rounded input-lg text-center no-border">
          </div>
          <div class="checkbox i-checks m-b">
            <label class="m-l">
              <input type="checkbox" checked=""><i></i> Agree the 
              <a href="<?php echo DIR.'terms-and-policy'; ?>">terms and policy</a>
            </label>
          </div>
          <button type="submit" class="btn btn-lg btn-warning lt b-white b-2x btn-block btn-rounded"><i class="icon-arrow-right pull-right"></i><span class="m-r-n-lg">Sign up</span></button>
          <div class="line line-dashed"></div>
          <p class="text-muted text-center"><small>Already have an account?</small></p>
          <a href="<?php echo DIR.'account/signin'; ?>" class="btn btn-lg btn-info btn-block btn-rounded">Sign in</a>
        </form>
      </section>
    </div>
  </section>
  