<?php
/**
 * Confirmation of course registration
 * Fernando Martinez
 */

$result = getLrLmsGlobalValue("result");
$feedback = getLrLmsGlobalValue("feedback");
$color = 'red';
if (isset($result) && $result === 'success') {
     $color = 'blue';
}
if (isset($feedback)) {
    echo('<div style="color:'.$color.'">'.$feedback.'</div>');
}
