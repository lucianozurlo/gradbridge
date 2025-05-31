<?php
/**
 * Plugin Name: GradBridge – Testimonial Slider
 * Description: CPT “Testimonial” + shortcode [testimonial_slider].
 * Author: Luciano
 * Version: 1.0
 */

 // Salir si acceden directo
 if ( ! defined( 'ABSPATH' ) ) exit;

 // 1. Registrar CPT
 add_action( 'init', function () {
   register_post_type( 'testimonial', [
     'labels' => [
       'name' => 'Testimonials',
       'singular_name' => 'Testimonial',
     ],
     'public'       => true,
     'menu_icon'    => 'dashicons-format-quote',
     'supports'     => ['title','editor','thumbnail'],
   ] );
 } );

 // 2. Enqueue Swiper + nuestros assets
 add_action( 'wp_enqueue_scripts', function () {
   // Swiper bundle (CSS + JS)
   wp_enqueue_style( 'swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css', [], '10.0' );
   wp_enqueue_script( 'swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js', [], '10.0', true );

   // Plugin styles & script
   wp_enqueue_style( 'gb-slider', plugins_url( 'assets/slider.css', __FILE__ ), [], '1.0' );
   wp_enqueue_script( 'gb-slider', plugins_url( 'assets/slider.js', __FILE__ ), ['swiper-js'], '1.0', true );
 } );

 // 3. Shortcode
 add_shortcode( 'testimonial_slider', function () {

   $query = new WP_Query([
     'post_type'      => 'testimonial',
     'posts_per_page' => -1,
   ]);

   if ( ! $query->have_posts() ) return '<p>No hay testimonios aún.</p>';

   ob_start(); ?>

   <div class="swiper testimonial-swiper">
     <div class="swiper-wrapper">
       <?php while ( $query->have_posts() ) : $query->the_post(); ?>
         <div class="swiper-slide">
           <article class="testi-card">
             <h3><?php the_title(); ?></h3>
             <p class="role"><?php echo esc_html( get_post_meta( get_the_ID(), 'role', true ) ); ?></p>
             <blockquote><?php the_content(); ?></blockquote>
           </article>
         </div>
       <?php endwhile; wp_reset_postdata(); ?>
     </div>

     <!-- flechas -->
     <div class="slider-nav">
       <button class="slider-prev" aria-label="Anterior">←</button>
       <button class="slider-next" aria-label="Siguiente">→</button>
     </div>
   </div>

   <?php
   return ob_get_clean();
 } );
