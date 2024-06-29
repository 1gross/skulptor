<?php
if ($args['summarys-list']) { ?>
    <div class="summarys">
        <div class="summarys-badge">
            <span class="summarys-icon"></span>
        </div>
        <ul class="summarys-list">
            <?php foreach ($args['summarys-list'] as $summary){
                echo sprintf('<li class="summarys-item"><a class="summary-link" href="#%s">%s</a></li>', $summary[0], $summary[1]);
        } ?>
        </ul>
    </div>
    <?php
}

