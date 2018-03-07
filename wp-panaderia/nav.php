<nav class="navigation navbar-inverse">
    <a href="<?php echo get_option('Home') ?>">
       <img class="logo" alt="Bakery" src="<?php echo get_template_directory_uri() . '/img/logo.png'; ?>">
       <img class="logoScroll" alt="Bakery" src="<?php echo get_template_directory_uri() . '/img/logomini.png'; ?>">
    </a>
    <button class="btNav" type="button">
        <i class="fa fa-bars fa-2x"></i>
    </button>
    <ul class="navigation-list">
         <li class="nav-item">
            <a class="nav-link" href="<?php echo get_option('Home') ?>">Home</a>
         </li>
         <li class="nav-item">
            <a class="nav-link" href="<?php echo get_page_link(get_page_by_title('Blog')) ?>">Blog</a>
         </li>
         <li class="nav-item">
            <a class="nav-link" href="<?php echo get_page_link(get_page_by_title('Product')) ?>"><?php _e('Products'); ?></a>
         </li>
         <li class="nav-item">
            <a class="nav-link" href="<?php echo get_page_link(get_page_by_title('Contact')) ?>"><?php _e('Contact'); ?></a>
         </li>
         <li class="nav-item">
            <a class="nav-link" href="<?php echo get_page_link(get_page_by_title('Archives')) ?>"><?php _e('Archives'); ?></a>
         </li>
    </ul>
    <div class="widgetNav">
        <?php 
        if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('Nav Widget')) : ?>
        <div>No hay nada hulio</div>
        <?php
        endif;
        ?>
    </div>
</nav>