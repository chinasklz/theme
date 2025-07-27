<?php
/**
 * Plantilla para archivo de taxonomía "Prefijo".
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

	<div <?php generate_do_element_classes( 'content' ); ?>>
		<main <?php generate_do_element_classes( 'main' ); ?>>
			<div class="container">
				<?php
				do_action( 'generate_before_main_content' );

				$term = get_queried_object();
				$term_name = $term->name;
				$term_description = term_description();
				?>
				<script type="application/ld+json">
				{
					"@context":"https://schema.org",
					"@type":"BreadcrumbList",
					"itemListElement":[
						{"@type":"ListItem","position":1,"name":"<?php echo esc_attr__('Prefijos de España', 'gp-denuncias-theme'); ?>","item":"<?php echo esc_url(get_post_type_archive_link('numero_telefonico')); ?>"},
						{"@type":"ListItem","position":2,"name":"<?php echo esc_attr($term_name); ?>","item":"<?php echo esc_url(get_term_link($term)); ?>"}
					]
				}
				</script>

				<div class='breadcrumps' style="margin-top:20px;">
					<span class='elem'><a href='<?php echo esc_url(get_post_type_archive_link('numero_telefonico')); // O una página específica de listado de prefijos si la tienes ?>'><?php esc_html_e('Prefijos de España', 'gp-denuncias-theme'); ?></a></span> &raquo;
					<span class='elem'><a href='<?php echo esc_url(get_term_link($term)); ?>'><?php echo esc_html($term_name); ?></a></span>
				</div>

				<section class='phone-location'>
					<h1><?php printf(esc_html__('Prefijo %s - Información y actividad', 'gp-denuncias-theme'), esc_html($term_name)); ?></h1>
					<?php if ( !empty($term_description) ) : ?>
						<div class="taxonomy-description">
							<?php echo wp_kses_post($term_description); ?>
						</div>
					<?php else: ?>
						<p><?php printf(esc_html__('Información sobre el prefijo telefónico %s. Consulta la actividad spam y denuncias relacionadas con este prefijo.', 'gp-denuncias-theme'), esc_html($term_name)); ?></p>
					<?php endif; ?>
					
					<?php
					// Intentar obtener la provincia asociada a este prefijo (si la lógica existe en functions.php o ACF)
					$provincia_asociada_nombre = '';
					// Asumimos que tienes un campo ACF 'provincia_asociada_al_prefijo' en la taxonomía 'prefijo'
					// que devuelve un objeto de término de la taxonomía 'provincia'.
					$provincia_term_obj = get_field('provincia_asociada_al_prefijo', 'prefijo_' . $term->term_id);
					if ($provincia_term_obj && isset($provincia_term_obj->name)) {
						$provincia_asociada_nombre = $provincia_term_obj->name;
					}

					if (!empty($provincia_asociada_nombre)) {
						echo '<div class="areacode-location">';
						// Aquí podrías intentar mostrar una imagen de mapa si la tienes para la provincia
						// Ejemplo: <img src='...' alt='mapa de ".esc_attr($provincia_asociada_nombre)."' />
						echo '<div class="city-location">' . esc_html($provincia_asociada_nombre) . ' (<a href="' . esc_url(get_post_type_archive_link('numero_telefonico')) . '">' . esc_html__('España', 'gp-denuncias-theme') . '</a>)</div>';
						echo '</div>';
						// El .dot y animaciones CSS son más complejos de replicar directamente sin JS/CSS específico.
					}
					?>
				</section>

				<section class='total-spam-calls'>
					<h2><?php printf(esc_html__('Actividad spam detectada para el prefijo %s', 'gp-denuncias-theme'), esc_html($term_name)); ?></h2>
					<?php
					global $wpdb;
					$total_denuncias_prefijo = $wpdb->get_var( $wpdb->prepare(
						"SELECT SUM(p.comment_count) 
						 FROM {$wpdb->posts} p
						 INNER JOIN {$wpdb->term_relationships} tr ON (p.ID = tr.object_id)
						 WHERE tr.term_taxonomy_id = %d
						 AND p.post_type = 'numero_telefonico'
						 AND p.post_status = 'publish'",
						$term->term_taxonomy_id
					) );
					$total_denuncias_prefijo = $total_denuncias_prefijo ? $total_denuncias_prefijo : 0;
					?>
					<div class='spam-activity-box'>
						<span class='report-activity'><?php printf(esc_html__('Número total de denuncias registradas para teléfonos que comienzan con %s:', 'gp-denuncias-theme'), esc_html($term_name)); ?></span>
						<span class='total-reports-areacode'><?php echo esc_html($total_denuncias_prefijo); ?></span>
					</div>
				</section>

				<?php if ( have_posts() ) : ?>
					<section class='top-spam-for-areacode' style='margin:20px 0 10px'>
						<h2><?php printf(esc_html__('Números con prefijo %s con mayor número de denuncias', 'gp-denuncias-theme'), esc_html($term_name)); ?></h2>
						<div style='padding:20px 0'>
							<?php
							// Re-hacer la query para mostrar los posts ordenados por comment_count
							$args_top_denunciados_prefijo = array(
								'post_type' => 'numero_telefonico',
								'posts_per_page' => 5, // Mostrar los 5 más denunciados
								'tax_query' => array(
									array(
										'taxonomy' => 'prefijo',
										'field'    => 'term_id',
										'terms'    => $term->term_id,
									),
								),
								'orderby' => 'comment_count',
								'order' => 'DESC'
							);
							$query_top_denunciados = new WP_Query($args_top_denunciados_prefijo);
							if ($query_top_denunciados->have_posts()) :
								while ($query_top_denunciados->have_posts()) : $query_top_denunciados->the_post();
									echo "<div class='top-areacode'>"; // Clase de listaspam
									echo "<a href='" . esc_url(get_permalink()) . "' target='_blank' class='last_number'>" . esc_html(get_the_title()) . "</a>";
									echo "<label>" . sprintf(esc_html__('%d denuncias', 'gp-denuncias-theme'), get_comments_number()) . "</label>";
									echo "</div>";
								endwhile;
								wp_reset_postdata();
							else:
								echo '<p>' . esc_html__('No hay números con suficientes denuncias para mostrar en el top.', 'gp-denuncias-theme') . '</p>';
							endif;
							?>
						</div>
					</section>

					<div class="archive-posts"> <?php // Mantén tu clase para la lista principal si tienes CSS ?>
					<h2 style="margin-top: 30px; margin-bottom:15px;"><?php printf(esc_html__('Todos los números denunciados con el prefijo %s', 'gp-denuncias-theme'), esc_html($term_name)); ?></h2>
					<?php
					// Reiniciar el loop principal para mostrar todos los posts paginados
					rewind_posts(); 
					while ( have_posts() ) :
						the_post();
						?>
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<header class="entry-header">
								<?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
								<?php // Podrías añadir un extracto o el número de denuncias aquí también ?>
							</header>
						</article>
						<?php
					endwhile;
					the_posts_navigation(); // Paginación
					?>
					</div>
				<?php else : ?>
					<section class="no-results not-found">
						<header class="page-header"><h1 class="page-title"><?php esc_html_e( 'Nada Encontrado', 'gp-denuncias-theme' ); ?></h1></header>
						<div class="page-content"><p><?php printf(esc_html__( 'No hay números para el prefijo %s.', 'gp-denuncias-theme' ), esc_html($term_name)); ?></p></div>
					</section>
				<?php endif; ?>
				<?php do_action( 'generate_after_main_content' ); ?>
			</div>
		</main>
	</div>
	<?php
	do_action( 'generate_after_primary_content_area' );
	// generate_construct_sidebars(); // Comentado para forzar no-sidebar si es necesario, aunque la estructura de listaspam tiene una.
	get_footer();
	?>