<?php

declare(strict_types=1);

namespace JsonDbQuery;

class JsonDbQueryCommon
{
    /** @var string[] */
    protected $logicOperators = [
        'not',
        'in',
        'nin',
        '$or',
        '$and',
    ];

    /** @var string[] */
    protected $conditionalOperators = [
        '$gt',
        '$gte',
        '$lt',
        '$lte',
        'bt',
    ];
}
