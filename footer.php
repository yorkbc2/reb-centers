<?php if (!is_archive()) echo "</div>"; ?>

<footer class="footer js-footer">
    <?php if ($admins = UserController::get_admins()): ?>
    <div class="footer-admins">
        <div class="container">
            <div class="footer-admins-list">
                <?php foreach ($admins as $a): ?>
                    <div class="footer-admins-list-item">
                        <div class="footer-admins-list-item-icon">
                            <i class="fal fa-user-shield"></i>
                        </div>
                        <a href="/user/<?php echo $a->ID; ?>" class="footer-admins-list-item-name">
                            <?php echo "@" . $a->display_name; ?>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <div class="container footer-content">
        <div class="flex-container">
            <div class="footer-logo flex-container _vc">
                <?php echo get_default_logo_link(); ?>
            </div>
            <div class="footer-links flex-container _vc">
                <ul class="social-links">
                    <?php foreach (get_social() as $social): ?>
                    <li>
                        <a href="<?php echo $social["url"]; ?>" title="<?php echo $social["text"]; ?>">
                            <i class="<?php echo $social["icon"]; ?>"></i>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="footer-copy flex-container _vc">
                <span>
                    <?php _e("Сайт разработан", "brainworks"); ?>&nbsp;
                    <a href="https://brainworks.com.ua">
                        BrainWorks
                    </a>
                </span>
            </div>
        </div>
    </div>
</footer>

</div><!-- .wrapper end-->

<?php scroll_top(); ?>

<?php if (is_customize_preview()) { ?>
    <button class="button-small customizer-edit" data-control='{ "name":"bw_scroll_top_display" }'>
        <?php esc_html_e('Edit Scroll Top', 'brainworks'); ?>
    </button>
    <button class="button-small customizer-edit" data-control='{ "name":"bw_analytics_google_placed" }'>
        <?php esc_html_e('Edit Analytics Tracking Code', 'brainworks'); ?>
    </button>
    <button class="button-small customizer-edit" data-control='{ "name":"bw_login_logo" }'>
        <?php esc_html_e('Edit Login Logo', 'brainworks'); ?>
    </button>
<?php } ?>

<div class="is-hide"><?php svg_sprite(); ?></div>

<?php wp_footer(); ?>

</body>
</html>
