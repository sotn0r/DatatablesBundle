<?php

/**
 * This file is part of the SgDatatablesBundle package.
 *
 * (c) stwe <https://github.com/stwe/DatatablesBundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sg\DatatablesBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class SgDatatablesExtension
 *
 * @package Sg\DatatablesBundle\DependencyInjection
 */
class SgDatatablesExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('sg_datatables.datatable.templates', $config['datatable']['templates']);
        $container->setParameter('sg_datatables.site', $config['site']);
        $container->setParameter('sg_datatables.query', $config['query']);
        $container->setParameter('sg_datatables.global.prefix', $config['global_prefix']);
        $container->setParameter('sg_datatables.routes', $config['routes']);
        $container->setParameter('sg_datatables.fields', $config['fields']);
        $container->setParameter('sg_datatables.controller', $config['controller']);
    }
}
