<?php
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

/**
 * Mocked AppKernel for functional tests
 */
class AppKernel extends Kernel
{
    /**
     * Register all bundles the Transport Client has a dependency on and the Transport client itself
     *
     * @return array
     *
     * @see \Symfony\Component\HttpKernel\KernelInterface::registerBundles()
     */
    public function registerBundles()
    {
        $bundles = array(
            // Dependencies
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle,
            new Sensio\Bundle\BuzzBundle\SensioBuzzBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle($this),

            // Bundle to test
            new Thormeier\TransportClientBundle\ThormeierTransportClientBundle,
        );

        return $bundles;
    }

    /**
     * Register the config.yml for the framework configuration
     *
     * @param LoaderInterface $loader
     *
     * @see \Symfony\Component\HttpKernel\KernelInterface::registerContainerConfiguration()
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config.yml');
    }
}