<?php wp_head()?>


<?php wp_footer(); ?>


<?php echo get_template_directory_uri() ?>/


<?php get_template_part('components/template-name'); ?>


<?php if( is_page_template('template-name.php') ): ?><?php endif; ?>


<?php if (pll_current_language() == 'ua'): ?><?php endif; ?>


<?php
  if () {

  } else if () {

  }
?>


<?php if (): ?>
<?php elseif (): ?>
<?php else: ?>
<?php endif; ?>


<?php $the_query = new WP_Query(array(
  'category_name' => 'news',
  'posts_per_page' => 5
)); ?>
<?php while ($the_query -> have_posts()) : $the_query -> the_post(); ?>
  <?php the_permalink() ?>
  <?php the_post_thumbnail();?>
  <?php the_title(); ?>
  <?php echo substr(strip_tags($post->post_content), 0, 500);?>
  <?php echo get_the_date('j F Y'); ?>
<?php endwhile;?>
<?php wp_reset_postdata();?>


<?php foreach( $itemі as $item ): ?>
  <?php $item ?>
<?php endforeach; ?>


<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <?php the_permalink() ?>
  <?php the_post_thumbnail();?>
  <?php the_title(); ?>
  <?php echo substr(strip_tags($post->post_content), 0, 500);?>
  <?php echo get_the_date('j F Y'); ?>
<?php endwhile; else: ?>
  <?php if (pll_current_language() == 'ua'): ?> Нічого не знайдено <?php endif; ?>
<?php endif;?>
