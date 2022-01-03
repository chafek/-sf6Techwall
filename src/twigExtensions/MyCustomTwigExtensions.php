<?php

namespace App\twigExtensions;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class MyCustomTwigExtensions extends AbstractExtension{

public function getFilters():array{

    return [
        new TwigFilter('defaultImage',[$this,'defaultImage'])];
}

public function defaultImage(string $path):string{
    if (strlen(trim($path))==0) {
        return 'boy.jpg';
    }
    return $path;
} 



}