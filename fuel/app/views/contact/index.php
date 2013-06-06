<script>
	$(document).ready(function(e)
	{
		//SKYPE CHECK
		$('#skype_call').live('click',function(e)
		{
			if ($(this).hasClass('check'))
			{
				e.preventDefault();
				$('#skype_download').modal('toggle');
			}
		});
		
		$('#skype_done').live('click',function()
		{
			$('#skype_download').modal('toggle');
			$('#skype_call').removeClass('check');
			window.location = "skype:luke.a.policinski?call";
		});
		
		$('.skype_selected_choice').click(function()
		{
			if ($(this).attr('data-skype') == 'true')
			{
				$('#skype_choice').html('<a style="display:none;" id="skype_done"></a>');
				$('#skype_done').click();
			}
			else
			{
				$('#skype_choice').html('<div style="text-align:center;"><a class="btn btn-success" id="skype_done">I have Skype Installed Now!</a></div>');
			}
		})
	});
</script>
<div style="text-align:center;margin-top:20px;">
	<a href="http://linkedin.com/pub/luke-policinski/28/204/584/"><?php echo Asset::img('extreme-garments/linkedin.png');?></a>
	<a href="https://twitter.com/lpolicin"><?php echo Asset::img('extreme-garments/twitter.png');?></a>
	<a href="https://www.facebook.com/luke.policinski"><?php echo Asset::img('extreme-garments/facebook.png');?></a>
	<br>
	<a id="skype_call" class="check" href="skype:luke.a.policinski?call"><?php echo Asset::img('social_media/BL-socialicons08/128x128-02/skype-icon.png');?></a>
	<a href="https://plus.google.com/103079797767158865113"><?php echo Asset::img('social_media/BL-socialicons08/128x128-02/gplus-icon.png');?></a>
	<a target="_blank" href="mailto:Luke@LukePOLO.com?Subject=Hello!"><?php echo Asset::img('social_media/BL-socialicons08/128x128-02/gmail.png');?></a>
</div>

<!-- SKYPE MODAL -->
<div style="padding-left:19px;" class="modal hide" id="skype_download">
	<div data-dismiss="modal" class="fancybox-item fancybox-close"></div>
	<div style="width: 540px; height: 305px; background: url(<?php echo Uri::Create('assets/img/skype_background.png');?>) top left no-repeat; position: relative; font: 14px Verdana, sans-serif;">
		<div style="position: absolute; left: 40px; top: 44px; font: 24px/24px Verdana, sans-serif; color: white; font-weight: 500;">
			Hello!
		</div>
		<div style="position: absolute; left: 40px; top: 90px; width: 230px; font: 14px/18px Verdana, sans-serif; color: white;">
			Skype buttons require that you have the latest version of Skype installed. Don&rsquo;t worry, you only need to do this once.
		</div>
		<div style="position: absolute; left: 290px; top: 90px; width: 220px; font: 14px/18px Verdana, sans-serif; color: white;">
			Skype is a little piece of software that lets you make free calls over the internet.
			<br/>
			<a href="http://www.skype.com/go/features" style="color: white">Learn more about Skype</a>
		</div>
		<div style="position: absolute; left: 40px; top: 200px; font: 14px/18px Verdana, sans-serif; color: black; width: 460px;">
			Skype is free, easy and quick to download and install.
			<br/>It works with Windows, Mac OS X, Linux and your mobile device.
		</div>
		<div id="skype_choice" style="position: absolute; margin: 0; padding: 0; left: 40px; top: 255px; width: 460px;">
				<a data-skype="false" class="skype_selected_choice pull-left btn btn-primary" href="http://www.skype.com/go/download">Download Skype</a>
				<div data-skype="true" class="skype_selected_choice pull-right btn btn-success">Already Have Skype!</div>
		</div>
	</div>
</div>
<div class="alert alert-danger">Currenlty Working On Other Ways</div>
Sorry for plain text for now :<br>

E-Mail : <a target="_blank" href="mailto:Luke@LukePOLO.com?Subject=Hello!">Luke@LukePOLO.com</a>
<br>
Phone : <a href="tel:2606091511">(260) 609 - 1511</a>
<!-- END SKYPE MODAL -->
<br>
Coming Soon!
<br>
Schedule A Meeting / Internal Contact Form / Resume Circle / Better Gmail Circle (yah i made that one looks awful doesn't it?!)