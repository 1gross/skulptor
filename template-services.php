<?php
/* Template Name: Услуги */

get_header();

$services = get_field('services');

?>
    <section class="all-services">
        <div class="wrapper">
            <h1 class="size-h2">Услуги клиники</h1>
            <div class="description">
                Бережно решаем стоматологические проблемы любой сложности. <br>
                Прием ведут опытные врачи, способные точно поставить диагноз и разработать эффективную схему терапии.
            </div>
            <div class="all-services-grid">
                <?php

                $childList = [];

                foreach ($services as $service) {

                    $mainPage = [get_the_permalink($service), get_the_title($service)];

                    $childList[] =  [$mainPage, get_pages('post_type=page&child_of=' . $service . '&post_status=publish')];
                }

                usort($childList, function ($a, $b) {
                    $a = count($a);
                    $b = count($b);

                    return ($a == $b) ? 0 : (($a > $b) ? -1 : 1);
                });


                $sortedArrays = [];
                $sortedArraysLength = [];
                $randColumn = 0;

                foreach ($childList as $key => $array) {

                    $arrayLength = count($array[1]);
                    if (!array_key_exists($key, $sortedArrays) && $key < 3) {

                        $sortedArrays[$key][] = $array;
                        $sortedArraysLength[] = $arrayLength;
                        continue;
                    }


                    $minLengthColumn = array_search(min($sortedArraysLength), $sortedArraysLength);
                    $sortedArraysLength[$minLengthColumn] += $arrayLength;
                    $sortedArrays[$minLengthColumn][] = $array;

                }


                ?>
                <?php foreach ($sortedArrays as $column){ ?>
                    <div class="column">

                        <?php foreach ($column as $key => $service) {  ?>
                            <ul class="service-item">
                                <li class="item-main"><a href="<?php echo $service[0][0]; ?>"><?php echo $service[0][1]; ?></a></li>
                                <?php

                                echo walk_page_tree($service[1], 0, 0, []);
                                ?>

                            </ul>
                        <?php } ?>
                    </div>
               <?php } ?>
            </div>

        </div>
    </section>

<?php

get_footer();
