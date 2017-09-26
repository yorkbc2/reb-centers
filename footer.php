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
<a href="#top" class="scroll-top js-scroll-top"></a>
<?php locate_template("analyticstracking.php", true) ?>
<?php wp_footer(); ?>

</body>
</html>
