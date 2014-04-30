<?php
/**
 * @package     Mautic
 * @copyright   2014 Mautic, NP. All rights reserved.
 * @author      Mautic
 * @link        http://mautic.com
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace Mautic\ApiBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Class MauticApiExtension
 * This is the class that loads and manages your bundle configuration
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 *
 * @package Mautic\ApiBundle\DependencyInjection
 */
class MauticApiExtension extends Extension implements PrependExtensionInterface
{

    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\PhpFileLoader($container, new FileLocator(__DIR__.'/../Resources/config/services'));
        $loader->load('services.php');
        $loader->load('forms.php');
        $loader->load('models.php');
        $loader->load('events.php');
    }

    public function prepend(ContainerBuilder $container)
    {

        //inject this bundle's config into core
        $configs = $container->getExtensionConfig($this->getAlias());
        $config = $this->processConfiguration(new Configuration(), $configs);
        $container->prependExtensionConfig('mautic_core', $config);
    }
}
