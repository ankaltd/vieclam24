<?php


class WEP_Comment {

    // Mở comment
    public static function open_comments($post_id) {
        $post = get_post($post_id);

        if ($post->comment_status === 'closed') {
            $postdata = array(
                'ID' => $post_id,
                'comment_status' => 'open',
            );
            wp_update_post($postdata);
            return "Comments have been reopened for post with ID: " . $post_id;
        } else {
            return "Comments are already open for post with ID: " . $post_id;
        }
    }
    
}
