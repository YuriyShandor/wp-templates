<?php
function load_posts($page, $category) {
  $args = array(
    'post_type' => 'post',
    'posts_per_page' => 12,
    'cat' => $category,
    'paged' => $page,
  );

  $my_posts = new WP_Query($args);
  if ($my_posts->have_posts()):
      while ($my_posts->have_posts()): $my_posts->the_post();
        echo get_template_part('components/single-post');
      endwhile;
  endif;
}

function load_post_data($page, $postId) {
  $rows_per_page = 10;
  $i = 1;
  $min = ($page - 1) * $rows_per_page;
  $max = $min + $rows_per_page;

  global $post;
  $post = get_post($postId);
  setup_postdata($post);
  if (have_rows('post_content')):
    while (have_rows('post_content')): the_row();
      $i++;
      if ($i < $min) { continue; }
      if ($i >= $max) { break; }
      echo get_template_part('components/post-content');
    endwhile;
  endif;
  wp_reset_postdata();
}

add_action('wp_ajax_get_posts', 'buro_get_posts');
add_action('wp_ajax_nopriv_get_posts', 'buro_get_posts');
function buro_get_posts() {
  load_posts($_POST['page'], $_POST['category']);
  wp_die();
};

add_action('wp_ajax_get_post_content', 'buro_get_post_content');
add_action('wp_ajax_nopriv_get_post_content', 'buro_get_post_content');
function buro_get_post_content() {
  load_post_data($_POST['page'], $_POST['postId']);
  wp_die();
};
?>

<script>
  let hasPosts = true;
  const $ = jQuery;

  const shouldLoadMore = () => {
    const scrollTop = $(window).scrollTop() + $(window).height() + $(window).height() / 4;
    return scrollTop >= $(document).height() && !pending && hasPosts;
  }

  let pending = false;
  const setPending = (state) => {
    pending = state;
    $('.posts-section').toggleClass('pending', state);
  }

  const loadMore = (action) => {
    setPending(true);
    const { ajaxurl, postId, page, category } = window.config;
    return $.post(ajaxurl, { action, page, category, postId }).then(r => {
      if (!r) {
        hasPosts = false;
      }
      return r;
    })
  }

  const loadMainPageContent = () => {
    if (!shouldLoadMore()) { return; }

    window.config.page = Number(window.config.page) + 1;
    loadMore('get_posts').then((html) => {
      $('.posts').append(html);
      setPending(false);
    });
  }

  const loadPostContent = () => {
    if (!shouldLoadMore()) { return; }

    setPending(true);
    window.config.page = Number(window.config.page) + 1;
    loadMore('get_post_content').then((html) => {
      $('.single-post-content').append(html);
      setPending(false);
    });
  }

  if ($('.main-page-content').length) {
    $(window).on('scroll', loadMainPageContent);
  }

  if ($('.single-post-content').length) {
    $(window).on('scroll', loadPostContent);
  }
</script>
