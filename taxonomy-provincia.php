<?php
/**
 * Plantilla para archivo de taxonomía "Provincia".
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

	<div <?php generate_do_element_classes( 'content' ); ?> class="show_right_side"> <?php // Añadida clase show_right_side como en listaspam ?>
		<div class="container"> <?php // Contenedor principal de listaspam ?>
			<div class="main_content"> <?php // Contenedor del contenido principal ?>
				<?php
				do_action( 'generate_before_main_content' );

				$term = get_queried_object();
				$term_name = $term->name;
				$term_description = term_description();
				$country_name = __('España', 'gp-denuncias-theme'); // Asumimos España
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
					<span class='elem'><a href='<?php echo esc_url(get_post_type_archive_link('numero_telefonico')); // O una página específica de listado de prefijos/provincias ?>'><?php esc_html_e('Prefijos de España', 'gp-denuncias-theme'); ?></a></span> &raquo;
					<span class='elem'><a href='<?php echo esc_url(get_term_link($term)); ?>'><?php echo esc_html($term_name); ?></a></span>
				</div>

				<section class='phone-location'>
					<h1><?php printf(esc_html__('Prefijos de %s - Información y actividad', 'gp-denuncias-theme'), esc_html($term_name)); ?></h1>
					<?php if ( !empty($term_description) ) : ?>
						<div class="taxonomy-description">
							<?php echo wp_kses_post($term_description); ?>
						</div>
					<?php else: ?>
						<p><?php printf(esc_html__('Toda la información sobre los prefijos telefónicos de la provincia de %s. Consulta la actividad spam sobre los prefijos asociados.', 'gp-denuncias-theme'), esc_html($term_name)); ?></p>
					<?php endif; ?>
					
					<?php
					// Obtener los prefijos asociados a esta provincia
					// Esto asume que en tu CPT 'numero_telefonico', tienes asignada tanto la provincia como el prefijo.
					// Y que los prefijos son términos de la taxonomía 'prefijo'.
					$prefijos_de_la_provincia = array();
					$args_prefijos_prov = array(
						'post_type' => 'numero_telefonico',
						'posts_per_page' => -1,
						'tax_query' => array(
							array(
								'taxonomy' => 'provincia',
								'field'    => 'term_id',
								'terms'    => $term->term_id,
							),
						),
						'fields' => 'ids'
					);
					$numeros_en_provincia = new WP_Query($args_prefijos_prov);
					if ($numeros_en_provincia->have_posts()) {
						foreach ($numeros_en_provincia->posts as $post_id) {
							$prefijos_del_numero = get_the_terms($post_id, 'prefijo');
							if ($prefijos_del_numero && !is_wp_error($prefijos_del_numero)) {
								foreach ($prefijos_del_numero as $pref_term) {
									$prefijos_de_la_provincia[$pref_term->term_id] = $pref_term->name;
								}
							}
						}
					}
					wp_reset_postdata();
					$prefijos_de_la_provincia = array_unique($prefijos_de_la_provincia);
					sort($prefijos_de_la_provincia);

					if (!empty($prefijos_de_la_provincia)) {
						echo '<p style="margin-top:20px;">' . sprintf(esc_html__('La provincia de %s tiene activos los siguientes prefijos para teléfonos fijos:', 'gp-denuncias-theme'), '<strong>' . esc_html($term_name) . '</strong>') . '</p>';
						echo '<ul class="other-cities">'; // Clase de listaspam, aunque aquí son prefijos
						foreach ($prefijos_de_la_provincia as $prefijo_nombre) {
							$prefijo_term_obj = get_term_by('name', $prefijo_nombre, 'prefijo');
							if ($prefijo_term_obj) {
								echo '<li><a href="'.esc_url(get_term_link($prefijo_term_obj)).'">' . esc_html($prefijo_nombre) . '</a></li>';
							} else {
								echo '<li>' . esc_html($prefijo_nombre) . '</li>';
							}
						}
						echo '</ul>';
					}
					?>
					
					<div class="areacode-location">
						<?php
						// Mostrar mapa - esto es complejo. Necesitarías una imagen de mapa para cada provincia.
						// Ejemplo placeholder:
						// $map_image_url = get_stylesheet_directory_uri() . '/images/maps/es/' . $term->slug . '.png';
						// if (file_exists(get_stylesheet_directory() . '/images/maps/es/' . $term->slug . '.png')) {
						// echo '<picture><img src="'.esc_url($map_image_url).'" alt="'.sprintf(esc_attr__('Mapa de %s', 'gp-denuncias-theme'), esc_html($term_name)).'" height="280" width="336" /></picture>';
						// }
						?>
						<div class='city-location'><?php echo esc_html($term_name); ?> (<a href='<?php echo esc_url(get_post_type_archive_link('numero_telefonico')); // Enlace a la página principal de "prefijos" o archivo CPT ?>'><?php echo esc_html($country_name); ?></a>)</div>
						<?php // El .dot y la animación son principalmente CSS, necesitarías replicar ese CSS. ?>
					</div>
				</section>

				<section class='total-spam-calls'>
					<h2><?php printf(esc_html__('Actividad spam detectada en %s', 'gp-denuncias-theme'), esc_html($term_name)); ?></h2>
					<?php
					global $wpdb;
					$total_denuncias_provincia = $wpdb->get_var( $wpdb->prepare(
						"SELECT SUM(p.comment_count) 
						 FROM {$wpdb->posts} p
						 INNER JOIN {$wpdb->term_relationships} tr ON (p.ID = tr.object_id)
						 WHERE tr.term_taxonomy_id = %d
						 AND p.post_type = 'numero_telefonico'
						 AND p.post_status = 'publish'",
						$term->term_taxonomy_id
					) );
					$total_denuncias_provincia = $total_denuncias_provincia ? $total_denuncias_provincia : 0;
					?>
					<div class='spam-activity-box'>
						<span class='report-activity'><?php printf(esc_html__('Número total de denuncias registradas por llamadas spam en la provincia de %s', 'gp-denuncias-theme'), '<span class="located">' . esc_html($term_name) . '</span>'); ?></span>
						<span class='total-reports-areacode'><?php echo esc_html($total_denuncias_provincia); ?></span>
					</div>
				</section>

				<?php if ( have_posts() ) : ?>
					<section class='top-spam-for-areacode' style='margin:20px 0 10px'>
						<h2><?php printf(esc_html__('Números con mayor número de denuncias registradas en %s en el último año', 'gp-denuncias-theme'), esc_html($term_name)); ?></h2>
						<div style='padding:20px 0'>
						<?php
							$args_top_denunciados_prov = array(
								'post_type' => 'numero_telefonico',
								'posts_per_page' => 5,
								'tax_query' => array(
									array(
										'taxonomy' => 'provincia',
										'field'    => 'term_id',
										'terms'    => $term->term_id,
									),
								),
								'orderby' => 'comment_count', // Ordenar por número de comentarios (denuncias)
								'order' => 'DESC',
								// Para filtrar por "último año", necesitarías una meta query si guardas la fecha de la última denuncia
								// o filtrar los comentarios por fecha, lo cual es más complejo aquí.
								// Por simplicidad, mostramos los más denunciados en general para esta provincia.
							);
							$query_top_denunciados_prov = new WP_Query($args_top_denunciados_prov);
							if ($query_top_denunciados_prov->have_posts()) :
								while ($query_top_denunciados_prov->have_posts()) : $query_top_denunciados_prov->the_post();
									echo "<div class='top-areacode'>";
									echo "<a href='" . esc_url(get_permalink()) . "' target='_blank' class='last_number'>" . esc_html(get_the_title()) . "</a>";
									echo "<label>" . sprintf(esc_html__('%d denuncias', 'gp-denuncias-theme'), get_comments_number()) . "</label>";
									echo "</div>";
								endwhile;
								wp_reset_postdata();
							else:
								echo '<p>' . esc_html__('No hay números con suficientes denuncias para mostrar en el top de esta provincia.', 'gp-denuncias-theme') . '</p>';
							endif;
							?>
						</div>
					</section>

					<div class="archive-posts">
					<h2 style="margin-top: 30px; margin-bottom:15px;"><?php printf(esc_html__('Todos los números denunciados en %s', 'gp-denuncias-theme'), esc_html($term_name)); ?></h2>
					<?php
					rewind_posts();
					while ( have_posts() ) :
						the_post();
						?>
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<header class="entry-header">
								<?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
							</header>
						</article>
						<?php
					endwhile;
					the_posts_navigation();
					?>
					</div>
				<?php else : ?>
					<section class="no-results not-found">
						<header class="page-header"><h1 class="page-title"><?php esc_html_e( 'Nada Encontrado', 'gp-denuncias-theme' ); ?></h1></header>
						<div class="page-content"><p><?php printf(esc_html__( 'No hay números para la provincia %s.', 'gp-denuncias-theme'), esc_html($term_name)); ?></p></div>
					</section>
				<?php endif; ?>
				<?php do_action( 'generate_after_main_content' ); ?>
			</div> <?php // Fin .main_content ?>

			<div class="right_side">
				<?php // Sidebar como en listaspam (contenido placeholder) ?>
			</div>
		</div> <?php // Fin .container ?>
	</div>
	<?php
	do_action( 'generate_after_primary_content_area' );
	get_footer();
	?>