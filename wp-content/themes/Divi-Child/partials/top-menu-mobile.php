<?php
  $menu = wp_get_nav_menu_items( wp_get_nav_menu_name( 'mobile' ) );
?>
 <div id="mobile-menu" class="mobile-menu">
    <ul>
    <!-- Erste Menüebene: Überspringt alle Items, die ein Parent element haben -->
        <?php
        foreach ($menu as $key => $item):
        if ( $item->menu_item_parent != 0 ) continue;
        ?>
        <li class="menu-item-collapsed">
            <span class="top-menu__link top-menu__link--mobile"><?= $item->title ?></span>
            <ul class="mobile-dropdown">
              <!-- Zweite Menüebene: Default menu -->
            <?php $i = 0; ?>
            <?php foreach ($menu as $key => $item_sub): if( $item_sub->menu_item_parent == $item->ID ): ?>
            <?php if( $i === 0 ) { ?>
                <li class="mobile-dropdown__overview">
                    <a href="<?= $item_sub->url ?>"><?= $item_sub->title ?></a>
                </li>
                <?php } else {  ?>
                <li>
                    <a href="<?= $item_sub->url ?>" class="mobile-dropdown__link">
                      <?= wp_get_attachment_image( $item_sub->thumbnail_id, null, null, array( "class" => "top-menu__icon" ) );  ?>
                      <?= wp_get_attachment_image( $item_sub->thumbnail_hover_id, null, null, array( "class" => "top-menu__icon top-menu__icon--hover" ) );  ?>
                      <span><?= $item_sub->title ?></span>
                    </a>
                </li>
                <?php } ?>
                <?php $i++; ?>
                <?php endif; endforeach; ?>
            </ul><!-- .dropdown-menu -->
        </li>
    <?php endforeach; ?>
    </ul>
    <ul class="top-menu__right--mobile">
        <li>
            <a href="<?= __('https://app.laserhub.com/login', 'Divi') ?>" class="top-menu__link"><?= __('Login', 'Divi') ?></a>
        </li>
        <li>
            <a href="<?= __('https://app.laserhub.com/register', 'Divi') ?>" target="_blank" class="top-menu__register"><?= __('Angebot einholen', 'Divi') ?></a>
            <?php do_action('wpml_add_language_selector'); ?>
        </li>
    </ul>
</div>
