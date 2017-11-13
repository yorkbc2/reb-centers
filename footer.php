    <?php if(is_active_sidebar('footer-widget-area')) : ?>
        <div class="prefooter">
            <div class="inner-wrapper">
                <div class="container-fluid">
                  <div class="row">
                        <?php dynamic_sidebar('footer-widget-area'); ?>
                    </div>
                </div>
            </div>
        </div><!--prefooter end-->
    <?php endif; ?>
    
    </div><!--wrapper end-->
<footer class="page-footer">
    <p>
        <?php _e('Developed by', 'brainworks') ?> <a href="https://brainworks.com.ua/" target="_blank" class="text-underline">BRAIN WORKS</a> &copy; <?php echo date('Y'); ?>
    </p>
</footer>
</div>

<?php scroll_top(); ?>

<?php if ( is_customize_preview() ) { ?>
  <button class="button-small customizer-edit" data-control='{ "name":"bw_scroll_top_display" }'>
    <?php esc_html_e( 'Edit Scroll Top', 'brainworks' ); ?>
  </button>
  <button class="button-small customizer-edit" data-control='{ "name":"bw_analytics_google_placed" }'>
    <?php esc_html_e( 'Edit Analytics Tracking Code', 'brainworks' ); ?>
  </button>
  <button class="button-small customizer-edit" data-control='{ "name":"bw_login_logo" }'>
    <?php esc_html_e( 'Edit Login Logo', 'brainworks' ); ?>
  </button>
<?php } ?>

<?php wp_footer(); ?>

</body>
</html>
