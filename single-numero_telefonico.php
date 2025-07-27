<?php
/**
 * Plantilla para mostrar un solo "Número Telefónico".
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

	<div <?php generate_do_element_classes( 'content' ); ?>>
		<main <?php generate_do_element_classes( 'main' ); ?>>
			<?php
			do_action( 'generate_before_main_content' );

			while ( have_posts() ) :
				the_post();
				$current_post_id = get_the_ID();
				?>

				<article id="post-<?php echo esc_attr($current_post_id); ?>" <?php post_class('numero-telefonico-single-article'); ?>>
					<?php // No necesitamos un <header class="entry-header"> separado aquí, el h1 está arriba ?>

					<h1 class="entry-title page-title search-page-h1"> <?php // Clases de listaspam para el H1 ?>
						<?php
						echo sprintf(
							esc_html__( '¿Quién me llama del %s?', 'gp-denuncias-theme' ),
							'<strong>' . get_the_title() . '</strong>'
						);
						?>
					</h1>

					<?php // Mensaje de advertencia (similar a listaspam)
						// Este mensaje podría ser dinámico basado en el número de denuncias o una valoración.
						// Por ahora, un mensaje estático si hay denuncias.
						$numero_denuncias = get_comments_number($current_post_id);
						if ( $numero_denuncias > 0 ) { // Podrías ajustar este umbral
							echo '<div class="message_box">'; // Clase de listaspam
								echo '<div class="alert_msg">'; // Clase de listaspam
									echo '<span class="alert-icon-big">⚠️</span>'; // Icono de listaspam
									echo '<span class="alert_txt">' . sprintf(
										esc_html__('Cuidado, hemos registrado más de %d llamadas desde este número de teléfono y podría tratarse de una llamada spam. Antes de contestar descubre quién te llama.', 'gp-denuncias-theme'),
										esc_html($numero_denuncias)
									) . '</span>';
								echo '</div>';
							echo '</div>';
						} else {
							// Mensaje alternativo si no hay denuncias aún
							echo '<div class="message_box">';
								echo '<div class="info_msg">'; // Podrías crear una clase .info_msg con estilos diferentes
								echo '<span class="alert-icon-big">ℹ️</span>';
								echo '<span class="alert_txt">' . esc_html__('Este número aún no tiene denuncias. Si te ha llamado, sé el primero en compartir tu experiencia.', 'gp-denuncias-theme') . '</span>';
								echo '</div>';
							echo '</div>';
						}
					?>

					<section class="number_data_box"> <?php // Clase de listaspam ?>
						<div class="data_top"> <?php // Clase de listaspam ?>
							<div class="right-data"> <?php // Clase de listaspam ?>
								<div class="rate-and-owner">
									<?php /* Aquí podrías poner una valoración si la implementas */ ?>
								</div>
								<div class="phone_info"> <?php // Clase de listaspam ?>
									<?php
									$field_obj = get_field_object('tipo_telefono', $current_post_id);
									$value = $field_obj['value'];
									$label = $field_obj['choices'][ $value ];

									if( $value ) {
										echo '<div class="type_of_call">' . esc_html( $label ) . '</div>';
									} else {
										echo '<div class="type_of_call">' . esc_html__('No especificado', 'gp-denuncias-theme') . '</div>';
									}
									?>
								</div>
							</div>
						</div>

						<div class="data_extra"> <?php // Clase de listaspam ?>
							<div>
								<label><?php esc_html_e( 'BÚSQUEDAS', 'gp-denuncias-theme' ); ?></label>
								<div class="result">
									<?php echo esc_html( gp_denuncias_get_and_update_view_count( $current_post_id ) ); ?>
								</div>
							</div>
							<div>
								<label><?php esc_html_e( 'ÚLTIMA BÚSQUEDA', 'gp-denuncias-theme' ); ?></label>
								<div class="result">
									<time datetime='<?php echo esc_attr(get_the_modified_date('c', $current_post_id)); ?>'>
										<?php echo sprintf( esc_html__( '%s hace', 'gp-denuncias-theme' ), human_time_diff( get_the_modified_date('U', $current_post_id) ) ); ?>
									</time>
								</div>
							</div>
							<div>
								<label><?php esc_html_e( 'DENUNCIAS', 'gp-denuncias-theme' ); ?></label>
								<div class="result">
									<a href="#comments"><?php echo esc_html( get_comments_number( $current_post_id ) ); ?></a>
								</div>
							</div>
						</div>

						<div class="data_location"> <?php // Clase de listaspam ?>
							<img src="<?php echo get_stylesheet_directory_uri() . '/images/flag-es.png'; ?>" width="20" height="10" alt="<?php esc_attr_e('es', 'gp-denuncias-theme'); ?>" decoding="async" />
							&nbsp;
							<span>
							<?php
							$provincia_nombre = ''; $prefijo_output = '';
							$provincias = get_the_terms( $current_post_id, 'provincia' );
							if ( $provincias && !is_wp_error($provincias) ) $provincia_nombre = $provincias[0]->name;

							$prefijos = get_the_terms( $current_post_id, 'prefijo' );
							if ( $prefijos && !is_wp_error($prefijos) ) {
								$prefijo_obj = $prefijos[0];
								$prefijo_output = '<a href="' . esc_url(get_term_link($prefijo_obj)) . '">' . sprintf(esc_html__('Prefijo %s', 'gp-denuncias-theme'), esc_html($prefijo_obj->name)) . '</a>';
							}

							if ($provincia_nombre) echo esc_html($provincia_nombre) . ', España';
							if ($prefijo_output) echo ($provincia_nombre ? ' - ' : '') . $prefijo_output;
							if (empty($provincia_nombre) && empty($prefijo_output)) echo esc_html__('Ubicación no especificada', 'gp-denuncias-theme');
							?>
							</span>
						</div>
						<?php /* Aquí podrían ir otros datos como la compañía si los tienes */ ?>
					</section> <?php // Fin .number_data_box ?>


					<div class="add_comment"> <?php // Clase de listaspam ?>
						<a href="#denuncia" class="denunciar-este-numero-btn-listaspam"> <?php // Nueva clase para el botón ?>
							<img width="20" height="20" src="<?php echo get_stylesheet_directory_uri(); ?>/images/warning-icon-white.svg" alt="<?php esc_attr_e('warning', 'gp-denuncias-theme'); ?>" loading="lazy"> <?php // Icono de listaspam ?>
							<?php esc_html_e('Denunciar este teléfono', 'gp-denuncias-theme'); ?>
						</a>
					</div>

					<?php // Aquí iría el anuncio <div class="snigelAdHorizontal"> si lo implementas ?>


					<section id="report_phone_number" class="write_comment"> <?php // Clase de listaspam ?>
						<h2><?php esc_html_e('Denuncia las llamadas indeseadas', 'gp-denuncias-theme'); ?></h2>
						<p><?php esc_html_e('No te quedes sin saber quién te llama por teléfono. Escribe un comentario y cuéntanos tu problema con el', 'gp-denuncias-theme'); ?> <strong><?php echo esc_html(get_the_title()); ?></strong>. <?php esc_html_e('Te ayudaremos a saber quién es y cómo detener sus llamadas para siempre. Tenemos una gran comunidad de usuarios que seguro te ayudarán.', 'gp-denuncias-theme'); ?></p>
						<a id="denuncia"></a>
						<?php
						// El formulario de comentarios de WordPress se mostrará más abajo con comments_template().
						// Aquí podrías poner un texto o guía adicional si es necesario antes del formulario.
						?>
					</section>


					<?php
					// Contenido del editor principal (si lo usas para info adicional)
					$post_content_check = get_post_field('post_content', $current_post_id);
					if ( !empty(trim($post_content_check)) ) {
						echo '<div class="entry-content numero-entry-content">'; // Mantén tus clases si tienes CSS específico
						the_content();
						echo '</div>';
					}
					?>

					<?php
					// Mensaje si no hay contenido ni comentarios (similar al aviso de listaspam)
					if ( empty(trim($post_content_check)) && get_comments_number($current_post_id) == 0 ) {
						echo '<div class="aviso-primer-comentario-wrapper">'; // Mantén tu clase
						echo '<p class="aviso-primer-comentario">' . esc_html__('Aún no hay denuncias para este número. ¡Sé el primero en añadir tu experiencia!', 'gp-denuncias-theme') . '</p>';
						echo '</div>';
					}

					// Sección de comentarios (denuncias)
					if ( comments_open($current_post_id) || get_comments_number($current_post_id) ) :
						// Adaptar el título del formulario de comentarios
						add_filter('comment_form_defaults', 'gp_denuncias_comment_form_defaults');
						comments_template();
						remove_filter('comment_form_defaults', 'gp_denuncias_comment_form_defaults');
					endif;


					// --- INICIO SECCIÓN NÚMEROS RELACIONADOS (Otros números potencialmente peligrosos) ---
					$provincias_actuales_related = get_the_terms( $current_post_id, 'provincia' );
					if ( $provincias_actuales_related && ! is_wp_error( $provincias_actuales_related ) ) {
						$primera_provincia_related = $provincias_actuales_related[0];

						// Obtener números de la misma provincia, excluyendo el actual, orden aleatorio
						$args_relacionados = array(
							'post_type'      => 'numero_telefonico',
							'posts_per_page' => 9, // Cantidad similar a listaspam
							'post__not_in'   => array( $current_post_id ),
							'orderby'        => 'rand', // Aleatorio
							'tax_query'      => array(
								array(
									'taxonomy' => 'provincia',
									'field'    => 'term_id',
									'terms'    => $primera_provincia_related->term_id,
								),
							),
						);
						$query_relacionados = new WP_Query( $args_relacionados );

						if ( $query_relacionados->have_posts() ) :
							echo '<section class="last_search">'; // Reutiliza clase de la home para estilo similar
							echo '<h3>' . sprintf( esc_html__( 'Otros números de teléfono potencialmente peligrosos de %s', 'gp-denuncias-theme' ), esc_html( $primera_provincia_related->name ) ) . '</h3>';
							echo '<div class="container">'; // Contenedor para los números
								while ( $query_relacionados->have_posts() ) : $query_relacionados->the_post();
									echo '<a href="' . esc_url( get_permalink() ) . '" target="_blank" class="last_number">'; // Enlace con clase de listaspam
										echo esc_html( get_the_title() );
									echo '</a>';
								endwhile;
							echo '</div>'; // Fin .container
							echo '</section>';
							wp_reset_postdata();
						endif;
					}
					// --- FIN SECCIÓN NÚMEROS RELACIONADOS ---
					?>
				</article>
			<?php
			endwhile;
			do_action( 'generate_after_main_content' );
			?>
		</main>
	</div>

	<?php
	do_action( 'generate_after_primary_content_area' );
	// generate_construct_sidebars(); // Comentado para asegurar no sidebar
	get_footer();
	?>