<?php
    $priceID = get_field('offer');
    $priceTitle = get_field('offer_title');
?>
<?php if (is_int($priceID)): ?>
<div id="offer" class="anchor"></div>
<section class="price-block">
    <div class="wrapper">
        <?php if (strlen($priceTitle) > 0): ?>
        <h2 class="center"><?php echo $priceTitle; ?></h2>
        <?php endif; ?>
       <?php $table = get_field('price_table', $priceID);
       generatePrice($table);
       ?>
    </div>
</section>
<?php endif; ?>