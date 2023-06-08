<?php if ( is_active_sidebar( 'sidebar-top' ) || is_active_sidebar( 'sidebar-home-t' ) || is_active_sidebar( 'sidebar-single-t' )  || is_active_sidebar( 'sidebar-all' ) ) : ?>
    <div id="secondary" class="widget-area" role="complementary">
        <div id="sidebar-top" class="widget-area-top">
            <?php dynamic_sidebar( 'sidebar-top' ); ?>
        </div>

        <?php wp_reset_query(); if ( is_home() ) : ?>
            <div class="sidebar-normal">
                <?php dynamic_sidebar( 'sidebar-home-t' ); ?>
            </div>
        <?php endif; ?>

        <?php if ( ! is_home() ) : ?>
            <div class="sidebar-normal">
                <?php dynamic_sidebar( 'sidebar-single-t' ); ?>
            </div>
        <?php endif; ?>

        <div id="sidebar-bottom" class="widget-area-bottom">
            <?php dynamic_sidebar( 'sidebar-all' ); ?>
        </div>
    </div>
    <div class="clear"></div>
<?php endif; ?>