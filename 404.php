<?php
/**
 * Plantilla para la página 404 (No Encontrado).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

	<div id="primary" <?php generate_do_element_classes( 'content' ); ?>>
		<main id="main" <?php generate_do_element_classes( 'main' ); ?>>
			<?php
			do_action( 'generate_before_main_content' );
			?>

			<div class="inside-article">
				<div class="page-content">
					<header class="page-header">
						<h1 class="page-title"><?php esc_html_e( 'Número no encontrado', 'gp-denuncias-theme' ); ?></h1>
					</header>

					<p><?php esc_html_e( 'Lo sentimos, el número de teléfono que buscas no se encuentra en nuestra base de datos.', 'gp-denuncias-theme' ); ?></p>

					<?php
					$url_path = trim( parse_url( esc_url_raw( add_query_arg( array() ) ), PHP_URL_PATH ), '/' );
					$path_parts = explode( '/', $url_path );
					$numero_buscado_en_url = '';

					// Asume URL tipo: tusitio.com/numero/911234567/
					// 'numero' es el slug de reescritura de tu CPT
					if ( isset( $path_parts[0] ) && $path_parts[0] === 'numero' && isset( $path_parts[1] ) ) {
						$numero_buscado_en_url = sanitize_text_field( $path_parts[1] );
						echo '<p>' . sprintf( 
							esc_html__( 'Intentaste consultar: %s', 'gp-denuncias-theme' ), 
							'<strong>' . esc_html( $numero_buscado_en_url ) . '</strong>' 
						) . '</p>';
					}
					?>

					<p><strong><?php esc_html_e( '¿Quieres añadir este número y tu denuncia?', 'gp-denuncias-theme' ); ?></strong></p>
					<p>
						<?php
						// --- IMPORTANTE: MODIFICA ESTA LÍNEA ---
						// Cambia 'reportar-numero' por el slug real de tu página de envío de números.
						$url_pagina_envio = home_url('/reportar-numero/'); 

						if ( ! empty( $numero_buscado_en_url ) ) {
							// Opcional: pasar el número al formulario si tu plugin lo soporta
							$url_pagina_envio = add_query_arg( 'numero_reportado', urlencode( $numero_buscado_en_url ), $url_pagina_envio );
						}
						?>
						<a href="<?php echo esc_url( $url_pagina_envio ); ?>" class="button">
							<?php esc_html_e( 'Sí, añadir el número y mi denuncia', 'gp-denuncias-theme' ); ?>
						</a>
					</p>
					
					<p><?php esc_html_e( 'Alternativamente, puedes intentar una nueva búsqueda:', 'gp-denuncias-theme' ); ?></p>
					<?php 
					// Mostrar el formulario de búsqueda de la página principal
					// Esto es un poco más complejo, por ahora un get_search_form() genérico.
					// Si quieres el mismo formulario de front-page.php, tendríamos que hacerlo un template part.
					 get_search_form(); 
					?>

				</div>
			</div>

			<?php
			do_action( 'generate_after_main_content' );
			?>
		</main>
	</div>
	<?php
	do_action( 'generate_after_primary_content_area' );
	generate_construct_sidebars();
	get_footer();
	?>