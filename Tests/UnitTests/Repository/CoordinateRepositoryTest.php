<?php
namespace Thormeier\TransportClientBundle\Tests\Repository;

use Thormeier\TransportClientBundle\Repository\CoordinateRepository;

/**
 * Unit test for the coordinate repository class
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class CoordinateRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test set up method of this repository
     */
    public function testSetUp()
    {
        $coordinateRepository = new CoordinateRepository;

        $data = array(
            'x' => 12,
            'y' => 13,
            'type' => 'foo',
        );

        $result = $coordinateRepository->setUp($data);

        $this->assertInstanceOf('Thormeier\TransportClientBundle\Model\Coordinate', $result);
        $this->assertEquals($result->getX(), $data['x']);
        $this->assertEquals($result->getY(), $data['y']);
        $this->assertEquals($result->getTYpe(), $data['type']);
    }

    /**
     * Test throwing of InvalidDataException
     */
    public function testSetupInvalidKeys()
    {
        $coordinateRepository = new CoordinateRepository;

        $this->setExpectedException('Thormeier\TransportClientBundle\Exception\InvalidDataException');

        $coordinateRepository->setUp(array());
    }
}
