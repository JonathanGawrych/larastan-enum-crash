<?php

namespace App\Enums;

enum SearchMatchType: string {
    case PREFIX = 'prefix';
    case SUFFIX = 'suffix';
    case BOTH = 'both';
}
