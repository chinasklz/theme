<?php
/**
 * Plantilla para archivo del CPT "Número Telefónico".
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

	<div <?php generate_do_element_classes( 'content' ); ?>>
		<main <?php generate_do_element_classes( 'main' ); ?>>
			<?php
			do_action( 'generate_before_main_content' );

			if ( have_posts() ) :
				echo '<header class="page-header">';
				post_type_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="taxonomy-description">', '</div>' );
				echo '</header>';
				?>
				<div class="archive-posts">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<header class="entry-header">
							<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
						</header>
						<div class="entry-summary">
							<?php
							// Opcional: Mostrar campos ACF o taxonomías
							// $compania = get_field('compania_telefonica');
							// if ( $compania ) {
							//	 echo '<p><strong>Compañía:</strong> ' . esc_html( $compania ) . '</p>';
							// }
							// $provincias = get_the_terms( get_the_ID(), 'provincia' );
							// if ( $provincias && ! is_wp_error( $provincias ) ) {
							//	 $provincia_links = array();
							//	 foreach ( $provincias as $term ) { $provincia_links[] = $term->name; }
							//	 echo '<p><strong>Provincia(s):</strong> ' . implode( ', ', $provincia_links ) . '</p>';
							// }
							?>
						</div>
					</article>
					<?php
				endwhile;
				the_posts_navigation();
				?>
				</div>
				<?php
			else :
				?>
				<section class="no-results not-found">
					<header class="page-header"><h1 class="page-title"><?php esc_html_e( 'Nada Encontrado', 'gp-denuncias-theme' ); ?></h1></header>
					<div class="page-content"><p><?php esc_html_e( 'No hay números publicados.', 'gp-denuncias-theme' ); ?></p></div>
				</section>
				<?php
			endif;
			do_action( 'generate_after_main_content' );
			?>
		</main>
	</div>
	<?php
	do_action( 'generate_after_primary_content_area' );
	generate_construct_sidebars();
	get_footer();
	?>