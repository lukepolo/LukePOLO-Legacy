<script>
	$(document).ready(function()
	{
		$('.editable').editor({
			ui: {
				textBold: true,
				textItalic: true,
				textUnderline: true,
				textStrike: true,
				quoteBlock: true,
				fontSizeInc: true,
				fontSizeDec: true,
				statistics : false,
				howGuides : false,
				save : false,
				raptorize: false,
				embed : false,
				i18n : false,
				dock:false,
			    },
			// Plugin options
			plugins: {
				// Dock specific plugin options
				dock: {
					docked: true,        // Start the editor already docked
					dockToElement: true, // Dock the editor inplace of the element
				}
			}
		});
	});
</script>
<?php
	foreach($blogs as $blog)
	{
	?>
		<div class="hero-unit content">
		<!-- Start of blog header -->
			<div id="<?php echo $blog->slug;?>" class="page-header">
				<h1><?php echo $blog->title;?><small><h2 style="color:#336699;display:inline-block"><?php echo $blog->sub_title;?></h2></small></h1>
				<?php
					if($blog->updated_at != $blog->created_at)
					{
					?>
						<p style="font-weight:bold">Updated At : <?php echo date('F j, Y',$blog->updated_at);?></p>
					<?php	
					}
				?>
			</div>
			<!-- Start of blog -->
			<div style="padding-bottom:30px;" class="row">
				<div class="span1">
				    <div class="pull-left date">
					<span class="day"><?php echo date('j',$blog->created_at);?></span>
					<span class="month"><?php echo date('F',$blog->created_at);?></span>
					<span class="year"><?php echo date('Y',$blog->created_at);?></span>
				    </div>
				</div>
				<div data-blog_id="<?php echo $blog->id;?>" class="<?php echo Auth::check() ? 'editable' : '';?> span9 offset1">
					<?php echo html_entity_decode($blog->text);?>
				</div>
			</div>
		<!-- End of Blog -->
		</div>
		
	<?php	
	}
?>


