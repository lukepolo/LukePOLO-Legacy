<div class="navbar navbar-static-top" id="nav-header">
    <div class="navbar-inner">
		<div class="container">
			<a data-target=".nav-collapse" data-toggle="collapse" class="btn btn-navbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<a href="<?php echo Uri::base();?>"><?php echo Html::img('assets/img/LukePOLO.png',array('class'=>'header_logo'));?></a>
			<div class="nav-collapse collapse pull-right">
					<ul class="nav pull-right">
						<?php
						if($method != '404')
						{
							$active = 'class="active"';
						}
						else
						{
							$active = '';
						}
						?>
							<li <?php echo ($controller == 'projects' ? $active : '');?>><a href="<?php echo Uri::base();?>">PROJECTS <p class="menu_sub_text">look at em</p></a></li>
							<li <?php echo ($controller == 'blog' ? $active : '');?>><a href="<?php echo Uri::base();?>blog">MY BLOG<p class="menu_sub_text">crazy stuff</p></a></li>
							<li <?php echo ($controller == 'resume' ? $active : '');?>><a href="<?php echo Uri::base();?>resume">MY RESUME<p class="menu_sub_text">check me out</p></a></li>
							<li <?php echo ($controller == 'contact' ? $active : '');?>><a href="<?php echo Uri::base();?>contact">CONTACT ME<p class="menu_sub_text">meet with me</p></a></li>
							<?php
							if(Auth::check())
							{
							?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">ADMIN MENU<b class="caret"></b><p class="menu_sub_text">lets do this</p></a>
								<ul class="dropdown-menu">
									<li><a href="<?php echo Uri::base();?>blog/create">Create New Blog!</a></li>
									<li><a href="<?php echo Uri::base();?>admin/profiler">
									<?php
									    if(Session::get('profiler') === true)
									    {
										echo 'Disable';
									    }
									    else
									    {
										echo 'Enable';
									    }
									?> Profiler
									</a></li>
									<li><a href="<?php echo Uri::base();?>/apc.php">APC Info</a></li>
								</ul>
							</li>
							
							<li><a href="<?php echo Uri::base();?>logout">LOGOUT<p class="menu_sub_text">get me outta here</p></a></li>
							<?php
							}
							?>
					</ul>
			</div><!--/.nav-collapse -->
		</div>
    </div>
</div>