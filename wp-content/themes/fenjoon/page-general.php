<?php
/*
Template Name: General
*/
get_header();
	get_sidebar();?><main class="main"><?php
	$the_query = fjn_template_query( array( 'post_type' => 'general' ) );
	if( $the_query->have_posts() ){
		$slug = $post->post_name;
		$t = get_term_by( 'slug', $slug, 'field' );?>
		<div class="cols">
			<div class="col col23">
				<div class="tile p2">
					<section>
						<h2><?php echo the_title();?></h2>
						<p class="justify mb2"><?php echo strip_tags( term_description( $t->term_id, 'field' ) );?></p><?php
							while( $the_query->have_posts() ){
								$the_query->the_post(); 
								if( has_term( $slug, 'field' ) ){?>
									<section class="mb2">
										<h3 class="icon backblue pr1 <?php echo $slug;?>"><?php the_title(); ?></h3><?php
										the_content();?>
									</section><?php
								}
							}wp_reset_postdata();?>
					</section>
				</div>
			</div><div class="col col13 last-child">
				<div class="tile p2"><?php
				$the_query = fjn_template_query( array( 'post_type' => array( 'modules', 'features', 'standards', 'general' ), 'tag' => $slug ) );
				if( $the_query->have_posts() ){
					while( $the_query->have_posts() ){ $the_query->the_post();?>
						<div class="icon center blue <?php echo ( 'general' == $post->post_type ? $slug : $post->post_type );?> size50 mtb2"></div>
						<p class="center"><?php the_title();?></p>
						<a class="button green mtb1" title="<?php echo $post->post_title;?>" href="<?php the_permalink();?>"><?php _e( 'Say more', 'fenjoon' );?></a><?php
					}wp_reset_postdata();
				}?>
				</div>
			</div>
		</div><?php
	}?>
	</main>
</div><?php
get_footer();?>