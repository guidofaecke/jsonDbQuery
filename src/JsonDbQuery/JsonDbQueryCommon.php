<?php

declare(strict_types=1);

namespace JsonDbQuery;

class JsonDbQueryCommon
{
    protected $logicOperators = [
        'not',
        'in',
        'nin',
        'or',
        'and',
    ];

    protected $conditionalOperators = [
        'gt',
        'gte',
        'lt',
        'lte',
        'bt',
    ];
}
