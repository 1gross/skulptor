<?php

$navigation = get_field('navigation');

$bigNavigation = get_field('big-navigation');
$title = get_field('navigation-title');
$description = get_field('navigation-description');
?>
<?php if ($navigation || $bigNavigation): ?>
    <section class="page-menu">
        <div class="upper-block"></div>
        <div class="page-menu-block">
            <!--            <div class="bird l-load-bg no-animation" data-image="-->
            <?php //echo esc_url(get_template_directory_uri()); ?><!--/source/img/bird.svg"></div>-->
            <div class="wrapper">
                <?php if (strlen($title) > 0 || strlen($description) > 0): ?>
                    <div class="page-menu-data">
                        <?php if (strlen($title) > 0): ?>
                            <h2><?php echo $title; ?></h2>
                        <?php endif; ?>
                        <?php if (strlen($description) > 0): ?>
                            <div class="description">
                                <?php echo $description; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <?php if ($bigNavigation): ?>
                    <div class="page-slider-block">
                        <div class="page-slider-arrows">
                            <button id="big-menu-left" class="big-menu-arrow slider-arrow left"></button>
                            <button id="big-menu-right" class="big-menu-arrow slider-arrow right"></button>
                        </div>
                        <div id="big-menu-slider" class="swiper page-slider big-menu-slider"
                             data-slider-type="big-menu">
                            <div class="swiper-wrapper">
                                <?php
                                if (count($bigNavigation) === 3) {
                                    $bigNavigation = array_merge($bigNavigation, $bigNavigation);
                                }
                                foreach ($bigNavigation as $menu):
                                    if (!empty($menu['page']->post_title)):
                                        $icon = get_field('page_icon', $menu['page']->ID);
                                        ?>
                                        <a href="<?php echo get_page_link($menu['page']->ID) ?>"
                                           class="swiper-slide page-item big">
                                            <?php if (!empty($icon)): ?>
                                                <div class="item-img">
                                                    <img class="l-load-bg no-animation" src=""
                                                         data-image="<?php echo $icon; ?>"
                                                         alt="<?php echo $menu['page']->post_title; ?>">
                                                </div>
                                            <?php endif; ?>
                                            <div class="item-title"><?php echo $menu['page']->post_title; ?></div>
                                        </a>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div id="big-menu-pagination" class="swiper-pagination"></div>
                    </div>
                <?php endif; ?>
                <?php if ($navigation): ?>
                    <div class="page-slider-block">
                        <div class="page-slider-arrows">
                            <button id="main-menu-left" class="main-menu-arrow slider-arrow left"></button>
                            <button id="main-menu-right" class="main-menu-arrow slider-arrow right"></button>
                        </div>
                        <div id="main-menu-slider" class="swiper page-slider main-menu-slider"
                             data-slider-type="main-menu">
                            <div class="swiper-wrapper">
                                <?php
                                if (count($navigation) > 4 && count($navigation) < 8) {
                                    $navigation = array_merge($navigation, $navigation);
                                }
                                foreach ($navigation as $menu):
                                    if (!empty($menu['page']->post_title)):
                                        $icon = get_field('page_icon', $menu['page']->ID);
                                        ?>
                                        <a href="<?php echo get_page_link($menu['page']->ID) ?>"
                                           class="swiper-slide page-item">
                                            <?php if (!empty($icon)): ?>
                                                <div class="item-img">
                                                    <img class="l-load-bg no-animation" src=""
                                                         data-image="<?php echo $icon; ?>"
                                                         alt="<?php echo $menu['page']->post_title; ?>">
                                                </div>
                                            <?php endif; ?>
                                            <div class="item-title"><?php echo $menu['page']->post_title; ?></div>
                                        </a>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div id="main-menu-pagination" class="swiper-pagination"></div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>
