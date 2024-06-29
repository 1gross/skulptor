<?php
$isVisible = (!is_page(849)) ? true : false;
if ($isVisible){
    $id = (is_page(1111)) ? 841 : get_the_ID();
    $title = '<h1 id="reviews-title" class="size-h2">Отзывы<br> на независимых<br> площадках</h1>';

    if( is_singular( 'doctors' ) ){
        $name = explode( " ", get_the_title() );
        array_splice( $name, -1 );
        $title = '<h2 id="reviews-title">Отзывы <br>' . implode( " ", $name ).'</h2>';
    }
    if (is_page_template( 'template-constructor.php' ) && !is_front_page()){
        $title = '<h2 id="reviews-title">Отзывы <br>'.mb_strtolower(get_the_title()).'</h2>';
    } ?>
    <div id="reviews" class="anchor"></div>
    <section class="reviews-new">
        <div class="wrapper">
            <div class="reviews-block">
                <div class="reviews-block-sidebar">
                    <?php echo $title; ?>
                    <div id="circle-counter" class="reviews-counter"></div>
                    <div class="reviews-arrows">
                        <button id="reviews-left" class="slider-arrow left"></button>
                        <button id="reviews-right" class="slider-arrow right"></button>
                    </div>
                </div>
                <div id="reviews-slider" class="swiper reviews-slider" data-slider-type="reviews">
                    <div class="swiper-wrapper load" data-page-id="<?php echo $id; ?>"></div>
                    <div class="reviews-pagination">
                        <span id="current-slide"></span> / <span id="max-slide"></span>
                        <div id="reviews-progress" class="reviews-progress"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>


