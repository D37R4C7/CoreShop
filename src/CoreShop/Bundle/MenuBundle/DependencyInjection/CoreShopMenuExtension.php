<?php
/**
 * CoreShop.
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright  Copyright (c) CoreShop GmbH (https://www.coreshop.org)
 * @license    https://www.coreshop.org/license     GNU General Public License version 3 (GPLv3)
 */

declare(strict_types=1);

namespace CoreShop\Bundle\MenuBundle\DependencyInjection;

use CoreShop\Bundle\MenuBundle\Builder\MenuBuilderInterface;
use CoreShop\Bundle\MenuBundle\DependencyInjection\CompilerPass\MenuBuilderPass;
use CoreShop\Bundle\PimcoreBundle\DependencyInjection\Extension\AbstractPimcoreExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

final class CoreShopMenuExtension extends AbstractPimcoreExtension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        //$this->registerPimcoreResources('coreshop', $configs['pimcore_admin'], $container);

        $loader->load('services.yml');

        $container
            ->registerForAutoconfiguration(MenuBuilderInterface::class)
            ->addTag(MenuBuilderPass::MENU_BUILDER_TAG);
    }
}
