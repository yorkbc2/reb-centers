<?php
/**
 * Custom feedback comments
 * https://codex.wordpress.org/Function_Reference/wp_list_comments#Comments_Only_With_A_Custom_Comment_Display
 */

function bw_comment($comment, $args, $depth)
{
    $GLOBALS['comment'] = $comment;
    extract($args, EXTR_SKIP);
    if ('div' == $args['style']) {
        $tag       = 'div';
        $add_below = 'comment';
    } else {
        $tag       = 'li';
        $add_below = 'div-comment';
    }
    ?>
    <<?php echo $tag ?><?php comment_class(empty($args['has_children']) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
    <?php if ('div' != $args['style']) : ?>
    <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
<?php endif; ?>
    <div class="comment-author vcard">
        <div style="width: 60px; float: left;">
            <?php echo get_avatar($comment->comment_author_email, $size = '40'); ?>
        </div>
        <div>
            <h6><?php comment_author(); ?></h6>
            <p class="comment-meta commentmetadata"><a
                        href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)) ?>"><?php printf('%1$s ' . __('at', 'brainworks') . ' %2$s', get_comment_date(), get_comment_time()) ?></a>
            </p>
            <?php if ($comment->comment_approved == '0') : ?>
                <p>
                    <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'brainworks') ?></em>
                </p>
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <hr/>
            <?php comment_text() ?>
        </div>
    </div>
    <div class="reply">
        <p class="text-right"><?php edit_comment_link("<span class='btn btn-default btn-info'>" . __('Edit', 'brainworks') . "</span>", ' ', ''); ?><?php comment_reply_link(array_merge($args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?></p>
    </div>
    <?php if ('div' != $args['style']) : ?>
    </div>
<?php
endif;
}
