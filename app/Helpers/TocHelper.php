<?php

namespace App\Helpers;

use ashtaev\Toc;

class TocHelper
{
    public static function generateToc($content)
    {
        $toc = new Toc($content);
        return $toc->getPostWhithToc();
    }
}
