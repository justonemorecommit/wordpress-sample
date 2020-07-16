<?php
  $menu = wp_get_nav_menu_items( wp_get_nav_menu_name( 'primary-menu' ) );
?>

<div class="top-menu">
  <div class="top-menu__wrapper">
    <a class="top-menu__logo" href="https://laserhub.com/">
      <img src="<?= get_stylesheet_directory_uri(); ?>/images/logo.svg"/>
    </a>
    <nav class="top-menu__nav hidden-until-desktop">
      <ul>
        <!-- Erste Menüebene: Überspringt alle Items, die ein Parent element haben -->
        <?php
          foreach ($menu as $key => $item):
            if ( $item->menu_item_parent != 0 ) continue;

            /* Tiles muss sich in der Liste befinden, damit wir wissen, wir sind im Spezialmenü */
            $menu_filtered = array_filter ($menu, function ($obj) use ($item) {
              return $obj->menu_item_parent == $item->ID && $obj->title == 'Tiles';
            });
            $masonry_menu = count($menu_filtered) > 0;
        ?>
        <li>

          <span class="top-menu__link"><?= $item->title ?></span>

          <?php if ($masonry_menu): ?>

            <div class="dropdown-menu dropdown-menu--masonry">
              <!-- Zweite Menüebene: Masonry Menu -->
              <?php $i = 0; ?>
              <?php foreach ($menu as $key => $item_sub): if ( $item_sub->menu_item_parent == $item->ID ): ?>
                <?php if( $i === 0 ) { ?>
                  <!-- Overview Link -->
                  <a class="dropdown-menu__wide-tile" href="<?= $item_sub->url ?>"><?= $item_sub->title ?></a>

                  <?php $i++; ?>
                  <div class="dropdown-menu__wrapper">
                <?php } else if ($item_sub->title === 'Tiles') { ?>
                  <!-- Dritte Menüebene: Tiles -->
                  <ul class="dropdown-menu__tiles">
                    <?php foreach ($menu as $key => $item_tile): if( $item_tile->menu_item_parent == $item_sub->ID ): ?>
                      <li>
                        <a href="<?= $item_tile->url ?>" class="dropdown-menu__link">
                          <?= wp_get_attachment_image( $item_tile->thumbnail_id, null, null, array( "class" => "top-menu__icon" ) );  ?>
                          <?= wp_get_attachment_image( $item_tile->thumbnail_hover_id, null, null, array( "class" => "top-menu__icon top-menu__icon--hover" ) );  ?>
                          <span><?= $item_tile->title ?></span>
                        </a>
                      </li>
                    <?php endif; endforeach; ?>
                  </ul>
                <?php } else if ($item_sub->title === 'List') { ?>
                  <!-- Dritte Menüebene: List -->
                  <ul class="dropdown-menu__list">
                    <li>
                      <span class="dropdown-menu__list--all"><?= __('Weiterbearbeitungsverfahren', 'Divi') ?></span>
                    </li>
                    <?php foreach ($menu as $key => $item_list): if( $item_list->menu_item_parent == $item_sub->ID ): ?>
                      <li>
                        <a href="<?= $item_list->url ?>" class="dropdown-menu__link">
                          <?= wp_get_attachment_image( $item_list->thumbnail_id, null, null, array( "class" => "top-menu__icon" ) );  ?>
                          <?= wp_get_attachment_image( $item_list->thumbnail_hover_id, null, null, array( "class" => "top-menu__icon top-menu__icon--hover" ) );  ?>
                          <span><?= $item_list->title ?></span>
                        </a>
                      </li>
                    <?php endif; endforeach; ?>
                  </ul>
                <?php } ?>
              <?php endif; endforeach; ?>
              </div><!-- .dropdown-menu__wrapper -->
            </div><!-- .dropdown-menu--masonry -->

          <?php else: ?>

            <ul class="dropdown-menu">
              <!-- Zweite Menüebene: Default menu -->
              <?php $i = 0; ?>
              <?php foreach ($menu as $key => $item_sub): if( $item_sub->menu_item_parent == $item->ID ): ?>
                <?php if( $i === 0 ) { ?>
                  <li class="dropdown-menu__overview">
                    <a href="<?= $item_sub->url ?>"><?= $item_sub->title ?></a>
                  </li>
                <?php } else {  ?>
                  <li>
                    <a href="<?= $item_sub->url ?>" class="dropdown-menu__link">
                      <?= wp_get_attachment_image( $item_sub->thumbnail_id, null, null, array( "class" => "top-menu__icon" ) );  ?>
                      <?= wp_get_attachment_image( $item_sub->thumbnail_hover_id, null, null, array( "class" => "top-menu__icon top-menu__icon--hover" ) );  ?>
                      <span><?= $item_sub->title ?></span>
                    </a>
                  </li>
                <?php } ?>
              <?php $i++; ?>
              <?php endif; endforeach; ?>
            </ul><!-- .dropdown-menu -->

          <?php endif; ?>
        </li>
      <?php endforeach; ?>
      </ul>
    </nav>
    <div class="top-menu__right hidden-until-desktop">
      <a href="<?= __('https://app.laserhub.com/login', 'Divi') ?>" class="top-menu__login"><?= __('Login', 'Divi') ?></a>
      <a href="<?= __('https://app.laserhub.com/register', 'Divi') ?>" target="_blank" class="top-menu__register top-menu__register-original"><?= __('Angebot einholen', 'Divi') ?></a>
      <a href="<?= __('https://app.laserhub.com/register', 'Divi') ?>" target="_blank" class="top-menu__register top-menu__register-a"><?= __('Registrieren', 'Divi') ?></a>
      <a href="<?= __('https://app.laserhub.com/register', 'Divi') ?>" target="_blank" class="top-menu__register top-menu__register-b"><?= __('Kostenlos registrieren', 'Divi') ?></a>
      <a href="<?= __('https://app.laserhub.com/register', 'Divi') ?>" target="_blank" class="top-menu__register top-menu__register-c"><?= __('Kostenlos testen', 'Divi') ?></a>
      <?php do_action('wpml_add_language_selector'); ?>
    </div>
    <div class="top-menu__right hidden-from-desktop">
      <button id="btn_mobile-menu-toggle" class="top-menu__mobile-btn">
        <img class="closed-mobile-menu" src="<?= get_stylesheet_directory_uri(); ?>/images/bars-solid.svg" width="20">
        <img class="open-mobile-menu" src="<?= get_stylesheet_directory_uri(); ?>/images/times-solid.svg" width="20">
      </button>
    </div>
  </div>
</div>
