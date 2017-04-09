    <div id="prefooter">
        <div class="inner-wrapper">
            <div class="container-fluid">
	            <div class="row">
                    <?php dynamic_sidebar('footer-widget-area'); ?>
                </div>
            </div>
        </div>
    </div><!--prefooter end-->
    
    </div><!--wrapper end-->
<footer id="page-footer">
    <p>
        <?php _e('Developed by', 'brainworks') ?> <a href="http://brainworks.com.ua/" target="_blank" class="text-underline">BRAIN WORKS</a> &copy; <?php echo date('Y'); ?>
    </p>
</footer>

<?php wp_footer(); ?>
</body>
</html>
