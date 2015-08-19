<?php

use Helpers\Assets;
use Helpers\Url;
use Helpers\Hooks;
use Helpers\Session;

use Models\Page;
use Models\User;

//initialise hooks
$hooks = Hooks::get();
?>

<!-- footer -->
  <footer id="footer">
    <div class="text-center padder clearfix">
      <p>
        <small>Web app framework base on Bootstrap<br>&copy; 2014</small>
      </p>
    </div>
  </footer>
  <?php
    Assets::js(array(
    Url::templatePath() . 'js/jquery.min.js',
    Url::templatePath() . 'js/bootstrap.js',
    Url::templatePath() . 'js/app.js',
    Url::templatePath() . 'js/slimscroll/jquery.slimscroll.min.js',
    Url::templatePath() . 'js/app.plugin.js',
    Url::templatePath() . 'js/jPlayer/jquery.jplayer.min.js',
    Url::templatePath() . 'js/jPlayer/add-on/jplayer.playlist.min.js'
    // Url::templatePath() . 'js/jPlayer/demo.js',
  ));
  ?>

  <script type="text/javascript">

  $(document).ready(function(){



  var myPlaylist = new jPlayerPlaylist({
    jPlayer: "#jplayer_N",
    cssSelectorAncestor: "#jp_container_N"
  }, [
<?php $count=0;foreach($songs as $item){ ?>
  <?php if($count == 0){ ?>
    {
      title:"<?php echo $item->song_title; ?>",
      artist:"<?php echo $item->song_title; ?>",
      mp3:"<?php echo Url::templatePath().$item->song_file; ?>",
      poster: "<?php echo Url::templatePath().$item->song_image; ?>"
    }
  <?php } else { ?>
    ,{
      title:"<?php echo $item->song_title; ?>",
      artist:"<?php $artist = User::profile($item->song_artist_id); echo $artist->user_stagename; ?>",
      mp3:"<?php echo Url::templatePath().$item->song_file; ?>",
      poster: "<?php echo Url::templatePath().$item->song_image; ?>"
    }
  <?php } ?>
<?php $count++;} ?>
  ], {
    playlistOptions: {
      enableRemoveControls: true,
      autoPlay: false
    },
    swfPath: "js/jPlayer",
    supplied: "webmv, ogv, m4v, oga, mp3",
    smoothPlayBar: true,
    keyEnabled: true,
    audioFullScreen: false
  });
  
  $(document).on($.jPlayer.event.pause, myPlaylist.cssSelector.jPlayer,  function(){
    $('.musicbar').removeClass('animate');
    $('.jp-play-me').removeClass('active');
    $('.jp-play-me').parent('li').removeClass('active');
  });

  $(document).on($.jPlayer.event.play, myPlaylist.cssSelector.jPlayer,  function(){
    $('.musicbar').addClass('animate');
  });

  $(document).on('click', '.jp-play-me', function(e){
    e && e.preventDefault();
    var $this = $(e.target);
    if (!$this.is('a')) $this = $this.closest('a');

    $('.jp-play-me').not($this).removeClass('active');
    $('.jp-play-me').parent('li').not($this.parent('li')).removeClass('active');

    $this.toggleClass('active');
    $this.parent('li').toggleClass('active');
    if( !$this.hasClass('active') ){
      myPlaylist.pause();
    }else{

      // var i = Math.floor(Math.random() * (1 + 7 - 1));
      var i = Math.floor(e.target.id); //added by korede
      console.log(i);
      myPlaylist.play(i);
    }
    
  });



  // video

  $("#jplayer_1").jPlayer({
    ready: function () {
      $(this).jPlayer("setMedia", {
        title: "Big Buck Bunny",
        m4v: "http://flatfull.com/themes/assets/video/big_buck_bunny_trailer.m4v",
        ogv: "http://flatfull.com/themes/assets/video/big_buck_bunny_trailer.ogv",
        webmv: "http://flatfull.com/themes/assets/video/big_buck_bunny_trailer.webm",
        poster: "images/m41.jpg"
      });
    },
    swfPath: "js",
    supplied: "webmv, ogv, m4v",
    size: {
      width: "100%",
      height: "auto",
      cssClass: "jp-video-360p"
    },
    globalVolume: true,
    smoothPlayBar: true,
    keyEnabled: true
  });

});</script>

</body>
</html>