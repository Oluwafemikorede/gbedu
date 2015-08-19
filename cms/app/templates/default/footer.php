<?php

use Helpers\Assets;
use Helpers\Url;
use Helpers\Session;
use Helpers\Hooks;

//initialise hooks
$hooks = Hooks::get();
?>
<footer>

		<p>
			<span style="text-align:left;float:left">&copy; 2015 
			<a href="javascript:;" alt=""><?php echo SITETITLE; ?> Application</a></span>
		</p>

	</footer>
	
	<!-- start: JavaScript-->
	<?php
Assets::js(array(
    Url::templatePath() . 'js/jquery-1.9.1.min.js',
    Url::templatePath() . 'js/jquery-migrate-1.0.0.min.js',
    Url::templatePath() . 'js/jquery-ui-1.10.0.custom.min.js',
    Url::templatePath() . 'js/jquery.ui.touch-punch.js',
    Url::templatePath() . 'js/modernizr.js',
    Url::templatePath() . 'js/bootstrap.min.js',
    Url::templatePath() . 'js/jquery.cookie.js',
    Url::templatePath() . 'js/fullcalendar.min.js',
    Url::templatePath() . 'js/jquery.dataTables.min.js',
    Url::templatePath() . 'js/excanvas.js',
    Url::templatePath() . 'js/jquery.flot.js',
    Url::templatePath() . 'js/jquery.flot.pie.js',
    Url::templatePath() . 'js/jquery.flot.stack.js',
    Url::templatePath() . 'js/jquery.flot.resize.min.js',
    Url::templatePath() . 'js/jquery.chosen.min.js',
    Url::templatePath() . 'js/jquery.uniform.min.js',
    Url::templatePath() . 'js/jquery.cleditor.min.js',
    Url::templatePath() . 'js/jquery.noty.js',
    Url::templatePath() . 'js/jquery.elfinder.min.js',
    Url::templatePath() . 'js/jquery.raty.min.js',
    Url::templatePath() . 'js/jquery.iphone.toggle.js',
    Url::templatePath() . 'js/jquery.uploadify-3.1.min.js',
    Url::templatePath() . 'js/jquery.gritter.min.js',
    Url::templatePath() . 'js/jquery.imagesloaded.js',
    Url::templatePath() . 'js/jquery.masonry.min.js',
    Url::templatePath() . 'js/jquery.knob.modified.js',
    Url::templatePath() . 'js/jquery.sparkline.min.js',
    Url::templatePath() . 'js/counter.js',
    Url::templatePath() . 'js/jquery.textareaCounter.plugin.js'
));

//hook for plugging in javascript
$hooks->run('js');

//hook for plugging in code into the footer
$hooks->run('footer');
?>

<script type="text/javascript">
			$(document).ready(function(){

					$('select[name="SelectURL"]').change(function() {
    					window.location.replace($(this).val());
						});


					$('select[name="SelectPOSTURL"]').change(function() {
    					window.location.replace($(this).val());
						});
			});


	</script>

		<script type="text/javascript">
			var info;
			$(document).ready(function(){
				var options = {
					'maxCharacterSize': -2,
					'originalStyle': 'originalTextareaInfo',
					'warningStyle' : 'warningTextareaInfo',
					'warningNumber': 40
				};
				// $('.textcounter').textareaCount(options);

				var options2 = {
						'maxCharacterSize': 160,
						'originalStyle': 'originalTextareaInfo',
						'warningStyle' : 'warningTextareaInfo',
						'warningNumber': 40,
						'displayFormat' : '#input/#max | #words words'
				};
				$('.textcounter').textareaCount(options2);

				var options3 = {
						'maxCharacterSize': 200,
						'originalStyle': 'originalTextareaInfo',
						'warningStyle' : 'warningTextareaInfo',
						'warningNumber': 40,
						'displayFormat' : '#left Characters Left / #max'
				};
			});
		</script>
			<?php Assets::js(array(Url::templatePath() . 'js/custom.js')); ?>
</body>
</html>
<?php
Session::destroy('success');
Session::destroy('error');
?>
