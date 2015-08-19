<?php

use Helpers\Assets;
use Helpers\Url;
use Helpers\Hooks;
use Helpers\Session;

use Models\Page;

//initialise hooks
$hooks = Hooks::get();
?>
     
        <section id="content">
          <section class="vbox">
          <section class="w-f-md">
            <section class="hbox stretch bg-black dker">
              <aside class="col-sm-5 no-padder" id="sidebar">
                <section class="vbox animated fadeInUp">
                  <section class="scrollable">
                    <div class="m-t-n-xxs item pos-rlt">
                      <div class="top text-right">
                        <span class="musicbar animate bg-success bg-empty inline m-r-lg m-t" style="width:25px;height:30px">
                          <span class="bar1 a3 lter"></span>
                          <span class="bar2 a5 lt"></span>
                          <span class="bar3 a1 bg"></span>
                          <span class="bar4 a4 dk"></span>
                          <span class="bar5 a2 dker"></span>
                        </span>
                      </div>
                      <div class="gd bg-info wrapper-lg" 
                      style="background: url(<?php Assets::showBg($playlist->album_image); ?>); background-size: cover; height: 200px;  background-position: 50% 0%; ">
                      <!-- <div class="bottom gd bg-info wrapper-lg" style="background: url(<?php echo Assets::image('images/m43.jpg','','',true); ?>); height: 240px; "> -->
                        <span class="pull-right text-sm">101,400 <br>Followers</span>
                        <span class="h2 font-thin"><?php echo ucfirst($playlist->album_name); ?></span>
                      </div>
                      <?php //echo Assets::image('images/m43.jpg','img-full',''); ?>
                    </div>
                    <ul class="list-group list-group-lg no-radius no-border no-bg m-t-n-xxs m-b-none auto">
                    <?php $i=0; foreach($songs as $item){ ?>
                        <li class="list-group-item">
                        <div class="pull-right m-l">
                          <a href="#" class="m-r-sm"><i class="icon-cloud-download"></i></a>
                          <a href="#" class="m-r-sm"><i class="icon-plus"></i></a>
                          <a href="#"><i class="icon-close"></i></a>
                        </div>
                        <a href="#" class="jp-play-me m-r-sm pull-left" >
                          <i class="icon-control-play text" id="<?php echo $i; ?>"></i>
                          <i class="icon-control-pause text-active"></i>
                        </a>
                        <div class="clear text-ellipsis">
                          <span><?php echo $item->song_title; ?></span>
                          <span class="text-muted"> -- <?php echo $item->song_duration; ?></span>
                        </div>
                      </li>
                    <?php $i++;  } ?>
                      <!-- <li class="list-group-item">
                        <div class="pull-right m-l">
                          <a href="#" class="m-r-sm"><i class="icon-cloud-download"></i></a>
                          <a href="#" class="m-r-sm"><i class="icon-plus"></i></a>
                          <a href="#"><i class="icon-close"></i></a>
                        </div>
                        <a href="#" class="jp-play-me m-r-sm pull-left">
                          <i class="icon-control-play text"></i>
                          <i class="icon-control-pause text-active"></i>
                        </a>
                        <div class="clear text-ellipsis">
                          <span>E.T.M</span>
                          <span class="text-muted"> -- 04:35</span>
                        </div>
                      </li>
                      <li class="list-group-item">
                        <div class="pull-right m-l">
                          <a href="#" class="m-r-sm"><i class="icon-cloud-download"></i></a>
                          <a href="#"><i class="icon-plus"></i></a>
                        </div>
                        <a href="#" class="jp-play-me m-r-sm pull-left">
                          <i class="icon-control-play text"></i>
                          <i class="icon-control-pause text-active"></i>
                        </a>
                        <div class="clear text-ellipsis">
                          <span>Vestibulum id ligula porta</span>
                          <span class="text-muted"> -- 04:15</span>
                        </div>
                      </li>
                      <li class="list-group-item">
                        <div class="pull-right m-l">
                          <a href="#" class="m-r-sm"><i class="icon-cloud-download"></i></a>
                          <a href="#"><i class="icon-plus"></i></a>
                        </div>
                        <a href="#" class="jp-play-me m-r-sm pull-left">
                          <i class="icon-control-play text"></i>
                          <i class="icon-control-pause text-active"></i>
                        </a>
                        <div class="clear text-ellipsis">
                          <span>Praesent commodo cursus magna</span>
                          <span class="text-muted"> -- 02:25</span>
                        </div>
                      </li>
                      <li class="list-group-item">
                        <div class="pull-right m-l">
                          <a href="#" class="m-r-sm"><i class="icon-cloud-download"></i></a>
                          <a href="#"><i class="icon-plus"></i></a>
                        </div>
                        <a href="#" class="jp-play-me m-r-sm pull-left">
                          <i class="icon-control-play text"></i>
                          <i class="icon-control-pause text-active"></i>
                        </a>
                        <div class="clear text-ellipsis">
                          <span>Curabitur blandit tempus</span>
                          <span class="text-muted"> -- 05:00</span>
                        </div>
                      </li>
                      <li class="list-group-item">
                        <div class="pull-right m-l">
                          <a href="#" class="m-r-sm"><i class="icon-cloud-download"></i></a>
                          <a href="#"><i class="icon-plus"></i></a>
                        </div>
                        <a href="#" class="jp-play-me m-r-sm pull-left">
                          <i class="icon-control-play text"></i>
                          <i class="icon-control-pause text-active"></i>
                        </a>
                        <div class="clear text-ellipsis">
                          <span>Faucibus dolor auctor</span>
                          <span class="text-muted"> -- 03:50</span>
                        </div>
                      </li>
                      <li class="list-group-item">
                        <div class="pull-right m-l">
                          <a href="#" class="m-r-sm"><i class="icon-cloud-download"></i></a>
                          <a href="#"><i class="icon-plus"></i></a>
                        </div>
                        <a href="#" class="jp-play-me m-r-sm pull-left">
                          <i class="icon-control-play text"></i>
                          <i class="icon-control-pause text-active"></i>
                        </a>
                        <div class="clear text-ellipsis">
                          <span>Get lacinia odio sem nec elit cibus dolor auctor sed odio dui mollis ornare</span>
                          <span class="text-muted"> -- 04:05</span>
                        </div>
                      </li>
                      <li class="list-group-item">
                        <div class="pull-right m-l">
                          <a href="#" class="m-r-sm"><i class="icon-cloud-download"></i></a>
                          <a href="#"><i class="icon-plus"></i></a>
                        </div>
                        <a href="#" class="jp-play-me m-r-sm pull-left">
                          <i class="icon-control-play text"></i>
                          <i class="icon-control-pause text-active"></i>
                        </a>
                        <div class="clear text-ellipsis">
                          <span>Faucibus dolor auctor</span>
                          <span class="text-muted"> -- 02:55</span>
                        </div>
                      </li>
                      <li class="list-group-item">
                        <div class="pull-right m-l">
                          <a href="#" class="m-r-sm"><i class="icon-cloud-download"></i></a>
                          <a href="#"><i class="icon-plus"></i></a>
                        </div>
                        <a href="#" class="jp-play-me m-r-sm pull-left">
                          <i class="icon-control-play text"></i>
                          <i class="icon-control-pause text-active"></i>
                        </a>
                        <div class="clear text-ellipsis">
                          <span>Donec sed odio dui</span>
                          <span class="text-muted"> -- 04:35</span>
                        </div>
                      </li> -->
                     <!--  <li class="list-group-item">
                        <div class="pull-right m-l">
                          <a href="#" class="m-r-sm"><i class="icon-cloud-download"></i></a>
                          <a href="#"><i class="icon-plus"></i></a>
                        </div>
                        <a href="#" class="jp-play-me m-r-sm pull-left">
                          <i class="icon-control-play text"></i>
                          <i class="icon-control-pause text-active"></i>
                        </a>
                        <div class="clear text-ellipsis">
                          <span>Urna mollis ornare vel eu leo</span>
                          <span class="text-muted"> -- 05:10</span>
                        </div>
                      </li>
                      <li class="list-group-item">
                        <div class="pull-right m-l">
                          <a href="#" class="m-r-sm"><i class="icon-cloud-download"></i></a>
                          <a href="#"><i class="icon-plus"></i></a>
                        </div>
                        <a href="#" class="jp-play-me m-r-sm pull-left">
                          <i class="icon-control-play text"></i>
                          <i class="icon-control-pause text-active"></i>
                        </a>
                        <div class="clear text-ellipsis">
                          <span>Vivamus sagittis lacus vel augue</span>
                          <span class="text-muted"> -- 02:35</span>
                        </div>
                      </li> -->
                    </ul>
                  </section>
                </section>
              </aside>
              <!-- / side content -->
              <section class="col-sm-4 no-padder bg">
                <section class="vbox">
                  <section class="scrollable hover">
                    <ul class="list-group list-group-lg no-bg auto m-b-none m-t-n-xxs">
                      <li class="list-group-item clearfix">
                        <a href="#" class="jp-play-me pull-right m-t-sm m-l text-md">
                          <i class="icon-control-play text"></i>
                          <i class="icon-control-pause text-active"></i>
                        </a>
                        <a href="#" class="pull-left thumb-sm m-r">
                          <?php echo Assets::image('images/m0.jpg','',''); ?>
                        </a>
                        <a class="clear" href="#">
                          <span class="block text-ellipsis">Little Town</span>
                          <small class="text-muted">by Soph Ashe</small>
                        </a>
                      </li>
                      <li class="list-group-item clearfix">
                        <a href="#" class="jp-play-me pull-right m-t-sm m-l text-md">
                          <i class="icon-control-play text"></i>
                          <i class="icon-control-pause text-active"></i>
                        </a>
                        <a href="#" class="pull-left thumb-sm m-r">
                          <?php echo Assets::image('images/a1.png','img-full',''); ?>
                        </a>
                        <a class="clear" href="#">
                          <span class="block text-ellipsis">Get lacinia odio sem nec elit</span>
                          <small class="text-muted">by Filex</small>
                        </a>
                      </li>
                      <li class="list-group-item clearfix">
                        <a href="#" class="jp-play-me pull-right m-t-sm m-l text-md">
                          <i class="icon-control-play text"></i>
                          <i class="icon-control-pause text-active"></i>
                        </a>
                        <a href="#" class="pull-left thumb-sm m-r">
                          <?php echo Assets::image('images/a2.png','',''); ?>
                        </a>
                        <a class="clear" href="#">
                          <span class="block text-ellipsis">Donec sed odio du</span>
                          <small class="text-muted">by Dan Doorack</small>
                        </a>
                      </li>
                      <li class="list-group-item clearfix">
                        <a href="#" class="jp-play-me pull-right m-t-sm m-l text-md">
                          <i class="icon-control-play text"></i>
                          <i class="icon-control-pause text-active"></i>
                        </a>
                        <a href="#" class="pull-left thumb-sm m-r">
                          <?php echo Assets::image('images/a3.png','',''); ?>
                        </a>
                        <a class="clear" href="#">
                          <span class="block text-ellipsis">Curabitur blandit tempu</span>
                          <small class="text-muted">by Foxes</small>
                        </a>
                      </li>
                      <li class="list-group-item clearfix">
                        <a href="#" class="jp-play-me pull-right m-t-sm m-l text-md">
                          <i class="icon-control-play text"></i>
                          <i class="icon-control-pause text-active"></i>
                        </a>
                        <a href="#" class="pull-left thumb-sm m-r">
                          <?php echo Assets::image('images/a4.png','',''); ?>
                        </a>
                        <a class="clear" href="#">
                          <span class="block text-ellipsis">Urna mollis ornare vel eu leo</span>
                          <small class="text-muted">by Chris Fox</small>
                        </a>
                      </li>
                      <li class="list-group-item clearfix">
                        <a href="#" class="jp-play-me pull-right m-t-sm m-l text-md">
                          <i class="icon-control-play text"></i>
                          <i class="icon-control-pause text-active"></i>
                        </a>
                        <a href="#" class="pull-left thumb-sm m-r">
                          <?php echo Assets::image('images/a5.png','',''); ?>
                        </a>
                        <a class="clear" href="#">
                          <span class="block text-ellipsis">Faucibus dolor auctor</span>
                          <small class="text-muted">by Lauren Taylor</small>
                        </a>
                      </li>
                      <li class="list-group-item clearfix">
                        <a href="#" class="jp-play-me pull-right m-t-sm m-l text-md">
                          <i class="icon-control-play text"></i>
                          <i class="icon-control-pause text-active"></i>
                        </a>
                        <a href="#" class="pull-left thumb-sm m-r">
                          <?php echo Assets::image('images/a6.png','',''); ?>
                        </a>
                        <a class="clear" href="#">
                          <span class="block text-ellipsis">Praesent commodo cursus magn</span>
                          <small class="text-muted">by Chris Fox</small>
                        </a>
                      </li>
                      <li class="list-group-item clearfix">
                        <a href="#" class="jp-play-me pull-right m-t-sm m-l text-md">
                          <i class="icon-control-play text"></i>
                          <i class="icon-control-pause text-active"></i>
                        </a>
                        <a href="#" class="pull-left thumb-sm m-r">
                          <?php echo Assets::image('images/a7.png','',''); ?>
                        </a>
                        <a class="clear" href="#">
                          <span class="block text-ellipsis">Vestibulum id</span>
                          <small class="text-muted">by Milian</small>
                        </a>
                      </li>
                      <li class="list-group-item clearfix">
                        <a href="#" class="jp-play-me pull-right m-t-sm m-l text-md">
                          <i class="icon-control-play text"></i>
                          <i class="icon-control-pause text-active"></i>
                        </a>
                        <a href="#" class="pull-left thumb-sm m-r">
                          <?php echo Assets::image('images/a8.png','',''); ?>
                        </a>
                        <a class="clear" href="#">
                          <span class="block text-ellipsis">Blandit tempu</span>
                          <small class="text-muted">by Amanda Conlan</small>
                        </a>
                      </li>
                      <li class="list-group-item clearfix">
                        <a href="#" class="jp-play-me pull-right m-t-sm m-l text-md">
                          <i class="icon-control-play text"></i>
                          <i class="icon-control-pause text-active"></i>
                        </a>
                        <a href="#" class="pull-left thumb-sm m-r">
                          <?php echo Assets::image('images/a9.png','',''); ?>
                        </a>
                        <a class="clear" href="#">
                          <span class="block text-ellipsis">Vestibulum ullamcorpe quis malesuada augue mco rpe</span>
                          <small class="text-muted">by Dan Doorack</small>
                        </a>
                      </li>
                      <li class="list-group-item clearfix">
                        <a href="#" class="jp-play-me pull-right m-t-sm m-l text-md">
                          <i class="icon-control-play text"></i>
                          <i class="icon-control-pause text-active"></i>
                        </a>
                        <a href="#" class="pull-left thumb-sm m-r">
                          <?php echo Assets::image('images/a10.png','',''); ?>
                        </a>
                        <a class="clear" href="#">
                          <span class="block text-ellipsis">Natis ipsum ac feugiat</span>
                          <small class="text-muted">by Hamburg</small>
                        </a>
                      </li>
                      <li class="list-group-item clearfix">
                        <a href="#" class="jp-play-me pull-right m-t-sm m-l text-md">
                          <i class="icon-control-play text"></i>
                          <i class="icon-control-pause text-active"></i>
                        </a>
                        <a href="#" class="pull-left thumb-sm m-r">
                          <?php echo Assets::image('images/a0.png','',''); ?>
                        </a>
                        <a class="clear" href="#">
                          <span class="block text-ellipsis">Sec condimentum au</span>
                          <small class="text-muted">by Amanda Conlan</small>
                        </a>
                      </li>
                    </ul>
                  </section>
                </section>
              </section>
              <section class="col-sm-3 no-padder lt">
                <section class="vbox">
                  <section class="scrollable hover">
                    <div class="m-t-n-xxs">
                      <div class="item pos-rlt">
                        <a href="#" class="item-overlay active opacity wrapper-md font-xs">
                          <span class="block h3 font-bold text-info">Find</span>
                          <span class="text-muted">Search the music you like</span>
                          <span class="bottom wrapper-md block">- <i class="icon-arrow-right i-lg pull-right"></i></span>
                        </a>
                        <a href="#">
                          <?php echo Assets::image('images/m40.jpg','img-full',''); ?>
                        </a>
                      </div>
                      <div class="item pos-rlt">
                        <a href="#" class="item-overlay active opacity wrapper-md font-xs text-right">
                          <span class="block h3 font-bold text-warning text-u-c">Listen</span>
                          <span class="text-muted">Find the peace in your heart</span>
                          <span class="bottom wrapper-md block"><i class="icon-arrow-right i-lg pull-left"></i> -</span>
                        </a>
                        <a href="#">
                          <?php echo Assets::image('images/m41.jpg','img-full',''); ?>
                        </a>
                      </div>
                      <div class="item pos-rlt">
                        <a href="#" class="item-overlay active opacity wrapper-md font-xs">
                          <span class="block h3 font-bold text-success text-u-c">Share</span>
                          <span class="text-muted">Share the good songs with your loves</span>
                          <span class="bottom wrapper-md block">- <i class="icon-arrow-right i-lg pull-right"></i></span>
                        </a>
                        <a href="#">
                          <?php echo Assets::image('images/m42.jpg','img-full',''); ?>
                        </a>
                      </div>
                      <div class="item pos-rlt">
                        <a href="#" class="item-overlay active opacity wrapper-md font-xs text-right">
                          <span class="block h3 font-bold text-white text-u-c">2014</span>
                          <span class="text-muted">Find, Listen & Share</span>
                          <span class="bottom wrapper-md block"><i class="icon-arrow-right i-lg pull-left"></i> -</span>
                        </a>
                        <a href="#">
                          <?php echo Assets::image('images/m44.jpg','img-full',''); ?>
                        </a>
                      </div>
                      <div class="item pos-rlt">
                        <a href="#" class="item-overlay active opacity wrapper-md font-xs">
                          <span class="block h3 font-bold text-danger-lter text-u-c">Top10</span>
                          <span class="text-muted">Selected songs</span>
                          <span class="bottom wrapper-md block">- <i class="icon-arrow-right i-lg pull-right"></i></span>
                        </a>
                        <a href="#">
                          <?php echo Assets::image('images/m45.jpg','img-full',''); ?>
                        </a>
                      </div>
                    </div>
                  </section>
                </section>
              </section>
            </section>
          </section>
          <footer class="footer bg-success dker">
            <div id="jp_container_N">
                    <div class="jp-type-playlist">
                      <div id="jplayer_N" class="jp-jplayer hide"></div>
                      <div class="jp-gui">
                        <div class="jp-video-play hide">
                          <a class="jp-video-play-icon">play</a>
                        </div>
                        <div class="jp-interface">
                          <div class="jp-controls">
                            <div><a class="jp-previous"><i class="icon-control-rewind i-lg"></i></a></div>
                            <div>
                              <a class="jp-play"><i class="icon-control-play i-2x"></i></a>
                              <a class="jp-pause hid"><i class="icon-control-pause i-2x"></i></a>
                            </div>
                            <div><a class="jp-next"><i class="icon-control-forward i-lg"></i></a></div>
                            <div class="hide"><a class="jp-stop"><i class="fa fa-stop"></i></a></div>
                            <div><a class="" data-toggle="dropdown" data-target="#playlist"><i class="icon-list"></i></a></div>
                            <div class="jp-progress hidden-xs">
                              <div class="jp-seek-bar dk">
                                <div class="jp-play-bar bg">
                                </div>
                                <div class="jp-title text-lt">
                                  <ul>
                                    <li></li>
                                  </ul>
                                </div>
                              </div>
                            </div>
                            <div class="hidden-xs hidden-sm jp-current-time text-xs text-muted"></div>
                            <div class="hidden-xs hidden-sm jp-duration text-xs text-muted"></div>
                            <div class="hidden-xs hidden-sm">
                              <a class="jp-mute" title="mute"><i class="icon-volume-2"></i></a>
                              <a class="jp-unmute hid" title="unmute"><i class="icon-volume-off"></i></a>
                            </div>
                            <div class="hidden-xs hidden-sm jp-volume">
                              <div class="jp-volume-bar dk">
                                <div class="jp-volume-bar-value lter"></div>
                              </div>
                            </div>
                            <div>
                              <a class="jp-shuffle" title="shuffle"><i class="icon-shuffle text-muted"></i></a>
                              <a class="jp-shuffle-off hid" title="shuffle off"><i class="icon-shuffle text-lt"></i></a>
                            </div>
                            <div>
                              <a class="jp-repeat" title="repeat"><i class="icon-loop text-muted"></i></a>
                              <a class="jp-repeat-off hid" title="repeat off"><i class="icon-loop text-lt"></i></a>
                            </div>
                            <div class="hide">
                              <a class="jp-full-screen" title="full screen"><i class="fa fa-expand"></i></a>
                              <a class="jp-restore-screen" title="restore screen"><i class="fa fa-compress text-lt"></i></a>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="jp-playlist dropup" id="playlist">
                        <ul class="dropdown-menu aside-xl dker">
                          <!-- The method Playlist.displayPlaylist() uses this unordered list -->
                          <li class="list-group-item"></li>
                        </ul>
                      </div>
                      <div class="jp-no-solution hide">
                        <span>Update Required</span>
                        To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
                      </div>
                    </div>
                  </div>
          </footer>
        </section>
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open" data-target="#nav,html"></a>
        </section>
      </section>
    </section>    
  </section>
  