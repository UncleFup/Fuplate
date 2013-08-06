<?php
/**
 * The template for displaying posts in the Quote post format
 */

$meta = get_post_meta( get_the_ID() );



if ( isset( $meta['_fup_quote_character'][0] ) ):
	$character = '<span class="character">' . $meta['_fup_quote_character'][0] . '</span>';
endif;
if ( isset( $meta['_fup_quote_author'][0] ) ):
	$author = '<span class="author">' . $meta['_fup_quote_author'][0] . '</span>';
else:
	$author = '<span class="author">' . get_the_title() . '</span>';
endif;
if ( isset( $meta['_fup_quote_work'][0] ) ):
	$work = '<cite>';
	if ( isset( $meta['_fup_quote_link'][0] ) ):
		$link = $meta['_fup_quote_link'][0];
		$work .= '<a href="' . $link . '" title="'
			   . __( 'View the source.', 'fup' ) . '"><i>'
			   . $meta['_fup_quote_work'][0] . '</i></a>';
	else:
		$work .= '<i>' . $meta['_fup_quote_work'][0] . '</i>';
	endif;
	$work .= '</cite>';
elseif ( isset( $meta['_fup_quote_link'][0] ) ):
	$link = $meta['_fup_quote_link'][0];
	$work = '<cite>';

	$work .= '<a href="' . $link . '" title="'
		   . __( 'View the source.', 'fup' ) . '"><i>'
		   . $link . '</i></a>';

	$work .= '</cite>';
endif;
/**
 * If giving a publish date, it should be Y-m-d format, i.e. YYYY-MM-DD
 */
if ( isset( $meta['_fup_quote_date'][0] ) ):
	$time = $meta['_fup_quote_date'][0];
	$comp = strtotime( $time );
	if ( date( 'Y-m-d', $comp ) == $time ):
		$date = date( 'F j, Y', $comp );
	elseif ( date( 'Y-m', $comp) == $time ):
		$date = date( 'F, Y', $comp );
	else:
		$date = $time;
	endif;

	$date = '<time class="publish-date" datetime="' . $time . '">' . $date
		  . '</time>';
endif;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php
$attr = array(
			'src'	=> $src,
			'class'	=> "attachment-$size",
			'alt'	=> trim(strip_tags( $attachment->post_excerpt )),
			'title'	=> trim(strip_tags( $attachment->post_title )),
		);
echo get_the_post_thumbnail( get_the_ID(), array( '96', '96' ), array( 'class' => 'img-circle img-responsive pull-right' ) );
?>
	<blockquote cite="#citation-<?php the_ID(); ?>">
	<?php
	the_content( __(
				     'Continue reading <span class="meta-nav">&rarr;</span>',
				     'fup'
				   	 ) ); ?>
	</blockquote>
	<p id="citation-<?php the_ID(); ?>" class="citation text-right"><?php
		if ( isset( $character ) ):
			echo $character;
			if ( isset( $work ) ):
				echo ' ' . __( ' from', 'fup' ) . " $work";
				if ( isset( $author ) ):
					echo " " . _e( ' by', 'fup' ) . " $author";
				endif;
				if ( isset( $date ) ):
					echo ", $date";
				endif;
			elseif ( isset( $author ) ):
				echo ' ' . _e( 'by', 'fup' ) . " $author";
				if ( isset( $date ) ):
					echo ", $date";
				endif;
			elseif ( isset( $date ) ):
				echo ", $date";
			endif;
		else:
			if ( isset( $author ) ):
				 echo $author;
				if ( isset( $work ) || isset( $date) ) echo ', ';
			endif;
			if ( isset( $work ) ):
				echo $work;
				if ( isset( $date ) ) echo ', ';
			endif;
			if ( isset( $date ) ) echo $date;
		endif;
		if ( isset( $meta['_fup_quote_blurb'] ) ):
			echo '<br><span class="comment-on-quote">' . $meta['_fup_quote_blurb'];
		endif;
				?>
	</p>
	<footer>
		<ul class="text-right list-unstyled"><li><?php
			_e( 'Posted on', 'fup'); ?> <a href="<?php the_permalink(); ?>" title="<?php
			echo esc_attr( sprintf(
									__( 'Permalink to this quote', 'fup' ),
									the_title_attribute( 'echo=0' )
									) );
			?>" rel="bookmark"><?php
			echo get_the_date(); ?></a></li>
			<?php if ( has_tag() ): ?>
				<li><?php
				_e( 'Tagged:', 'fup' ); ?> <?php echo get_the_tag_list( '', __( ', ', 'fup' ) ); ?>
				</li>
			<?php endif; ?>
		<?php if ( comments_open() ) : ?>
			<li class="comments-link">
				<?php
				comments_popup_link(
									 '<span class="leave-reply">'
								   . __( 'Leave a reply', 'fup' )
								   . '</span>',
									 __( '1 Reply', 'fup' ),
									 __( '% Replies', 'fup' )
									 ); ?>
			</li>
		<?php endif; // comments_open() ?>
		<?php
		edit_post_link(
						__( 'Edit', 'fup' ),
						'<li><span class="edit-link">',
						'</span></li>'
						); ?>
		</ul>



	</footer>
</article>
