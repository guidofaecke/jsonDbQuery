<?php

declare(strict_types=1);

namespace JsonDbQuery\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * Test table
 *
 * @ORM\Table(name="FIXTURE")
 *
 * @ORM\Entity(readOnly=true)
 */
class EntityFixture
{
    /**
     * @var string
     *
     * @ORM\Column(name="TEST_CODE", type="string", length=6)
     */
    private $testCode;

    /**
     * @var string
     *
     * @ORM\Column(name="TEST_DESC", type="string", length=25)
     */
    private $testDescription;
}
