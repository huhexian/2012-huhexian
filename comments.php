<?php
/**
 * The template for displaying Comments
 *
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( comments_open() ) : ?>
		<h2 class="comments-title">
			<?php
				echo '<span>《' . get_the_title() . '》留言数：'.number_format_i18n( get_comments_number() ).'</span>';
			?>
		</h2>

		<ol class="commentlist">
			<?php
				wp_list_comments(
					array(
						'callback' => 'twentytwelve_comment',
						'style'    => 'ol',
					)
				);
			?>
		</ol><!-- .commentlist -->

		<div class="clear"></div>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<nav id="comment-navigation" data-cnav="<?php echo $post->ID?>">
				<?php paginate_comments_links('prev_text=<&next_text=>&before_page_number= <div>&after_page_number=</div>');  //评论分页 ?>
			</nav>
			<div class="clear"></div>
		<?php endif; // 评论分页 ?>

		<div class="clear"></div>

		<div id="respond" class="comment-respond anchor-fix">
			<h3 id="reply-title" class="comment-reply-title">发表留言 <small><?php cancel_comment_reply_link( '取消回复' ); ?></small></h3>

			<?php
				if ( get_option( 'comment_registration' ) && ! is_user_logged_in() ) :
            		
            		echo '<p class="must-log-in">' . sprintf(
            			/* translators: %s: login URL */
                        __('您必须「<a href="%s">登陆</a>」才能发表留言！' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post->ID ), $post->ID ) ) ) . '</p>';
 
                else : ?>

					<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
				
					<?php

						if ( is_user_logged_in() ) :
							echo '<p class="logged-in-as">' . sprintf(
							/* translators: 1: edit user link, 2: accessibility text, 3: user name, 4: logout URL */
							__( '登陆者：<a href="%1$s" aria-label="%2$s">%3$s</a>。<a href="%4$s">注销？</a>' ),
							get_edit_user_link(),
							/* translators: %s: user name */
							esc_attr( sprintf( __( '已登录为 %s。编辑您的个人资料。' ), $user_identity ) ),
							$user_identity,
							wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post->ID ), $post->ID ) )) . '</p>';
 
						else : ?>

							<div id="comment-author-info">
								<p class="comment-form-author">
									<input type="text" name="author" placeholder="昵称<?php if ($req) echo "（必填）"; ?>" id="author" class="commenttext" value="" tabindex="1" />
								</p>
								<p class="comment-form-email">
									<input type="text" name="email" placeholder="邮箱<?php if ($req) echo "（必填）"; ?>" id="email" class="commenttext" value="" tabindex="2" />
								</p>
								<p class="comment-form-url">
									<input type="text" name="url" placeholder="网址" id="url" class="commenttext" value="" tabindex="3" />
								</p>
							</div>

						<?php endif; ?>

						<p class="comment-form-comment">
							<textarea placeholder="天下攘攘，皆為利往。天下熙熙，皆為利來。" id="comment" name="comment" rows="4" tabindex="4"></textarea>
						</p>

						<div class="commentform-ainfo link_clr">
						<?php if ( ! is_user_logged_in() ) : ?>
							<label class="checkbox-label">
								<input type="checkbox" class="checkbox-radio" id="saveme" value="saveme" checked="checked" title="记住我，下次回复时无需重新输入个人信息。" />
								<span title="记住我，下次回复时无需重新输入个人信息。" class="checkbox-radioinput"></span>记住我
							</label>
						<?php endif; ?>
							<?php 
								if ( ox_get_option( 'commentform_ad_info' ) ) {
									echo ox_get_option( 'commentform_ad_info' );
								} else {
									echo '这里是广告，可以在comments.php文件中修改';
								}
							?>
						</div>

						<p class="form-submit">
							<input name="submit" type="submit" id="submit" class="submit" tabindex="5" value="发表留言(Ctrl+Enter)"/>
							<?php comment_id_fields(); do_action('comment_form', $post->ID); ?>
						</p>

					</form>

					<div class="clear"></div>

					<script type="text/javascript">
						document.getElementById("comment").onkeydown = function (moz_ev){
							var ev = null;
							if (window.event){
								ev = window.event;
							} else {
								ev = moz_ev;
							}
							if (ev != null && ev.ctrlKey && ev.keyCode == 13){
								document.getElementById("submit").click();
							}
						}
					</script>
	 		<?php endif; // get_option( 'comment_registration' )?>
		</div><!-- #respond -->

	<?php endif; ?><!-- comments_open() -->

	<?php if ( ! comments_open() ) : ?>
		<p class="no-comments">评论已关闭！</p>
	<?php endif; ?>

</div><!-- #comments .comments-area -->
