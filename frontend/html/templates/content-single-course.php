<?php
/**
 * template for overview of a single course
 * Author: Fernando Martinez
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="lrlms-single-course-overview">
		<div id="lrlms-sc-primary-<?php the_ID();?>" class="lrlms-sc-content-wrapper">
			<header class="entry-header">
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			</header><!-- .entry-header -->
			<div class="thumbnail">
			<?php the_post_thumbnail(); ?>
			</div>
			<div class="entry-content">
			<?php

			the_content();
				echo('<div>Duration: '.getLrLmsGlobalValue('duration_key').'</div>');
				echo('<div>Price: '.getLrLmsGlobalValue('price_key').'</div>');
				echo('<div>Email support: '.getLrLmsGlobalValue('emailsupport_key').'</div>');
				if (get_current_user_id() == 0) {
					echo('<div><a href="wp-login.php">Login</a> to register for this course</div>');
				} else {
					echo('<div><a href="">Register for this course</a></div>');
				}
			?>
			</div><!-- .entry-content -->
        </div>
        <div id="lrlms-sc-sidebar-<?php the_ID();?>" class="lrlms-sc-sidebar">

        </div>
    </div>




	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
		    echo('<div>Duration: '.getLrLmsGlobalValue('duration_key').'</div>');
            echo('<div>Price: '.getLrLmsGlobalValue('price_key').'</div>');
            echo('<div>Email support: '.getLrLmsGlobalValue('emailsupport_key').'</div>');
            if (get_current_user_id() == 0) {
                echo('<div><a href="'.wp_login_url().'">Login</a> to register for this course</div>');
            } else {
                if (isUserRegistered(get_current_user_id(), get_the_ID())) {
                    echo('<div><a href="'.get_site_url(null,'/lrlms_form/course-classroom/').get_the_ID().'">Go to classroom</a></div>');
                } else {
                    echo('<div><a href="'.get_site_url(null,'/lrlms_form/lrlms-course-reg/').get_the_ID().'">Register for this course</a></div>');
                }
            }
		?>
	</div><!-- .entry-content -->

	<?php //edit_post_link( __( 'Edit', '' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer><!-- .entry-footer -->' ); ?>

</article><!-- #post-## -->
