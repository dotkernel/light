<?php

declare(strict_types=1);

namespace LightTest\Unit\Page\Service;

use Light\Page\Service\PageService;
use Light\Page\Service\PageServiceInterface;
use PHPUnit\Framework\TestCase;

class PageServiceTest extends TestCase
{
    public function testWillInstantiate(): void
    {
        $this->assertContainsOnlyInstancesOf(PageServiceInterface::class, [new PageService()]);
    }
}
