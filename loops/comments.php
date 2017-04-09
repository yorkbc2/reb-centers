<?php
 
// Do not delete this section
if (isset($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])){
  die ('Please do not load this page directly. Thanks!'); }
if ( post_password_required() ) { ?>
  <div class="alert alert-warning">
    <?php _e('This post is password protected. Enter the password to view comments.', 'brainworks'); ?>
  </div>
<?php
  return; 
}
// End do not delete section
 
if (have_comments()) : ?>

<h3><?php _e('Feedback', 'brainworks'); ?></h3>
<p class="text-muted" style="margin-bottom: 20px;">
 <i class="fa fa-comment-o"></i>&nbsp; <?php _e('Comments', 'brainworks');  ?>: <?php comments_number(__('None', 'brainworks'), '1', '%'); ?>
</p>
  
<ol class="commentlist">
  <?php wp_list_comments('type=comment&callback=brainworks_comment');?>
</ol>

<p class="text-muted">
  <?php paginate_comments_links() ?>
</p>

<?php
  else :
	  if (comments_open()) :
  echo "<p class='alert alert-info'>" . __('Be the first to write a comment.', 'brainworks') . "</p>";
		else :
			echo "<p class='alert alert-warning'>" . __('Comments are closed for this post.', 'brainworks') . "</p>";
		endif;
	endif;
?>

<?php if (comments_open()) : ?>
<section id="respond">

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
 
  <h3><?php comment_form_title(__('Your feedback', 'brainworks'), __('Responses to %s', 'brainworks')); ?></h3>
  <p><?php cancel_comment_reply_link(); ?></p>
  
  <?php if (get_option('comment_registration') && !is_user_logged_in()) : ?>
  <p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.', 'brainworks'), wp_login_url(get_permalink())); ?></p>
  <?php else : ?>
  <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
    <?php if (is_user_logged_in()) : ?>
    <p>
      <?php printf(__('Logged in as', 'brainworks') . ' <a href="%s/wp-admin/profile.php">%s</a>.', get_option('siteurl'), $user_identity); ?>
      <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php __('Log out of this account', 'brainworks'); ?>"><?php echo __('Log out', 'brainworks') . ' <i class="glyphicon glyphicon-arrow-right"></i>'; ?></a>
    </p>
    <?php else : ?>
    
    <div class="form-group">
      <label for="author"><?php _e('Your name', 'brainworks'); if ($req) echo ' <span class="text-muted">' . __('(required)', 'brainworks') . '</span>'; ?></label><br>
      <input type="text" name="author" id="author" placeholder="<?php _e('Your name', 'brainworks'); ?>" value="<?php echo esc_attr($comment_author); ?>" <?php if ($req) echo 'aria-required="true"'; ?>>
    </div>
    <div class="form-group">
      <label for="email"><?php _e('Your email address', 'brainworks'); if ($req) echo ' <span class="text-muted">' . __('(required, but will not be published)', 'brainworks') . '</span>'; ?></label><br>
      <input type="email" name="email" id="email" placeholder="<?php _e('Your email address', 'brainworks'); ?>" value="<?php echo esc_attr($comment_author_email); ?>" <?php if ($req) echo 'aria-required="true"'; ?>>
    </div>
    <div class="form-group">
      <label for="url"><?php echo __('Your website', 'brainworks') . ' <span class="text-muted">' . __('if you have one (not required)', 'brainworks') . '</span>'; ?></label><br>
      <input type="url" name="url" id="url" placeholder="<?php _e('Your website url', 'brainworks'); ?>" value="<?php echo esc_attr($comment_author_url); ?>">
    </div>
    <?php endif; ?>
    <div class="form-group">
      <label for="comment"><?php _e('Your comment', 'brainworks'); ?></label><br>
      <textarea name="comment" id="comment" placeholder="<?php _e('Your comment', 'brainworks'); ?>" rows="4" aria-required="true"></textarea>
    </div>
    <p><input name="submit" class="button-small" type="submit" id="submit" value="<?php _e('Submit comment', 'brainworks'); ?>"></p>
           
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6"></div>
        </div>
  
  
    <?php comment_id_fields(); ?>
    <?php do_action('comment_form', $post->ID); ?>
  </form>
  <?php endif; ?>
</section>
<?php endif; ?>
