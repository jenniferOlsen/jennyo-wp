<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta http-equiv="content-type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<?php wp_head(); ?>
	</head>
	
	<body <?php body_class(); ?> itemscope="itemscope" itemtype="http://schema.org/WebPage">
	    <header id="header" role="banner" itemscope="itemscope" itemtype="http://schema.org/WPHeader">
		    <div class="wrap clearfix encase_navigation">
			    <section id="header-top" class="clearfix">
				    <!-- Logo -->
					<div class="logo" itemprop="headline">
					<?php if ( get_theme_mod('logo_style', '1') == 1 ) : ?>
						<a href="<?php echo home_url( '/' ) ?>" title="<?php bloginfo( 'name' ); ?>"><?php bloginfo( 'name' ); ?></a>
					<?php elseif ( get_theme_mod('custom_my_logo', of_get_option( 'logo-custom' )) ) : ?>
						<a href="<?php echo home_url( '/' ) ?>" title="<?php bloginfo( 'name' ); ?>" class="custom"><img src="<?php echo get_theme_mod('custom_my_logo', of_get_option( 'logo-custom') ); ?>" title="<?php bloginfo( 'name' ); ?>" alt="<?php bloginfo( 'name' ); ?>" /></a>
					<?php else : ?>
						<a href="<?php echo home_url( '/' ) ?>" title="<?php bloginfo( 'name' ); ?>"><?php bloginfo( 'name' ); ?></a>
					<?php endif; ?>
					</div>
				    <!-- Navigation -->
				    <nav role="navigation" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">
						<?php if ( has_nav_menu( 'header-menu' ) ) : ?>
						    <?php
							    wp_nav_menu(
								    array(
									    'theme_location' => 'header-menu',
									    'container'      => false,
									    'menu_id'        => 'nav',
									    'menu_class'     => 'header-menu',
									    'depth'          => '4'
								    )
							    );
						    ?>
						<?php else : ?>
						<ul id="nav">
							<?php wp_list_pages( 'title_li=&depth=1' ); ?>
						</ul>
						<?php endif; ?>
					</nav>
				</section>
			</div>
			<?php if(is_front_page() && get_header_image()):  ?>
					<aside id="la-banner" class="lr_responsive_banner" style="background-image: url('<?php header_image(); ?>'); ">
			<?php else:
					get_template_part( 'header', 'meta' ); 

				 endif; ?>
		</header>