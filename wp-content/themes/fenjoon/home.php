<?php get_header();
	get_sidebar();?><main class="main"><?php
	$second_query = fjn_template_query( array( 'post_type' => 'general' ) );
	if( $second_query->have_posts() ){
		$term_ids = array( 'about' => '', 'difference' => '', 'offered-services' => '', 'unoffered-services' => '', 'responsibility' => '' );
		$title = array( 'about' => __( 'About us', 'fenjoon' ), 'difference' => __( 'Our difference', 'fenjoon' ), 'offered-services' => __( 'Services we offer', 'fenjoon' ), 'unoffered-services' => __( 'Services we do not offer', 'fenjoon' ), 'responsibility' => __( 'Public responsibility', 'fenjoon' ) );
		foreach( $term_ids as $term => $id ){
			$t = get_term_by( 'slug', $term, 'field' );?>
			<div class="cols">
				<div class="col col23">
					<div class="tile p2">
						<section>
							<h2><?php echo $title[ $term ];?></h2>
							<ul><?php
								while( $second_query->have_posts() ){
									$second_query->the_post(); 
									if( has_term( $term, 'field' ) ){?>
										<li class="icon blue <?php echo $term;?>"><?php the_title(); ?></li><?php
									}
								}?>
							</ul>
						</section>
					</div><?php rewind_posts();?>					
				</div><div class="col col13 last-child">
					<div class="tile p2">
						<div class="icon center blue <?php echo $term;?> size50 mtb2"></div>
						<p class="justify"><?php echo strtok( strip_tags( term_description( $t->term_id, 'field' ) ), '.' ) . '.';?></p>
						<a class="button green mtb1" title="<?php echo $title[ $term ]; ?>" href="<?php echo home_url( $term );?>"><?php _e( 'Say more', 'fenjoon' );?></a>
					</div>
				</div>
			</div><?php
		}
	}?>
	</main>
</div>
<div class="full backgreen">
	<div class="wrapper">
		<div class="cols">
			<div class="col col11 center">
				<p class="size5 mt3 mb2"><?php
					_e( 'Push this new order button right now!', 'fenjoon' );?>
				</p>
				<a class="button link blue prl2 mb3" href="<?php echo home_url( 'order' );?>"><?php _e( 'Register new order', 'fenjoon' );?></a>
			</div>
		</div>
	</div>
</div>
<div class="wrapper">
	<div class="main full"><?php
	$third_query = fjn_template_query( array( 'post_type' => 'portfolio' ) );
	if ($third_query->have_posts()){
		?>
		<div class="cols">
			<section>
				<h2><?php _e( 'Portfolio', 'fenjoon' );?></h2>
				<div class="row hightop">
					<div class="col col14 tile p2"><?php
					while ($third_query->have_posts()){ $third_query->the_post();
						$metadata = get_post_meta( $post->ID );?>
						<a class="thumb" href="<?php the_permalink();?>" title="<?php the_title_attribute(); ?>"><?php
							if( has_post_thumbnail() ){
								$attr = array(
									'alt' => trim( strip_tags( get_the_title() ) )
								);
								the_post_thumbnail( 'portfolio', $attr );
							}else{?>
								<img src="<?php echo THEME_URI;?>/img/portfolio.png" alt="<?php echo trim( strip_tags( get_the_title() ) );?>"><?php
							}?>
						</a>
						<ul><?php
						foreach( $metadata as $key => $value ){
							if( '_' == substr( $key, 0, 1 ) ) continue;?>
							<li class="icon"><span class="right"><?php _e( $key, 'fenjoon' );?></span><span class="left"><?php echo $value[0];?></span></li><?php
						}?>
						</ul><?php
						if( ( $third_query->current_post + 2 ) < ( $third_query->post_count ) ){?>
							</div><!-- --><div class="col col14 tile p2"><?php						
						}elseif( ( $third_query->current_post + 2 ) == ( $third_query->post_count ) ){?>
							</div><!-- --><div class="col col14 tile p2 last-child"><?php						
						}
					}?>
					</div>
				</div>
			</section><?php wp_reset_postdata();?>
		</div><?php
	}?>
	</div>
</div>
<?php rewind_posts();
get_footer();?>