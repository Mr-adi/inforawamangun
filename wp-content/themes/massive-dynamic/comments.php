<?php
function pixflow_comment_reform ($arg) {
    $arg['title_reply']  = esc_attr__('REPLY A MESSAGE', 'massive-dynamic');
    $arg['label_submit'] = esc_attr__('SEND','massive-dynamic' );
    return $arg;
}
add_filter('comment_form_defaults', 'pixflow_comment_reform');

/*-----------------------------------------------------------------------------------*/
/*	Functions
/*-----------------------------------------------------------------------------------*/

	function pixflow_comment_fields($fields) {
	
		$commenter = wp_get_current_commenter();

        $fields['url'] = '';

		$fields['author'] = "<div class=\"input-text\"><input name=\"author\" value=\"" . esc_attr($commenter['comment_author']) . "\" placeholder=\"" . esc_attr__('Name', 'massive-dynamic') . "\" type=\"text\" tabindex=\"1\"></div>";
		
		$fields['email'] = "<div class=\"input-text\"><input name=\"email\" value=\"" . esc_attr($commenter['comment_author_email']). "\" placeholder=\"" . esc_attr__('Email', 'massive-dynamic') . "\" type=\"text\" tabindex=\"2\"></div>";
		
		$fields['subject'] = '<div  class="input-text"><input name="subject" value="" placeholder="' . esc_attr__('Subject', 'massive-dynamic').'" type="text" tabindex="3"  ></div>';

		return $fields;
	}

	add_filter('comment_form_default_fields', 'pixflow_comment_fields');

    function pixflow_comment_form_before()
    {
        echo '<div class="form-container-classic clearfix" >
                   <div class="creply-titlerfix">
                        <div class="inputs-container">';
    }

    function pixflow_comment_form_after()
    {
        echo ' </div></div></div>';
    }

    add_action('comment_form_before_fields', 'pixflow_comment_form_before');
    add_action('comment_form_after_fields', 'pixflow_comment_form_after');

	//Comment styling

	function pixflow_theme_comment($comment, $args, $depth) {

		$isByAuthor = false;

		if($comment->comment_author_email == get_the_author_meta('email')) {
			$isByAuthor = true;
		}

		$GLOBALS['comment'] = $comment; ?>
		
		<li>
			<div id="comment-<?php comment_ID() ?>" <?php comment_class('clearfix'); ?> data-id="<?php comment_ID(); ?>">
				<div class="comment-image">
                    <?php echo get_avatar($comment,$size='75'); ?>
				</div>
                <div class="comment-content">
                    <div class="comment-meta">
                        <?php
                        $author='';
                        if($isByAuthor) $author=' (Author)';
                        printf('<p class="name">%s'.$author.'</p>', get_comment_author_link()) ?>

                        <?php
                        edit_comment_link(esc_attr__('Edit', 'massive-dynamic'),'  ','');
                        comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth'])));
                        ?>
                        <div class="clearfix"></div>
                        <div class="comment-text">
                            <?php comment_text() ?>
                        </div>
                        <a class="comment-date" href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(esc_attr__('%1$s at %2$s', 'massive-dynamic'), get_comment_date(),  get_comment_time()) ?></a>

                    </div>

                </div>
		        <div class="line"></div>
		    </div>

	<?php
	}

	function pixflow_theme_list_pings($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment; ?>
		<li id="comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?>
	<?php }

	
	// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php esc_attr_e('This post is password protected. Enter the password to view comments.', 'massive-dynamic') ?></p>
	<?php
		return;
	}

/*-----------------------------------------------------------------------------------*/
/*	Display the comments + Pings
/*-----------------------------------------------------------------------------------*/

if ( have_comments() ) { // if there are comments ?>
	<div class="comments-wrap">
	
		<?php if ( ! empty($comments_by_type['comment']) ) { // if there are normal comments ?>
            <h3 class="comment-number" id="comments"><?php comments_number();?></h3>
			<ul class="comments-list">
			<?php wp_list_comments('type=comment&avatar_size=75&callback=pixflow_theme_comment'); ?>
			</ul>

		<?php } // if there are normal comments ?>

		<?php if ( ! empty($comments_by_type['pings']) ) { // if there are pings ?>

			<h4 id="pings"><?php esc_attr_e('Trackbacks for this post', 'massive-dynamic') ?></h4>

			<ol class="ping_list">
			<?php wp_list_comments('type=pings&callback=pixflow_theme_list_pings'); ?>
			</ol>

		<?php } // if there are pings ?>

			<div class="navigation">
				<div class="alignleft"><?php previous_comments_link(); ?></div>
				<div class="alignright"><?php next_comments_link(); ?></div>
			</div>
	</div>
<?php
	
	//Deal with closed comments	
	if (!comments_open()) { // if the post has comments but comments are now closed ?>
		
			<?php if (is_single()) { ?>
				<p class="nocomments"><?php esc_attr_e('Comments are now closed.', 'massive-dynamic'); ?></p>
			<?php 
			} else{ ?>
				<p class="nocomments"><?php esc_attr_e('Comments are now closed for this article.', 'massive-dynamic'); ?></p>
			<?php } ?> 
		
	<?php }
	
}
else //There are no comments
{
	//If there are no comments so far and comments are open
	if(comments_open())
	{
		if (is_single()) { ?>
			<p id="comments" class="nocomments"><?php esc_attr_e('No comments so far.', 'massive-dynamic'); ?></p>
		<?php 
		} else{ ?>
			<p id="comments" class="nocomments"><?php esc_attr_e('There are no comments for this article.', 'massive-dynamic'); ?></p>
		<?php 
		}  
	}
	else
	{
		if (is_single()) { ?>
			<p id="comments" class="nocomments"><?php esc_attr_e('Comments are closed.', 'massive-dynamic'); ?></p>
		<?php 
		} else{ ?>
			<p id="comments" class="nocomments"><?php esc_attr_e('Comments are closed for this article.', 'massive-dynamic'); ?></p>
		<?php 
		}  
	}
	
} // if there are comments  
	
//Comment Form
if ( !comments_open() ) return;
?>
<div id="respond-wrap">
<?php comment_form(array( 
'comment_notes_before' => '<p> </p>',
'comment_field'=>'<div class="input-textarea"><textarea rows="10" cols="58" name="comment" placeholder="' . esc_attr__('Write your comment ...', 'massive-dynamic').  '" tabindex="4"></textarea></div>',
'comment_notes_after' => ''
));




?>
</div>