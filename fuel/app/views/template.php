<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $title;?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<?php
			// All CSS loads here
			Casset::css('prettify.css');
			Casset::css('jquery.fancybox-1.3.4.css');
			Casset::css('bootstrap.min.css');
			Casset::css('bootstrap-responsive.css');
			Casset::css('chosen.css');
			Casset::css('base.css');
			Casset::css('jquery-ui-1.8.23.custom.css');
			echo Casset::Render_css();
		?>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>

	</head>
	<body  onload="prettyPrint()">
		<div class="content container">
			<?php echo $header;?>
			<div class="container" style="padding-bottom:56px;margin-top:100px;">
				<div id="content" class="hero-unit">
				<?php
					if (Session::get_flash('error'))
					{
						$error = Session::get_flash('error')
					?>
						<div class="alert alert-danger">
							<?php
								echo $error;
							?>
						</div>
					<?php
					}
					if (Session::get_flash('success'))
					{
					?>
						<div class="alert alert-success">
							<?php
								echo Session::get_flash('success');
							?>
						</div>
					<?php
					}
					
					if (isset($_SERVER['HTTP_USER_AGENT']) === true && strpos($_SERVER['HTTP_USER_AGENT'],'MSIE') !== false)
					{
					?>
					<div class="alert-message block-message error">
						<p><strong>Internet Explorer is not supported!</strong> If you want all of the features of <?php echo Config::get('site_name'); ?> to work with your browser, please download a modern web browser.</p>
						<div class="alert-actions">
							<a class="btn small" href="http://chrome.google.com">Get Chrome</a> <a class="btn small" href="http://getfirefox.com">Get Firefox</a>
						</div>
					</div>
				<?php
				} // end show disclaimer for IE.
				?>
					<?php echo $content; ?>
				
				</div>
				<?php
				if(isset($content_below) === true)
				{
				?>
				<div class="container">
					<?php echo $content_below;?>
				</div>
				<?php
				}
			?>
			</div>
			<!-- Contact me modal -->
			<div class="modal hide fade" id="contact_me">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h3>Luke Policinski's Contact Info</h3>
				</div>
				<div class="modal-body">
					<p>
							<a href="mailto:luke@lukepolo.com">Luke@LukePolo.com</a> 
							<a href="https://twitter.com/lpolicin" class="twitter-follow-button" data-show-count="false">Follow @lpolicin</a>
								<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
					</p>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn" data-dismiss="modal">Close</a>
				</div>
			</div>
			<!--  end of contact me modal -->
			<div class="bottom_body"></div>
		</div>
		<footer>
			<?php echo $footer;?>
		</footer>
	</body>
	
	<?php
		// All Javascript loads here
		Casset::js('jquery.fancybox-1.3.4.js');
		Casset::js('prettify.js');
		Casset::js('bootstrap.min.js');
		Casset::js('chosen.jquery.min.js');
		Casset::js('jquery-ui-1.8.23.custom.min.js');
		Casset::js('jquery.autosize-min.js');
		Casset::js('sisyphus.min.js');
		
		
		echo Casset::Render_js();
		
	?>
	<!-- DOCUMENT READY STUFF HERE -->
	<script type="text/javascript">
	$(document).ready(function(){
		
		
		$('.fancybox').fancybox();
		
		// open all external links in a new window
		$("a[href^=http]").each(function(){
			if (this.href.indexOf(location.hostname) == -1)
			{
				$(this).attr(
					'target',
					'_blank'
				);
			}
		});
	
		// validate
		// add a title
		/*
		$('a:not([title])').each(function(){
			$(this).attr(
				'title',
				$(this).html().replace(/<.+>/g,'').trim()
			);
		});
		*/
		// make sure there's a proper href
		$('a[href="#"], a:not([href])').each(function(){
			$(this).attr(
				'href',
				window.location+'#'
			);
		});
		// add an alt tag
		$('img:not([alt]), img[alt=""]').each(function(){
			$(this).attr(
				'alt',
				$(this).attr('src')
			);
		});
		// strip empty classes
		$('[class=""]').each(function(){
			$(this).removeAttr('class');
		});
		// strip empty ids
		$('[id=""]').each(function(){
			$(this).removeAttr('id');
		});
	
		// Adds chosen to all selects
		$("select").each(function(){
				var add = $(this).html();
				$(this).html('<option value=""><option>' + add);
				$(this).chosen();
		});
		
		
		// only let us submit a form once
		$('form').submit(function(){
			$(this).find('input[type="submit"]').each(function(){
				$(this).attr('disabled','disabled');
				$(this).addClass('disabled');
			});
		});
		
		// automatically resize inputs for their text
		$('textarea, input').autosize();
		
		// remembers form data when you reload the page
		$('form').sisyphus();
		
		$( ".datepicker" ).datepicker({
			minDate: 0,
			changeMonth: true,
			changeYear: true,
		});
	});	
	
		var height = null;
		$(window).resize(function() {
			height = $(window).height();
			$('.bottom_body').height(height - 220);
		});
		$(window).resize();
	// Google analytics
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-33266635-1']);
	_gaq.push(['_trackPageview']);
      
	(function() {
	  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	  ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
	</script>


</html>
