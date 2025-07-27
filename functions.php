<?php
/**
 * Funciones del Tema Hijo GP Denuncias.
 */

add_action( 'wp_enqueue_scripts', 'gp_denuncias_theme_enqueue_styles' );
function gp_denuncias_theme_enqueue_styles() {
    wp_enqueue_style( 'generatepress-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'gp-denuncias-theme-style',
        get_stylesheet_uri(),
        array( 'generatepress-style' ),
        wp_get_theme()->get('Version')
    );
    // Encolar Dashicons si no están ya cargados por el tema/plugins
    // GeneratePress usualmente los carga, pero por si acaso para el icono de búsqueda.
    wp_enqueue_style( 'dashicons' );
}

/**
 * Registrar Custom Post Type: Número Telefónico
 * Registrar Taxonomías: Prefijo y Provincia
 */
add_action( 'init', 'gp_denuncias_register_cpt_tax' );

function gp_denuncias_register_cpt_tax() {

    /**
     * Custom Post Type: Número Telefónico
     */
    $labels_cpt = array(
        'name'                  => _x( 'Números Telefónicos', 'Post Type General Name', 'gp-denuncias-theme' ),
        'singular_name'         => _x( 'Número Telefónico', 'Post Type Singular Name', 'gp-denuncias-theme' ),
        'menu_name'             => __( 'Números Telefónicos', 'gp-denuncias-theme' ),
        'name_admin_bar'        => __( 'Número Telefónico', 'gp-denuncias-theme' ),
        'archives'              => __( 'Archivo de Números Telefónicos', 'gp-denuncias-theme' ),
        'attributes'            => __( 'Atributos del Número Telefónico', 'gp-denuncias-theme' ),
        'parent_item_colon'     => __( 'Número Telefónico Padre:', 'gp-denuncias-theme' ),
        'all_items'             => __( 'Todos los Números', 'gp-denuncias-theme' ),
        'add_new_item'          => __( 'Añadir Nuevo Número', 'gp-denuncias-theme' ),
        'add_new'               => __( 'Añadir Nuevo', 'gp-denuncias-theme' ),
        'new_item'              => __( 'Nuevo Número Telefónico', 'gp-denuncias-theme' ),
        'edit_item'             => __( 'Editar Número Telefónico', 'gp-denuncias-theme' ),
        'update_item'           => __( 'Actualizar Número Telefónico', 'gp-denuncias-theme' ),
        'view_item'             => __( 'Ver Número Telefónico', 'gp-denuncias-theme' ),
        'view_items'            => __( 'Ver Números Telefónicos', 'gp-denuncias-theme' ),
        'search_items'          => __( 'Buscar Número Telefónico', 'gp-denuncias-theme' ),
        'not_found'             => __( 'No encontrado', 'gp-denuncias-theme' ),
        'not_found_in_trash'    => __( 'No encontrado en la papelera', 'gp-denuncias-theme' ),
        'featured_image'        => __( 'Imagen Destacada', 'gp-denuncias-theme' ),
        'set_featured_image'    => __( 'Establecer imagen destacada', 'gp-denuncias-theme' ),
        'remove_featured_image' => __( 'Eliminar imagen destacada', 'gp-denuncias-theme' ),
        'use_featured_image'    => __( 'Usar como imagen destacada', 'gp-denuncias-theme' ),
        'insert_into_item'      => __( 'Insertar en Número Telefónico', 'gp-denuncias-theme' ),
        'uploaded_to_this_item' => __( 'Subido a este Número Telefónico', 'gp-denuncias-theme' ),
        'items_list'            => __( 'Lista de Números Telefónicos', 'gp-denuncias-theme' ),
        'items_list_navigation' => __( 'Navegación de lista de Números Telefónicos', 'gp-denuncias-theme' ),
        'filter_items_list'     => __( 'Filtrar lista de Números Telefónicos', 'gp-denuncias-theme' ),
    );
    $args_cpt = array(
        'label'                 => __( 'Número Telefónico', 'gp-denuncias-theme' ),
        'description'           => __( 'Para almacenar denuncias de números telefónicos.', 'gp-denuncias-theme' ),
        'labels'                => $labels_cpt,
        'supports'              => array( 'title', 'editor', 'comments', 'revisions', 'custom-fields' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 20,
        'menu_icon'             => 'dashicons-phone',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => 'numeros',
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
        'rewrite'               => array( 'slug' => 'numero', 'with_front' => true ),
    );
    register_post_type( 'numero_telefonico', $args_cpt );

    /**
     * Taxonomía: Prefijo
     */
    $labels_tax_prefijo = array(
        'name'              => _x( 'Prefijos', 'taxonomy general name', 'gp-denuncias-theme' ),
        'singular_name'     => _x( 'Prefijo', 'taxonomy singular name', 'gp-denuncias-theme' ),
        'search_items'      => __( 'Buscar Prefijos', 'gp-denuncias-theme' ),
        'all_items'         => __( 'Todos los Prefijos', 'gp-denuncias-theme' ),
        'parent_item'       => __( 'Prefijo Padre', 'gp-denuncias-theme' ),
        'parent_item_colon' => __( 'Prefijo Padre:', 'gp-denuncias-theme' ),
        'edit_item'         => __( 'Editar Prefijo', 'gp-denuncias-theme' ),
        'update_item'       => __( 'Actualizar Prefijo', 'gp-denuncias-theme' ),
        'add_new_item'      => __( 'Añadir Nuevo Prefijo', 'gp-denuncias-theme' ),
        'new_item_name'     => __( 'Nuevo Nombre de Prefijo', 'gp-denuncias-theme' ),
        'menu_name'         => __( 'Prefijos', 'gp-denuncias-theme' ),
    );
    $args_tax_prefijo = array(
        'hierarchical'      => false,
        'labels'            => $labels_tax_prefijo,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'show_in_rest'      => true,
        'rewrite'           => array( 'slug' => 'prefijo' ),
    );
    register_taxonomy( 'prefijo', array( 'numero_telefonico' ), $args_tax_prefijo );

    /**
     * Taxonomía: Provincia (Jerárquica)
     */
    $labels_tax_provincia = array(
        'name'              => _x( 'Provincias', 'taxonomy general name', 'gp-denuncias-theme' ),
        'singular_name'     => _x( 'Provincia', 'taxonomy singular name', 'gp-denuncias-theme' ),
        'search_items'      => __( 'Buscar Provincias', 'gp-denuncias-theme' ),
        'all_items'         => __( 'Todas las Provincias', 'gp-denuncias-theme' ),
        'parent_item'       => __( 'Provincia Padre', 'gp-denuncias-theme' ),
        'parent_item_colon' => __( 'Provincia Padre:', 'gp-denuncias-theme' ),
        'edit_item'         => __( 'Editar Provincia', 'gp-denuncias-theme' ),
        'update_item'       => __( 'Actualizar Provincia', 'gp-denuncias-theme' ),
        'add_new_item'      => __( 'Añadir Nueva Provincia', 'gp-denuncias-theme' ),
        'new_item_name'     => __( 'Nuevo Nombre de Provincia', 'gp-denuncias-theme' ),
        'menu_name'         => __( 'Provincias', 'gp-denuncias-theme' ),
        'separate_items_with_commas' => __( 'Separar provincias con comas', 'gp-denuncias-theme' ),
        'add_or_remove_items'        => __( 'Añadir o eliminar provincias', 'gp-denuncias-theme' ),
        'choose_from_most_used'      => __( 'Elegir de las provincias más usadas', 'gp-denuncias-theme' ),
        'popular_items'              => __( 'Provincias populares', 'gp-denuncias-theme' ),
        'not_found'                  => __( 'No se encontraron provincias.', 'gp-denuncias-theme' ),
        'back_to_items'              => __( '← Volver a Provincias', 'gp-denuncias-theme' ),
    );
    $args_tax_provincia = array(
        'hierarchical'      => true,
        'labels'            => $labels_tax_provincia,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'show_in_rest'      => true,
        'rewrite'           => array( 'slug' => 'provincia', 'hierarchical' => true ),
    );
    register_taxonomy( 'provincia', array( 'numero_telefonico' ), $args_tax_provincia );

    /**
     * Taxonomía: Tipo de Denuncia
     */
    $labels_tax_tipo_denuncia = array(
        'name'              => _x( 'Tipos de Denuncia', 'taxonomy general name', 'gp-denuncias-theme' ),
        'singular_name'     => _x( 'Tipo de Denuncia', 'taxonomy singular name', 'gp-denuncias-theme' ),
        'search_items'      => __( 'Buscar Tipos de Denuncia', 'gp-denuncias-theme' ),
        'all_items'         => __( 'Todos los Tipos de Denuncia', 'gp-denuncias-theme' ),
        'edit_item'         => __( 'Editar Tipo de Denuncia', 'gp-denuncias-theme' ),
        'update_item'       => __( 'Actualizar Tipo de Denuncia', 'gp-denuncias-theme' ),
        'add_new_item'      => __( 'Añadir Nuevo Tipo de Denuncia', 'gp-denuncias-theme' ),
        'new_item_name'     => __( 'Nuevo Nombre de Tipo de Denuncia', 'gp-denuncias-theme' ),
        'menu_name'         => __( 'Tipos de Denuncia', 'gp-denuncias-theme' ),
    );
    $args_tax_tipo_denuncia = array(
        'hierarchical'      => false,
        'labels'            => $labels_tax_tipo_denuncia,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'show_in_rest'      => true,
        'rewrite'           => array( 'slug' => 'tipo-de-denuncia' ),
    );
    register_taxonomy( 'tipo_denuncia', array( 'numero_telefonico' ), $args_tax_tipo_denuncia );
}

/**
 * Crea los términos por defecto para la taxonomía 'tipo_denuncia' si no existen.
 */
function gp_denuncias_crear_terminos_tipo_denuncia() {
    $terminos = array(
        'Llamada perdida',
        'Telemarketing',
        'Cobro de deudas',
        'Suplantación de identidad',
        'Encuesta',
        'Mensaje SMS',
        'Presunta estafa',
        'Presuntas amenazas',
        'Llamada de broma',
        'Recordatorio automático'
    );

    foreach ( $terminos as $termino ) {
        if ( ! term_exists( $termino, 'tipo_denuncia' ) ) {
            wp_insert_term( $termino, 'tipo_denuncia' );
        }
    }
}
add_action( 'init', 'gp_denuncias_crear_terminos_tipo_denuncia', 20 ); // Se ejecuta después de registrar la taxonomía

add_filter( 'generate_sidebar_layout', 'gp_denuncias_force_no_sidebar_layout' );
function gp_denuncias_force_no_sidebar_layout( $layout ) {
    if ( is_singular( 'numero_telefonico' ) ||
         is_post_type_archive( 'numero_telefonico' ) ||
         is_front_page() ||
         is_tax( 'prefijo' ) ||
         is_tax( 'provincia' ) ||
         is_404() ) {
        return 'no-sidebar';
    }
    return $layout;
}

/**
 * Opciones del Personalizador para la Página de Inicio.
 */
function gp_denuncias_customize_register_homepage( $wp_customize ) {
    $wp_customize->add_section( 'home_page_texto_section', array(
        'title'      => __( 'Contenido Página de Inicio', 'gp-denuncias-theme' ),
        'priority'   => 120,
    ) );

    $wp_customize->add_setting( 'home_texto_titulo_setting', array(
        'default'           => __( 'Sobre Nuestro Sitio de Denuncias', 'gp-denuncias-theme' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'home_texto_titulo_control', array(
        'label'      => __( 'Título Sección Informativa', 'gp-denuncias-theme' ),
        'section'    => 'home_page_texto_section',
        'settings'   => 'home_texto_titulo_setting',
        'type'       => 'text',
    ) );

    $wp_customize->add_setting( 'home_texto_contenido_setting', array(
        'default'           => '<p>' . __( 'Aquí va una descripción de aproximadamente seis líneas sobre el propósito de este sitio web. Este contenido es editable desde las opciones del Personalizador y es un buen lugar para optimización SEO.', 'gp-denuncias-theme' ) . '</p>'
                             . '<p>' . __( 'Explicamos cómo ayudamos a los usuarios a identificar y denunciar números de teléfono no deseados, spam o llamadas fraudulentas, contribuyendo a una comunidad más segura.', 'gp-denuncias-theme' ) . '</p>',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'home_texto_contenido_control', array(
        'label'      => __( 'Texto Sección Informativa', 'gp-denuncias-theme' ),
        'section'    => 'home_page_texto_section',
        'settings'   => 'home_texto_contenido_setting',
        'type'       => 'textarea',
        'description'=> __( 'Puedes usar etiquetas HTML como <p>, <strong>, <em>, <a>.', 'gp-denuncias-theme'),
    ) );
}
add_action( 'customize_register', 'gp_denuncias_customize_register_homepage' );

/**
 * Encolar script para el formulario de la página de inicio y pasar datos de prefijos.
 */
function gp_denuncias_enqueue_form_scripts() {
    if ( is_front_page() ) {
        // Encolar el script de autocompletado
        wp_enqueue_script(
            'gp-denuncias-autocomplete',
            get_stylesheet_directory_uri() . '/js/autocomplete-search.js',
            array(), // Sin dependencias por ahora
            wp_get_theme()->get('Version'),
            true // Cargar en el footer
        );

        // Preparar los datos para el script
        $mapa_provincia_prefijo = array();
        $provincias_terms = get_terms( array(
            'taxonomy'   => 'provincia',
            'hide_empty' => false,
        ) );

        if ( ! empty( $provincias_terms ) && ! is_wp_error( $provincias_terms ) && function_exists('get_field') ) {
            foreach ( $provincias_terms as $provincia_term ) {
                $nombre_campo_acf = 'prefijo_principal_de_provincia'; // Reemplaza si es necesario
                $prefijo_val = get_field( $nombre_campo_acf, 'provincia_' . $provincia_term->term_id );

                if ( ! empty( $prefijo_val ) && is_string($prefijo_val) ) {
                    $mapa_provincia_prefijo[ $provincia_term->name ] = trim($prefijo_val);
                }
            }
        }

        // Pasar los datos al script de autocompletado
        wp_localize_script(
            'gp-denuncias-autocomplete', // El handle del script que recibirá los datos
            'datosDelFormulario',
            array(
                'mapaPrefijos' => $mapa_provincia_prefijo
            )
        );
    }
}
add_action( 'wp_enqueue_scripts', 'gp_denuncias_enqueue_form_scripts' );

/**
 * Encolar script para el formulario de comentarios con opciones adicionales.
 */
function gp_denuncias_enqueue_comment_form_scripts() {
    if ( is_singular( 'numero_telefonico' ) ) {
        wp_enqueue_script(
            'gp-denuncias-comment-options',
            get_stylesheet_directory_uri() . '/js/comment-form-options.js',
            array(),
            wp_get_theme()->get('Version'),
            true
        );
    }
}
add_action( 'wp_enqueue_scripts', 'gp_denuncias_enqueue_comment_form_scripts' );

/**
 * Obtiene el prefijo de la taxonomía 'prefijo' que coincide con el inicio de un número.
 * Comprueba primero los prefijos más largos para mayor especificidad.
 *
 * @param string $numero_telefono El número de teléfono completo.
 * @return string|false El nombre/slug del término de prefijo encontrado, o false si no hay coincidencia.
 */
function gp_denuncias_obtener_prefijo_registrado( $numero_telefono ) {
    if ( empty( $numero_telefono ) ) {
        return false;
    }

    $numero_limpio = preg_replace( '/[^0-9]/', '', $numero_telefono );
    if ( empty( $numero_limpio ) ) {
        return false;
    }

    $terminos_prefijo = get_terms( array(
        'taxonomy'   => 'prefijo',
        'hide_empty' => false,
    ) );

    if ( empty( $terminos_prefijo ) || is_wp_error( $terminos_prefijo ) ) {
        return false;
    }

    // Ordenar los términos por la longitud de su nombre/slug (prefijo) en orden descendente
    usort( $terminos_prefijo, function( $a, $b ) {
        return strlen( $b->name ) - strlen( $a->name ); // Asume que $term->name es el prefijo numérico
    });

    foreach ( $terminos_prefijo as $term_prefijo ) {
        $prefijo_actual = $term_prefijo->name; // Asumimos que el nombre del término es el prefijo numérico
                                            // Si usas el slug como prefijo numérico, cambia a $term_prefijo->slug

        if ( strpos( $numero_limpio, $prefijo_actual ) === 0 ) { // Comprueba si el número comienza con este prefijo
            return $prefijo_actual; // Devuelve el primer prefijo coincidente (el más largo)
        }
    }

    return false; // No se encontró ningún prefijo registrado
}

/**
 * Maneja la creación automática de CPT 'numero_telefonico' si no existe al acceder a su URL.
 * También asigna automáticamente prefijo y provincia. Esta versión está refactorizada para
 * mayor claridad, robustez y mejor registro de errores.
 */
add_action( 'template_redirect', 'gp_denuncias_crear_numero_al_visitar', 5 );

function gp_denuncias_crear_numero_al_visitar() {
    // Condiciones para ejecutar: es un 404, para nuestro CPT y tenemos un slug de número en la URL.
    if ( ! is_404() || get_query_var('post_type') !== 'numero_telefonico' || empty(get_query_var('name')) ) {
        return;
    }

    $numero_slug = sanitize_title( get_query_var('name') );
    
    // Comprobar si ya existe un post con ese slug para evitar duplicados.
    $existing_post = get_page_by_path( $numero_slug, OBJECT, 'numero_telefonico' );
    if ( $existing_post ) {
        // Si por alguna razón la URL da 404 pero el post existe, redirigimos a la URL correcta.
        // Esto puede pasar si las reglas de reescritura no están actualizadas.
        wp_safe_redirect( get_permalink( $existing_post->ID ) );
        exit();
    }

    // Limpiar el slug para obtener solo dígitos.
    $numero_limpio = preg_replace( '/[^0-9]/', '', $numero_slug );

    // Validar que el número limpio tiene una longitud razonable.
    if ( empty( $numero_limpio ) || strlen( $numero_limpio ) < 7 ) {
        // No es un número válido, no hacemos nada.
        return;
    }

    // Crear el nuevo post para el número de teléfono.
    $new_post_id = wp_insert_post( array(
        'post_title'    => $numero_limpio,
        'post_name'     => $numero_limpio,
        'post_type'     => 'numero_telefonico',
        'post_status'   => 'publish',
    ), true );

    if ( is_wp_error( $new_post_id ) ) {
        error_log( "GP Denuncias Error: No se pudo crear el CPT para el número '{$numero_limpio}'. Error: " . $new_post_id->get_error_message() );
        return;
    }

    // Asignar taxonomías (prefijo y provincia).
    gp_denuncias_asignar_taxonomias_a_numero( $new_post_id, $numero_limpio );

    // Redirigir a la URL del post recién creado.
    if ( ! headers_sent() ) {
        wp_safe_redirect( get_permalink( $new_post_id ) );
        exit();
    } else {
        error_log( "GP Denuncias Warning: No se pudo redirigir al nuevo post ID {$new_post_id} porque los encabezados ya fueron enviados." );
    }
}

/**
 * Función de ayuda para asignar prefijo y provincia a un post de número telefónico.
 *
 * @param int    $post_id ID del post a actualizar.
 * @param string $numero  El número de teléfono limpio.
 */
function gp_denuncias_asignar_taxonomias_a_numero( $post_id, $numero ) {
    // 1. Asignar Prefijo
    $prefijo_encontrado = gp_denuncias_obtener_prefijo_registrado( $numero );

    if ( ! $prefijo_encontrado ) {
        error_log( "GP Denuncias Info: No se encontró un prefijo registrado para el número '{$numero}' (Post ID: {$post_id})." );
        return; // No podemos continuar si no hay prefijo.
    }
    
    wp_set_object_terms( $post_id, $prefijo_encontrado, 'prefijo', false );

    // 2. Asignar Provincia (basado en el prefijo)
    
    // Primero, verificar que ACF (Advanced Custom Fields) está activo.
    if ( ! function_exists( 'get_field' ) ) {
        error_log( "GP Denuncias Warning: La función get_field() de ACF no existe. No se puede asignar provincia al Post ID {$post_id}." );
        return;
    }

    $term_prefijo = get_term_by( 'name', $prefijo_encontrado, 'prefijo' );
    if ( ! $term_prefijo || is_wp_error( $term_prefijo ) ) {
        error_log( "GP Denuncias Error: Se encontró el prefijo '{$prefijo_encontrado}' pero no se pudo obtener su objeto de término (Post ID: {$post_id})." );
        return;
    }

    // Nombre del campo ACF que relaciona el prefijo con la provincia.
    $nombre_campo_acf = 'provincia_asociada_al_prefijo';
    $provincia_term_obj = get_field( $nombre_campo_acf, 'prefijo_' . $term_prefijo->term_id );

    if ( empty( $provincia_term_obj ) ) {
        error_log( "GP Denuncias Info: El prefijo '{$prefijo_encontrado}' (Term ID: {$term_prefijo->term_id}) no tiene una provincia asociada en el campo ACF '{$nombre_campo_acf}' (Post ID: {$post_id})." );
        return;
    }

    $nombre_provincia = '';
    // ACF puede devolver un objeto de término o un array.
    if ( is_object( $provincia_term_obj ) && isset( $provincia_term_obj->name ) ) {
        $nombre_provincia = $provincia_term_obj->name;
    } elseif ( is_array( $provincia_term_obj ) && isset( $provincia_term_obj['name'] ) ) {
        $nombre_provincia = $provincia_term_obj['name'];
    } elseif ( is_string( $provincia_term_obj ) ) {
        $nombre_provincia = $provincia_term_obj;
    }

    if ( ! empty( $nombre_provincia ) ) {
        // Verificar que el término de provincia realmente existe antes de asignarlo.
        if ( term_exists( $nombre_provincia, 'provincia' ) ) {
            wp_set_object_terms( $post_id, $nombre_provincia, 'provincia', false );
        } else {
            error_log( "GP Denuncias Error: Se intentó asignar la provincia '{$nombre_provincia}' pero no existe como término en la taxonomía 'provincia' (Post ID: {$post_id})." );
        }
    } else {
        error_log( "GP Denuncias Warning: Se obtuvo un valor para el campo '{$nombre_campo_acf}' pero no se pudo extraer un nombre de provincia válido. Valor recibido: " . print_r( $provincia_term_obj, true ) );
    }
}

/**
 * Modifica los argumentos por defecto del formulario de comentarios para que coincida con listaspam.com.
 * Esta función se engancha/desengancha en single-numero_telefonico.php alrededor de comments_template().
 */
function gp_denuncias_comment_form_defaults( $defaults ) {
    $defaults['title_reply'] = esc_html__('Denunciar este teléfono', 'gp-denuncias-theme');
    $defaults['title_reply_to'] = esc_html__('Responder a %s', 'gp-denuncias-theme');

    // Campos estándar
    $defaults['comment_field'] = '<div class="form_group"><label for="comment">' . esc_html__( 'Comentario', 'gp-denuncias-theme' ) . '</label><textarea id="comment" name="comment" class="form_input" rows="8" placeholder="' . esc_attr__( 'Introduce un comentario...', 'gp-denuncias-theme' ) . '" required="required"></textarea></div>';

    // Botón "Más opciones"
    $defaults['comment_notes_after'] = '<div class="more_options_wrapper"><span class="more_options_button">' . esc_html__('+ Mostrar más opciones', 'gp-denuncias-theme') . '</span></div>';

    // Campos adicionales (inicialmente ocultos)
    $additional_fields = '<div class="additional-fields" style="display: none;">';
    // Campo "¿Quién era?"
    $additional_fields .= '<div class="form_group"><label for="quien_era">' . esc_html__('¿Quién era?', 'gp-denuncias-theme') . '</label><input type="text" id="quien_era" name="quien_era" class="form_input" placeholder="' . esc_attr__('Ej: Banco, compañía de seguros, etc.', 'gp-denuncias-theme') . '"></div>';
    // Campo "Tipo de llamada" (ahora es un desplegable)
    $terms = get_terms( array( 'taxonomy' => 'tipo_denuncia', 'hide_empty' => false ) );
    $additional_fields .= '<div class="form_group"><label for="tipo_denuncia">' . esc_html__('Tipo de denuncia', 'gp-denuncias-theme') . '</label>';
    $additional_fields .= '<select id="tipo_denuncia" name="tipo_denuncia" class="form_input">';
    $additional_fields .= '<option value="-1" selected="selected">(' . esc_html__('Sin especificar', 'gp-denuncias-theme') . ')</option>';
    if ( !is_wp_error($terms) && !empty($terms) ) {
        foreach ( $terms as $term ) {
            $additional_fields .= '<option value="' . esc_attr( $term->term_id ) . '">' . esc_html( $term->name ) . '</option>';
        }
    }
    $additional_fields .= '</select></div>';
    $additional_fields .= '</div>';

    $defaults['comment_field'] .= $additional_fields;

    // Botón de envío y clases
    $defaults['submit_button'] = '<button name="%1$s" type="submit" id="%2$s" class="%3$s custom-btn">%4$s</button>';
    $defaults['submit_field']  = '<div class="buttons_form">%1$s %2$s</div>';
    $defaults['class_form'] = 'comment-form form_content';
    
    return $defaults;
}

/**
 * Eliminar el título por defecto de GeneratePress en single-numero_telefonico.
 */
add_action( 'wp', 'gp_denuncias_remove_single_cpt_title' );
function gp_denuncias_remove_single_cpt_title() {
    if ( is_singular( 'numero_telefonico' ) ) {
        remove_action( 'generate_before_content', 'generate_render_page_header_title' ); // Hook común para el título
        // Puede que necesites identificar el hook exacto que usa tu versión de GP para el título y removerlo.
        // Otra opción es remover 'generate_do_page_header' o una acción similar dentro de 'generate_before_entry_title'
        // o 'generate_before_content'.
        // Si lo anterior no funciona, prueba con:
        // remove_action( 'generate_page_header', 'generate_page_header_content' );
        // O específicamente para el título del post:
        add_filter( 'generate_show_title', 'gp_denuncias_cpt_hide_title_filter' );
    }
}

function gp_denuncias_cpt_hide_title_filter( $show ) {
    if ( is_singular( 'numero_telefonico' ) ) {
        return false; // No mostrar el título a través del filtro de GP
    }
    return $show;
}

/**
 * Incrementa y devuelve el contador de visitas para un post.
 * Utiliza un campo personalizado de ACF para almacenar las visitas.
 *
 * @param int $post_id ID del post.
 * @return int El número total de visitas actualizado.
 */
function gp_denuncias_get_and_update_view_count( $post_id ) {
    if ( !function_exists('get_field') || !function_exists('update_field') ) {
        return 0; // ACF no está disponible.
    }

    $count_key = 'contador_visitas';
    $count = (int) get_field( $count_key, $post_id );

    // Incrementar el contador solo para visitantes reales (no admins, bots, etc.)
    // y solo una vez por carga de página para evitar conteos múltiples.
    if ( !is_admin() && !is_robots() && !is_preview() && !defined('DOING_AJAX') && !defined('DOING_CRON') ) {
        static $counted_posts = array();
        if ( !isset( $counted_posts[$post_id] ) ) {
            $count++;
            update_field( $count_key, $count, $post_id );
            $counted_posts[$post_id] = true;
        }
    }

    return $count;
}


/**
 * Guarda los campos adicionales del formulario de comentarios como metadatos del comentario.
 */
function gp_denuncias_save_comment_meta_data( $comment_id ) {
    if ( isset( $_POST['quien_era'] ) ) {
        $quien_era = sanitize_text_field( $_POST['quien_era'] );
        add_comment_meta( $comment_id, 'quien_era', $quien_era );
    }
    if ( isset( $_POST['tipo_de_llamada'] ) ) {
        $tipo_de_llamada = sanitize_text_field( $_POST['tipo_de_llamada'] );
        add_comment_meta( $comment_id, 'tipo_de_llamada', $tipo_de_llamada );
    }

    // Guardar el tipo de denuncia y asignar la taxonomía al post
    if ( isset( $_POST['tipo_denuncia'] ) && $_POST['tipo_denuncia'] != '-1' ) {
        $term_id = (int) $_POST['tipo_denuncia'];
        $term = get_term( $term_id, 'tipo_denuncia' );

        if ( $term && ! is_wp_error( $term ) ) {
            // Guardamos el nombre del término para mostrarlo fácilmente.
            add_comment_meta( $comment_id, 'tipo_denuncia_nombre', $term->name );

            // Asignamos el término al post usando su nombre, no su ID.
            // Esto evita que WordPress cree términos numéricos si el ID no existe.
            $comment = get_comment( $comment_id );
            $post_id = $comment->comment_post_ID;
            wp_set_post_terms( $post_id, $term->name, 'tipo_denuncia', true ); // El 'true' es para añadir y no sobreescribir
        }
    }
}
add_action( 'comment_post', 'gp_denuncias_save_comment_meta_data' );

/**
 * Muestra los metadatos adicionales en el contenido del comentario.
 */
function gp_denuncias_display_comment_meta_data( $comment_text ) {
    $quien_era = get_comment_meta( get_comment_ID(), 'quien_era', true );
    $tipo_de_llamada = get_comment_meta( get_comment_ID(), 'tipo_de_llamada', true );

    $meta_html = '';
    if ( ! empty( $quien_era ) ) {
        $meta_html .= '<p><strong>' . esc_html__( '¿Quién era?', 'gp-denuncias-theme' ) . '</strong> ' . esc_html( $quien_era ) . '</p>';
    }
    if ( ! empty( $tipo_de_llamada ) ) {
        $meta_html .= '<p><strong>' . esc_html__( 'Tipo de llamada:', 'gp-denuncias-theme' ) . '</strong> ' . esc_html( $tipo_de_llamada ) . '</p>';
    }

    $tipo_denuncia_nombre = get_comment_meta( get_comment_ID(), 'tipo_denuncia_nombre', true );
    if ( ! empty( $tipo_denuncia_nombre ) ) {
        $meta_html .= '<p><strong>' . esc_html__( 'Tipo de denuncia:', 'gp-denuncias-theme' ) . '</strong> ' . esc_html( $tipo_denuncia_nombre ) . '</p>';
    }

    return $meta_html . $comment_text;
}
add_filter( 'comment_text', 'gp_denuncias_display_comment_meta_data' );


/**
 * Forzar el menú de hamburguesa en todas las resoluciones.
 */
// 1. Ocultar el menú de navegación principal y mostrar siempre el toggle
function gp_denuncias_force_mobile_menu_css() {
    ?>
    <style>
        @media (min-width: 769px) { /* Breakpoint de GP */
            .main-navigation:not(.toggled) .main-nav {
                display: none;
            }
            .menu-toggle {
                display: block !important;
            }
        }
    </style>
    <?php
}
add_action( 'wp_head', 'gp_denuncias_force_mobile_menu_css' );

// 2. Asegurarse de que el contenedor de navegación se muestra
add_filter( 'generate_show_primary_menu_if_empty', '__return_true' );