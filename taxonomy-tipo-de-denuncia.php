<?php
/**
 * Plantilla para la taxonomía "Tipo de Denuncia".
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="container">

            <?php if ( have_posts() ) : ?>

                <header class="page-header">
                    <?php
                    the_archive_title( '<h1 class="page-title">', '</h1>' );
                    the_archive_description( '<div class="taxonomy-description">', '</div>' );
                    ?>
                </header><!-- .page-header -->

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
                                <p><?php echo sprintf( esc_html__( '%d denuncias', 'gp-denuncias-theme' ), get_comments_number() ); ?></p>
                            </div>
                        </article>
                        <?php
                    endwhile;

                    the_posts_navigation();
                    ?>
                </div>

            <?php else : ?>

                <section class="no-results not-found">
                    <header class="page-header"><h1 class="page-title"><?php esc_html_e( 'Nada Encontrado', 'gp-denuncias-theme' ); ?></h1></header>
                    <div class="page-content"><p><?php esc_html_e( 'No hay números para este tipo de denuncia.', 'gp-denuncias-theme' ); ?></p></div>
                </section>

            <?php endif; ?>

        </div>
    </main>
</div>

<?php
get_footer();
