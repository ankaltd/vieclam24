<?php
class WEP_Comments_View {

    // Hàm callback tùy chỉnh hiển thị comment
    static function wep_comment_callback($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment; ?>

        <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
            <div id="comment-<?php comment_ID(); ?>" class="comment">
                <article class="comment-author vcard">
                    <?php echo get_avatar($comment, 40); ?>
                    <footer class="comment-meta">
                        <?php $say_word = $depth > 1 ? " trả lời " : " bình luận "; ?>
                        <?php printf(__('<cite class="fn">%s</cite> <span class="says"> %s </span>'), get_comment_author_link(), $say_word); ?>
                        <div class="comment-metadata">
                            <a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)); ?>">
                                <?php printf(__('%1$s'), get_comment_date()); ?>
                            </a>
                            <span class="edit-link">
                                <?php edit_comment_link(__('(Edit)'), '  ', ''); ?>
                            </span>
                        </div>
                    </footer>
                </article>
                <?php if ($comment->comment_approved == '0') : ?>
                    <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.'); ?></em>
                    <br />
                <?php endif; ?>


                <div class="comment-content">
                    <?php comment_text(); ?>
                </div>

                <div class="reply">
                    <?php
                    comment_reply_link(
                        array_merge($args, array(
                            'reply_text' => __('Reply'),
                            'depth' => $depth,
                            'max_depth' => $args['max_depth']
                        ))
                    );
                    ?>
                </div>
            </div>
        </li>
    <?php }

    public static function wep_custom_comments($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
    ?>
        <li class="media mb-3" id="comment-<?php comment_ID(); ?>">
            <img src="<?php echo get_avatar_url($comment, array('size' => 60)); ?>" class="mr-3 img-fluid" alt="User Avatar">
            <div class="media-body">
                <h5 class="mt-0 mb-1"><?php echo get_comment_author(); ?></h5>
                <span class="comment-metadata">
                    <a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)); ?>">
                        <?php
                        printf(__('%1$s'), get_comment_date()); ?>
                    </a>
                    <?php edit_comment_link(__('Sửa'), '<span class="edit-link">', '</span>'); ?>
                </span>
                <?php comment_text(); ?>
                <div class="reply">
                    <?php
                    comment_reply_link(
                        array_merge(
                            $args,
                            array(
                                'add_below' => 'comment',
                                'depth'     => $depth,
                                'max_depth' => $args['max_depth']
                            )
                        )
                    ); ?>
                </div>
                <?php if ($args['has_children']) : ?>
                    <ul class="list-unstyled mt-3">
                        <?php wp_list_comments(array(
                            'avatar_size' => 60,
                            'style'       => 'ol',
                            'short_ping'  => true,
                            'callback'    => array('WEP_Comments_View', 'wep_custom_comments')
                        )); ?>
                    </ul>
                <?php endif; ?>
            </div>
        </li>
<?php
    }
}
?>