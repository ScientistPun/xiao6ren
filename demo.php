<?php
require_once 'vendor/autoload.php';

use scientistpun\xiao6ren\Xiao6Ren AS X6R;

$gua = X6R::fromYmdH(2024, 12,19, 12);
echo '<pre>';
print_r($gua->getFullData());
echo '</pre>';
