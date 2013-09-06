<?php
namespace Thormeier\TransportClientBundle\Tests\TestUtils\DataProvider;

/**
 * Collection of data provider methods
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class DataProvider
{
    /**
     * Data provider method for all methods conecerning numbers
     *
     * @return array
     */
    public function numberProvider()
    {
        return array(
            array(12),
            array(-12),
            array(12.34),
            array(null),
            array('1'),
        );
    }

    /**
     * Data provider method for all string methods
     *
     * @return array
     */
    public function stringProvider()
    {
        return array(
                array('foo'),
                array(null),
        );
    }

    /**
     * Returns various types
     *
     * @return array
     */
    public function multitypeProvider()
    {
        return array(
                array(1),
                array(2),
                array('foo'),
                array('bar'),
                array(null),
        );
    }
}
