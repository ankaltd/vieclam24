<?php
class WEP_Comment_Single extends Walker_Comment{
	
	protected function html5_comment( $comment, $depth, $args ) {
		$ten = get_comment_author($comment->comment_ID);
		$commenter = wp_get_current_commenter();
		if ( $commenter['comment_author_email'] ) {
			$moderation_note = __( 'Your comment is awaiting moderation.' );
		} else {
			$moderation_note = __( 'Your comment is awaiting moderation. This is a preview, your comment will be visible after it has been approved.' );
		}
		if ($depth > 1): ?>
			<div class="cmt_item border-top border-white" data-id="<?php echo $comment->comment_ID; ?>" id="comment-<?php echo $comment->comment_ID; ?>">
				<div class="qtv">
					<div class="p-1 border bg-light d-inline-block h6 font-weight-bold m-0 text-uppercase"><?php echo (!empty($ten)) ? substr($ten, 0, 1) : ''; ?></div>
					<span class="ten-qtv"><?php echo $ten ?></span>
					<?php $user = get_user_by( 'email', $comment->comment_author_email );
					if ($user !== false) {
						if ($user->roles[0] == 'author' || $user->roles[0] == 'editor' || $user->roles[0] == 'administrator') { ?>
							<span>QTV</span>
						<?php }
					} ?>
				</div>
				<div class="question">
					<?php if ('0' == $comment->comment_approved): ?>
						<div class="alert alert-danger"><?php echo $moderation_note ?></div>
					<?php endif ?>
					<?php comment_text(); ?>
				</div>
		<?php else: ?>
			<div class="user-admin-hd" data-id="<?php echo $comment->comment_ID; ?>" id="comment-<?php echo $comment->comment_ID; ?>">
				<div class="user-hoi">
					<div class="user">
						<div class="d-flex align-items-center">
							<span class="p-1 border bg-light text-uppercase"><?php echo (!empty($ten)) ? substr($ten, 0, 1) : ''; ?></span>
							<span><?php echo $ten ?></span>
						</div>
					</div>
				</div>
				<div class="content-user">
					<?php if ('0' == $comment->comment_approved): ?>
						<div class="alert alert-danger"><?php echo $moderation_note ?></div>
					<?php endif ?>
					<?php comment_text(); ?>
				</div>
		<?php endif; ?>
				<div class="reply_list">
					<?php
					comment_reply_link(
						array_merge(
							$args,
							array(
								'add_below' => 'comment',
								'depth'     => $depth,
								'max_depth' => $args['max_depth'],
								'reply_text'    => '<i class="fa fa-commenting-o" aria-hidden="true"></i> '.__( 'Reply' ),
							)
						)
					);
					?>
					<span>|</span>
					<span class="time"><?php printf( __( '%1$s at %2$s' ), get_comment_date( '', $comment ), get_comment_time() ); ?></span>
				</div>
	<?php }
}