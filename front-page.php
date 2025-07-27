<?php
/**
 * Plantilla para la Página Principal (Front Page).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

<?php // --- INICIO DE LA NUEVA SECCIÓN FRONTAL HERO --- ?>
<section class="head main_gradient">
	<div class="bg_main">
		<div class="container">
			<?php
			// Mostrar el logo personalizado si existe, o el título del sitio.
			$logo_escudo_url = get_stylesheet_directory_uri() . '/images/logo-escudo-listaspam.png'; // Debes añadir esta imagen
			if (file_exists(get_stylesheet_directory() . '/images/logo-escudo-listaspam.png')) {
				echo '<img class="shield_img" src="' . esc_url($logo_escudo_url) . '" alt="' . esc_attr(get_bloginfo('name')) . ' logo" />';
			} elseif ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
				the_custom_logo();
			} else {
				echo '<p class="site-title frontal-site-title"><a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . get_bloginfo( 'name' ) . '</a></p>';
			}
			?>
			<h1><?php esc_html_e( '¿Quién me llama?', 'gp-denuncias-theme' ); ?></h1>
			<form role="search" method="get" id="searchform_telefonico_frontal" class="search_container" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<input type="hidden" name="post_type" value="numero_telefonico" />
				<input type="tel" id="Telefono" name="s" placeholder="<?php esc_attr_e( 'Buscar teléfono...', 'gp-denuncias-theme' ); ?>" maxlength="17" required />
				<button type="submit" id="search_submit">
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/search-icon.svg" width="24" height="24" alt="<?php esc_attr_e( 'Buscar', 'gp-denuncias-theme' ); ?>">
				</button>
			</form>
		</div>
	</div>
</section>
<?php // --- FIN DE .frontal-hero --- ?>

<div <?php generate_do_element_classes( 'content' ); ?>>
	<main <?php generate_do_element_classes( 'main' ); ?>>
		<?php
		do_action( 'generate_before_main_content' );
		?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="inside-article">

				<script type="text/javascript">
						document.addEventListener('DOMContentLoaded', function() {
							const searchFormFrontal = document.getElementById('searchform_telefonico_frontal');
							if (searchFormFrontal) {
								searchFormFrontal.addEventListener('submit', function(event) {
									event.preventDefault();
									const numeroBuscado = document.getElementById('Telefono').value.trim();
									if (numeroBuscado) {
										const numeroLimpio = numeroBuscado.replace(/[^0-9]/g, '');
										if (numeroLimpio) {
											// Redirige a la URL del CPT directamente
											window.location.href = '<?php echo esc_url( home_url( "/numero/" ) ); ?>' + encodeURIComponent(numeroLimpio) + '/';
										} else {
											alert('<?php esc_html_e( 'Por favor, introduce un número de teléfono válido.', 'gp-denuncias-theme' ); ?>');
										}
									} else {
										alert('<?php esc_html_e( 'Por favor, introduce un número de teléfono.', 'gp-denuncias-theme' ); ?>');
									}
								});
							}
						});
					</script>

					<?php
					// --- INICIO PARTE 3: CAJA DE TEXTO ENRIQUECIDO ---
					echo '<section class="text_ini">';
						echo '<div class="container">';
							echo '<h2 class="home-texto-titulo">'; // Se mantiene la clase para posible CSS existente
							echo esc_html( get_theme_mod( 'home_texto_titulo_setting', __( '¿Qué es ' . get_bloginfo('name') . ' y cómo saber quién me llama?', 'gp-denuncias-theme' ) ) );
							echo '</h2>';
							echo '<div class="home-texto-contenido">'; // Se mantiene la clase para posible CSS existente
							// Contenido por defecto más parecido a listaspam
							$default_home_text = '<p><strong>' . get_bloginfo('name') . '</strong> ' . __( 'es un servicio gratuito en el que no es necesario registrarse destinado a realizar búsquedas de teléfono inversas, es decir, no buscar el teléfono de una empresa en particular, sino buscar a quién realmente pertenece un número de teléfono en concreto, descubrir cuales son sus verdaderas intenciones y cómo detener sus llamadas si es necesario.', 'gp-denuncias-theme' ) . '</p>';
							$default_home_text .= '<p>' . __( 'Somos el directorio líder de empresas de telemarketing en España y Latinoamérica, con más de X millones de números de spam telefónico identificados (actualiza esta cifra).', 'gp-denuncias-theme' ) . '</p>';
							// Aquí podrías añadir un enlace a una app si la tienes, como en listaspam
							$default_home_text .= '<p>' . __( 'Antes de contestar o devolver cualquier llamada a números de teléfono desconocidos o sospechosos, siempre recomendamos la búsqueda en nuestra web, para saber en todo momento quién te llama y qué se esconde detrás de esa llamada.', 'gp-denuncias-theme' ) . '</p>';
							$default_home_text .= '<p>' . __( 'Simplemente dinos qué número te llama, cuéntanos tu experiencia con ese teléfono tan molesto y nosotros te decimos quién es y cómo hacer que deje de llamarte. ¡Así de fácil! Y lo más importante... ¡GRATIS!', 'gp-denuncias-theme' ) . '</p>';
							echo wp_kses_post( get_theme_mod( 'home_texto_contenido_setting', $default_home_text ) );
							echo '</div>';
							// Aquí iría el bloque de anuncios si lo implementas. Ejemplo:
							// echo '<div style="min-height:250px;text-align:center; margin-top:20px;">';
							// echo '<!-- Aquí tu código de anuncio -->';
							// echo '</div>';
						echo '</div>';
					echo '</section>';
					// --- FIN PARTE 3 ---

					// --- INICIO PARTE "ÚLTIMAS NOTICIAS" ---
					echo '<section class="blog">';
						echo '<div class="container">';
							echo '<h2>' . esc_html__( 'Últimas noticias', 'gp-denuncias-theme' ) . '</h2>';
							echo '<div class="article-list">'; // Contenedor para las noticias

							// Query para obtener las últimas entradas del blog (post type 'post')
							// Si tienes un CPT para noticias, cámbialo aquí.
							$args_noticias = array(
								'post_type'      => 'post', // O tu CPT de noticias
								'posts_per_page' => 3,      // Mostrar 3 noticias
								'orderby'        => 'date',
								'order'          => 'DESC',
							);
							$query_noticias = new WP_Query( $args_noticias );

							if ( $query_noticias->have_posts() ) :
								while ( $query_noticias->have_posts() ) : $query_noticias->the_post();
									echo '<article class="news_content">';
										echo '<header class="news_header">';
											echo '<div class="img_container">';
												if ( has_post_thumbnail() ) {
													echo '<a href="' . esc_url( get_permalink() ) . '" target="_blank">' . get_the_post_thumbnail( get_the_ID(), 'thumbnail' ) . '</a>'; // 'thumbnail' o el tamaño que definas
												} else {
													// Imagen placeholder si no hay destacada
													echo '<a href="' . esc_url( get_permalink() ) . '" target="_blank"><img src="' . get_stylesheet_directory_uri() . '/images/placeholder-news.png" alt="'.esc_attr(get_the_title()).'" width="120" height="120"></a>';
												}
											echo '</div>';
											echo '<div class="header_txt">';
												echo '<a href="' . esc_url( get_permalink() ) . '" target="_blank"><h3>' . esc_html( get_the_title() ) . '</h3></a>';
											echo '</div>';
										echo '</header>';
										echo '<div class="news_desc">';
											echo '<p>' . wp_kses_post( wp_trim_words( get_the_excerpt(), 30, '...' ) ) . '</p>'; // Limita el extracto
										echo '</div>';
										echo '<footer class="news_footer">';
											echo '<a href="' . esc_url( get_permalink() ) . '">' . esc_html__( 'Leer más', 'gp-denuncias-theme' ) . '</a>';
										echo '</footer>';
									echo '</article>';
								endwhile;
								wp_reset_postdata();
							else :
								echo '<p>' . esc_html__( 'No hay noticias recientes.', 'gp-denuncias-theme' ) . '</p>';
							endif;
							echo '</div>'; // Fin .article-list

							// Enlace "Ver más noticias" - apunta a tu página de blog/noticias
							$blog_page_url = get_permalink( get_option( 'page_for_posts' ) );
							if ( $blog_page_url ) {
								echo '<a href="' . esc_url( $blog_page_url ) . '" target="_blank" class="custom-btn">' . esc_html__( 'Ver más noticias', 'gp-denuncias-theme' ) . '</a>';
							}
							// Aquí iría otro bloque de anuncios si lo implementas.
						echo '</div>';
					echo '</section>';
					// --- FIN PARTE "ÚLTIMAS NOTICIAS" ---


					// --- INICIO PARTE 4: DOS COLUMNAS (Números denunciados y Top Spam) ---
					echo '<section class="numbers">'; // Clase similar a listaspam
						echo '<div class="container">'; // Contenedor general
							echo '<div class="column last-numbers">'; // Columna para últimos denunciados
								echo '<h3>' . esc_html__( 'Últimos números denunciados por nuestros usuarios', 'gp-denuncias-theme' ) . '</h3>';
								echo '<ul class="number-list">'; // Lista de números

								$args_ultimos_denunciados = array(
									'post_type'      => 'numero_telefonico',
									'posts_per_page' => 5,
									'orderby'        => 'comment_date', // Ordenar por fecha del último comentario
									'order'          => 'DESC',
								);
								$query_ultimos_denunciados = new WP_Query( $args_ultimos_denunciados );

								if ( $query_ultimos_denunciados->have_posts() ) :
									while ( $query_ultimos_denunciados->have_posts() ) : $query_ultimos_denunciados->the_post();
										$comments_query = new WP_Comment_Query();
										$latest_comment_args = array(
											'post_id' => get_the_ID(),
											'number'  => 1,
											'status'  => 'approve',
											'orderby' => 'comment_date_gmt',
											'order'   => 'DESC',
										);
										$latest_comments = $comments_query->query( $latest_comment_args );
										$latest_comment_content = !empty($latest_comments) ? wp_trim_words($latest_comments[0]->comment_content, 15, '...') : __('Sin comentarios recientes.', 'gp-denuncias-theme');
										$time_ago = '';
										$blob_color_class = 'red'; // Color por defecto
										if (!empty($latest_comments)) {
											$comment_timestamp = strtotime($latest_comments[0]->comment_date_gmt);
											$current_timestamp = time();
											$time_diff_seconds = $current_timestamp - $comment_timestamp;

											$time_ago = sprintf(esc_html__('hace %s', 'gp-denuncias-theme'), human_time_diff($comment_timestamp, $current_timestamp));

											if ($time_diff_seconds < 86400) { // Menos de 1 día
												$blob_color_class = 'green';
											} elseif ($time_diff_seconds < 604800) { // Menos de 7 días
												$blob_color_class = 'orange';
											}
										}

										// Obtener tipo de teléfono (campo ACF 'tipo_telefono')
										$tipo_telefono_val = get_field('tipo_telefono', get_the_ID());
										$tipo_telefono_label = $tipo_telefono_val ? get_field_object('tipo_telefono')['choices'][$tipo_telefono_val] : __('No especificado', 'gp-denuncias-theme');

										// Obtener provincia (taxonomía 'provincia')
										$provincias = get_the_terms(get_the_ID(), 'provincia');
										$provincia_nombre = ($provincias && !is_wp_error($provincias)) ? $provincias[0]->name . ', España' : __('Ubicación desconocida', 'gp-denuncias-theme');

										echo '<li class="comment-box">';
											echo '<article class="comment">'; // Usar estructura similar para CSS
												echo '<header>';
													echo '<div class="time"><span class="time-icon"><span class="blob ' . esc_attr($blob_color_class) . '"></span></span><time datetime="' . (!empty($latest_comments) ? esc_attr(date('c', $comment_timestamp)) : '') . '">' . esc_html($time_ago) . '</time></div>';
													echo '<div class="type_of_call">' . esc_html($tipo_telefono_label) . '</div>';
												echo '</header>';
												echo '<div class="number_content">';
													echo '<a href="' . esc_url( get_permalink() ) . '" title="' . sprintf(esc_attr__('¿Quién me llama del %s?', 'gp-denuncias-theme'), get_the_title()) . '">' . esc_html( get_the_title() ) . '</a>';
													echo '<p>' . esc_html( $latest_comment_content ) . '</p>';
												echo '</div>';
												echo '<footer>';
													echo '<div class="owner-name-index"></div>'; // Placeholder si no tienes nombre de propietario
													echo '<div class="location">' . esc_html($provincia_nombre) . '</div>';
												echo '</footer>';
											echo '</article>';
										echo '</li>';
									endwhile;
									wp_reset_postdata();
								else :
									echo '<li><p>' . esc_html__( 'No hay números denunciados recientemente.', 'gp-denuncias-theme' ) . '</p></li>';
								endif;
								echo '</ul>';
							echo '</div>'; // Fin .column.last-numbers

							echo '<div class="column top-spam-numbers">'; // Columna para Top Spam
								echo '<h3>' . esc_html__( 'Top Spam', 'gp-denuncias-theme' ) . '</h3>';
								echo '<ul class="number-list">';

								$args_top_spam = array(
									'post_type'      => 'numero_telefonico',
									'posts_per_page' => 5,
									'orderby'        => 'comment_count',
									'order'          => 'DESC',
								);
								$query_top_spam = new WP_Query( $args_top_spam );

								if ( $query_top_spam->have_posts() ) :
									while ( $query_top_spam->have_posts() ) : $query_top_spam->the_post();
										$comments_count = get_comments_number();
										$latest_comment_args_top = array(
											'post_id' => get_the_ID(), 'number' => 1, 'status' => 'approve', 'orderby' => 'comment_date_gmt', 'order' => 'DESC'
										);
										$latest_comment_top_obj = get_comments($latest_comment_args_top);
										$latest_comment_content_top = !empty($latest_comment_top_obj) ? wp_trim_words($latest_comment_top_obj[0]->comment_content, 15, '...') : __('Sin comentarios.', 'gp-denuncias-theme');
										
										$tipo_telefono_val_top = get_field('tipo_telefono', get_the_ID());
										$tipo_telefono_label_top = $tipo_telefono_val_top ? get_field_object('tipo_telefono')['choices'][$tipo_telefono_val_top] : __('No especificado', 'gp-denuncias-theme');
										
										$provincias_top = get_the_terms(get_the_ID(), 'provincia');
										$provincia_nombre_top = ($provincias_top && !is_wp_error($provincias_top)) ? $provincias_top[0]->name . ', España' : __('Ubicación desconocida', 'gp-denuncias-theme');
										
										// Obtener el "owner" (si tienes un campo para esto, ej. 'nombre_denunciado_principal')
										$owner_name_top = get_field('nombre_denunciado_principal', get_the_ID()); // Reemplaza con tu campo ACF si existe

										echo '<li class="comment-box">';
											echo '<article class="comment">';
												echo '<header>';
													echo '<div class="time"><span class="alert-icon"></span>' . sprintf(esc_html__('%d denuncias', 'gp-denuncias-theme'), $comments_count) . '</div>';
													echo '<div class="type_of_call">' . esc_html($tipo_telefono_label_top) . '</div>';
												echo '</header>';
												echo '<div class="number_content">';
													echo '<a href="' . esc_url( get_permalink() ) . '" title="' . sprintf(esc_attr__('¿Quién me llama del %s?', 'gp-denuncias-theme'), get_the_title()) . '">' . esc_html( get_the_title() ) . '</a>';
													echo '<p>' . esc_html( $latest_comment_content_top ) . '</p>';
												echo '</div>';
												echo '<footer>';
													echo '<div class="owner-name-index">' . ($owner_name_top ? esc_html($owner_name_top) : '') . '</div>';
													echo '<div class="location">' . esc_html($provincia_nombre_top) . '</div>';
												echo '</footer>';
											echo '</article>';
										echo '</li>';
									endwhile;
									wp_reset_postdata();
								else :
									echo '<li><p>' . esc_html__( 'No hay suficientes datos para el top spam.', 'gp-denuncias-theme' ) . '</p></li>';
								endif;
								echo '</ul>';
							echo '</div>'; // Fin .column.top-spam-numbers
						echo '</div>'; // Fin .container
					echo '</section>';
					// --- FIN PARTE 4 ---


					// --- INICIO PARTE 5: PREFIJOS Y ZONAS DESTACADAS ---
					echo '<section class="top-areacodes-spam">';
						echo '<div class="container">';
							echo '<h3>' . esc_html__( 'Prefijos y zonas con mayor actividad spam', 'gp-denuncias-theme' ) . '</h3>';
							
							// Define aquí tu lista de prefijos/zonas destacadas
							// Similar a como estaba antes, pero con el marcado de listaspam
							$items_destacados = array(
								array( 'prefijo' => '91', 'zona' => 'Madrid', 'slug_prefijo' => '91' ),
								array( 'prefijo' => '93', 'zona' => 'Barcelona', 'slug_prefijo' => '93' ),
								array( 'prefijo' => '902', 'zona' => 'Números Premium', 'slug_prefijo' => '902' ),
								array( 'prefijo' => '648', 'zona' => 'Móviles Movistar', 'slug_prefijo' => '648' ),
								array( 'prefijo' => '662', 'zona' => 'Móviles Vodafone', 'slug_prefijo' => '662' ),
								array( 'prefijo' => '640', 'zona' => 'Móviles Jazztel', 'slug_prefijo' => '640' ),
								array( 'prefijo' => '693', 'zona' => 'Móviles MásMóvil', 'slug_prefijo' => '693' ),
							);

							foreach ( $items_destacados as $item ) {
								$enlace_final = '#';
								if ( isset( $item['slug_prefijo'] ) && !empty($item['slug_prefijo']) ) {
									$term_obj = get_term_by('slug', $item['slug_prefijo'], 'prefijo');
									if ( $term_obj && !is_wp_error($term_obj) ) {
										$enlace_final = get_term_link( $term_obj );
									} else {
										// Si el prefijo no existe como término, podríamos enlazar a una búsqueda
										// $enlace_final = home_url('/?s=' . $item['prefijo'] . '&post_type=numero_telefonico');
									}
								}

								echo '<div class="areacode">';
									echo '<a target="_blank" href="' . esc_url( $enlace_final ) . '">' . esc_html( $item['prefijo'] ) . '</a>';
									echo '<span>' . esc_html( $item['zona'] ) . '</span>';
								echo '</div>';
							}
						echo '</div>';
					echo '</section>';
					// --- FIN PARTE 5 ---

					// --- INICIO CALL TO ACTION APP (Placeholder) ---
					// Esta sección es prominente en listaspam.com. Si tienes una app, adáptala.
					// Si no, puedes omitirla o poner otro CTA.
					/*
					echo '<section class="call_blocker_section">';
						echo '<div class="container">';
							echo '<div id="CallBlocker" class="main_gradient">';
								// Contenido del CallBlocker...
							echo '</div>';
						echo '</div>';
					echo '</section>';
					*/
					// --- FIN CALL TO ACTION APP ---


					// --- INICIO PARTE 6/7: ÚLTIMAS BÚSQUEDAS (CUADRÍCULA) ---
					echo '<section class="last_search">';
						echo '<h3>' . esc_html__( 'Últimas búsquedas de números de teléfono', 'gp-denuncias-theme' ) . '</h3>';
						echo '<div class="container">'; // Contenedor para los números

						$args_ultimas_busquedas = array(
							'post_type'      => 'numero_telefonico',
							'posts_per_page' => 18, // Ajusta la cantidad según el diseño de listaspam
							'orderby'        => 'date', // O 'modified' si quieres los actualizados recientemente
							'order'          => 'DESC',
							// Podrías añadir un meta_query si guardas las "búsquedas" como un campo y quieres ordenar por él.
							// Por ahora, mostramos los últimos creados/modificados.
						);
						$query_ultimas_busquedas = new WP_Query( $args_ultimas_busquedas );

						if ( $query_ultimas_busquedas->have_posts() ) :
							while ( $query_ultimas_busquedas->have_posts() ) : $query_ultimas_busquedas->the_post();
								echo '<a href="' . esc_url( get_permalink() ) . '" class="last_number">';
									echo '<span class="last_number_label">' . esc_html( get_the_title() ) . '</span>';
								echo '</a>';
							endwhile;
							wp_reset_postdata();
						else :
							echo '<p>' . esc_html__( 'No hay búsquedas recientes para mostrar.', 'gp-denuncias-theme' ) . '</p>';
						endif;
						echo '</div>'; // Fin .container
					echo '</section>';
					// --- FIN PARTE 6/7 ---
					?>
				</div> <?php // --- FIN DE .inside-article --- ?>
			</article>
			
			<?php
			do_action( 'generate_after_main_content' );
			?>
		</main>
	</div>

	<?php
	do_action( 'generate_after_primary_content_area' );
	get_footer();
	?>