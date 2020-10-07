<?php
declare(strict_types=1);

namespace App\Console;

use Cake\Console\CommandRunner as CakeCommandRunner;
use Cake\Core\PluginApplicationInterface;
use Cake\Routing\RoutingApplicationInterface;

/**
 * @inheritdoc
 *
 * @property \Cake\Core\ConsoleApplicationInterface $app
 */
class CommandRunner extends CakeCommandRunner
{
    protected function loadRoutes(): void
    {
        if (!($this->app instanceof RoutingApplicationInterface)) {
            return;
        }
        $builder = \Croogo\Core\Routing\Router::createRouteBuilder('/');

        $this->app->routes($builder);
        if ($this->app instanceof PluginApplicationInterface) {
            $this->app->pluginRoutes($builder);
        }
    }
}
