<?php get_header();
	get_sidebar();?><main class="main"><?php
	if( have_posts() ){
		while( have_posts() ){the_post();?>
		<div class="cols">
			<div class="col col23">
				<div class="tile p2">
					<section>
						<h2><?php the_title();?></h2><?php
						the_content();?>
					</section>
				</div>
			</div><div class="col col13 last-child">
				<div class="tile p2"><?php
				$the_query = fjn_template_query( array( 'post_type' => $post->post_type, 'orderby' => 'rand', 'posts_per_page' => 5 ) );
				if( $the_query->have_posts() ){
					while( $the_query->have_posts() ){ $the_query->the_post();?>
						<div class="icon center blue <?php echo $post->post_type;?> size50 mtb2"></div>
						<p class="center"><?php the_title();?></p>
						<a class="button green mtb1" title="<?php echo $post->post_title;?>" href="<?php the_permalink();?>"><?php _e( 'Say more', 'fenjoon' );?></a><?php
					}wp_reset_postdata();
				}?>
				</div>
			</div>
		</div><?php
		}
	}?>
	</main>
</div><?php
get_footer();?>