<?php

declare(strict_types=1);

namespace IntelliShop\LaravelFoundation;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Config;
use IntelliShop\LaravelFoundation\Application\Entities\Permissions\Permission;
use IntelliShop\LaravelFoundation\Application\Entities\Permissions\Role;
use PHPUnit\Framework\TestCase;

final class PermissionServiceProviderTest extends TestCase
{
    /**
     * @covers \IntelliShop\LaravelFoundation\PermissionServiceProvider::<public>
     */
    public function testBoot(): void
    {
        $configuration = $this->getMockBuilder(Config::class)->setMethods(['set'])->getMock();
        $configuration
            ->expects($this->once())
            ->method('set')
            ->willReturn(function (array $settings): void {
                $this->assertArraySubset([Permission::class, Role::class], $settings);
            });

        $application = $this->getMockBuilder(Application::class)->disableOriginalConstructor()->getMock();
        $application->expects($this->never())->method('make');
        $application->expects($this->once())->method('runningInConsole')->willReturn(true);

        (new PermissionServiceProvider($application))->boot($configuration);
    }
}
