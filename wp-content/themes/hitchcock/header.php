<!DOCTYPE html>

<html class="no-js" <?php language_attributes(); ?>>

	<head profile="http://gmpg.org/xfn/11">
		
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" >
		 
		<?php wp_head(); ?>
	
	</head>
	
	<body <?php body_class(); ?>>
		
		<div class="navigation">
			
			<div class="section-inner">
				
				<ul class="main-menu">
																		
					<?php if ( has_nav_menu( 'primary' ) ) {
																		
						wp_nav_menu( array( 
						
							'container' => '', 
							'items_wrap' => '%3$s',
							'theme_location' => 'primary', 
														
						) ); } else {
					
						wp_list_pages( array(
						
							'container' => '',
							'title_li' => ''
						
						));
						
					} ?>
					
					<li class="header-search">
						<form method="get" class="search-form" id="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
							<input type="search" class="search-field" name="s" placeholder="<?php _e('Search Form','hitchcock'); ?>" /> 
							<a class="search-button" onclick="document.getElementById('search-form').submit(); return false;"><div class="fa fw fa-search"></div></a>
						</form>
					</li>
					
				</ul>
				
				<div class="clear"></div>
				
			</div> <!-- /section-inner -->
			
			<div class="nav-toggle">
					
				<div class="bars">
					<div class="bar"></div>
					<div class="bar"></div>
					<div class="bar"></div>
				</div>
				
			</div> <!-- /nav-toggle -->
			
			<div class="mobile-navigation">
			
				<ul class="mobile-menu">
																			
						<?php if ( has_nav_menu( 'primary' ) ) {
																			
							wp_nav_menu( array( 
							
								'container' => '', 
								'items_wrap' => '%3$s',
								'theme_location' => 'primary', 
															
							) ); } else {
						
							wp_list_pages( array(
							
								'container' => '',
								'title_li' => ''
							
							));
							
						} ?>
						
					</ul>
					
					<?php get_search_form(); ?>
			
			</div> <!-- /mobile-navigation -->
			
		</div> <!-- /navigation -->
		
		<div class="header-image" style="background-image: url(<?php if (get_header_image() != '') : ?><?php header_image(); ?><?php else : ?><?php echo get_template_directory_uri() . '/images/bg.jpg'; ?><?php endif; ?>);"></div>
	
		<div class="header section-inner">
		
			<?php if ( get_theme_mod( 'hitchcock_logo' ) ) : ?>
			
		        <a class="blog-logo" href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'title' ) ); ?> &mdash; <?php echo esc_attr( get_bloginfo( 'description' ) ); ?>' rel='home'>
		        	<img src='<?php echo esc_url( get_theme_mod( 'hitchcock_logo' ) ); ?>' alt='<?php echo esc_attr( get_bloginfo( 'title' ) ); ?>'>
		        </a>
		
			<?php else : ?>
		
				<h1 class="blog-title">
					<a href="<?php echo esc_url( home_url() ); ?>" title="<?php echo esc_attr( get_bloginfo( 'title' ) ); ?> &mdash; <?php echo esc_attr( get_bloginfo( 'description' ) ); ?>" rel="home"><?php echo esc_attr( get_bloginfo( 'title' ) ); ?></a>
				</h1>
				
			<?php endif; ?>
			
			<?php if ( get_bloginfo('description') ) : ?>
			
				<p class="blog-description"><?php echo bloginfo('description'); ?></p>
			
			<?php endif; ?>
			
			<?php if ( has_nav_menu( 'social' ) ) : ?>
			
				<ul class="social-menu">
							
					<?php 
						wp_nav_menu(
							array(
								'theme_location'	=>	'social',
								'container'			=>	'',
								'container_class'	=>	'menu-social',
								'items_wrap'		=>	'%3$s',
								'menu_id'			=>	'menu-social-items',
								'menu_class'		=>	'menu-items',
								'depth'				=>	1,
								'link_before'		=>	'<span class="screen-reader-text">',
								'link_after'		=>	'</span>',
								'fallback_cb'		=>	'',
							)
						);
					?>
					
				</ul> <!-- /social-menu -->
			
			<?php endif; ?>
			
		</div> <!-- /header -->