<?php /* Template Name: custom-page1 */ ?>

<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package VW Sports
 */

get_header(); ?>

<?php do_action( 'vw_sports_page_top' ); ?>

<main id="maincontent" class="middle-align pt-5" role="main"> 
    
    
    <div class="container">
        <div>THIS IS MY CUSTOM PAGE!</div>
        <?php while ( have_posts() ) : the_post();
            get_template_part( 'template-parts/content-page'); 
        endwhile; ?>
    </div>
    
    
</main>

<?php do_action( 'vw_sports_page_bottom' ); ?>

<?php get_footer(); ?>
