<?php

declare(strict_types=1);

namespace JsonDbQuery\Tests\Fixtures;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(readOnly=true)
 *
 * @ORM\Table(name="TEST_TABLE")
 */
class TestEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="STATUS", type="string", length=3)
     *
     * @ORM\Id()
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="DESCRIPTION", type="string", length=50)
     */
    private $description;

    /**
     * @var
     *
     * @ORM\Column(name="CREATED_ON", type="datetime")
     */
    private $createdOn;
}
