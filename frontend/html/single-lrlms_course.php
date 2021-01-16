<?php
/**
 * Parent template for single lrlms course
 * Author: Fernando Martinez
 */
?>
<?php
get_header(); ?>

    <div class="wrap">
        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">

                <?php
                /* Start the Loop */
                while ( have_posts() ) : the_post();
                    if (is_singular()) {
                        loadLrLmsMetaData();
                    }
                    $postType = currentPostType();
                    switch($postType) {
                        case LrLmsConstants::LRLMS_COURSE:
                            error_log('loading course template');
                            lrlms_get_template_part('content', 'single-course');
                        break;
                        case LrLmsConstants::LRLMS_LESSON:
                            error_log('loading lesson template');
                            lrlms_get_template_part('content', 'single-lesson');
                            break;
                        case LrLmsConstants::LRLMS_FORM:
                        default:
                            error_log('loading general template');
                            if (isset(${'content_view'})) {

                            }
                            lrlms_get_template_part( 'template-parts/post/content', get_post_format() );
                    }
                    the_post_navigation( array(
                        'prev_text' => '<span class="screen-reader-text">' . __( 'Previous Post', 'twentyseventeen' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Previous', 'twentyseventeen' ) . '</span> <span class="nav-title"><span class="nav-title-icon-wrapper">' . twentyseventeen_get_svg( array( 'icon' => 'arrow-left' ) ) . '</span>%title</span>',
                        'next_text' => '<span class="screen-reader-text">' . __( 'Next Post', 'twentyseventeen' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Next', 'twentyseventeen' ) . '</span> <span class="nav-title">%title<span class="nav-title-icon-wrapper">' . twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ) . '</span></span>',
                    ) );

                endwhile; // End of the loop.
                ?>

            </main><!-- #main -->
        </div><!-- #primary -->
        <?php get_sidebar(); ?>
    </div><!-- .wrap -->

<?php get_footer();

