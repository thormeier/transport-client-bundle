<?php
namespace Thormeier\TransportClientBundle\Tests\Repository;

use Thormeier\TransportClientBundle\Entity\Location;
use Thormeier\TransportClientBundle\Entity\Prognosis;

use Thormeier\TransportClientBundle\Repository\CheckpointRepository;
use Thormeier\TransportClientBundle\Repository\LocationRepository;
use Thormeier\TransportClientBundle\Repository\PrognosisRepository;

/**
 * Unit test for the checkpoint repository class
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class CheckpointRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CheckpointRepository
     */
    private $checkpointRepository;

    /**
     * @var LocationRepository
     */
    private $locationRepository;

    /**
     * @var PrognosisRepository
     */
    private $prognosisRepository;

    /**
     * Mock all needed repositories and their behaviour and set up an instance of the repository class
     */
    public function setUp()
    {
        $locationRepository = $this->getMockBuilder('Thormeier\TransportClientBundle\Repository\LocationRepository')
            ->setMethods(array(
                    'setUp',
            ))
            ->disableOriginalConstructor()
            ->getMock();
        $prognosisRepository = $this->getMockBuilder('Thormeier\TransportClientBundle\Repository\PrognosisRepository')
            ->setMethods(array(
                    'setUp',
            ))
            ->disableOriginalConstructor()
            ->getMock();

        $locationRepository->expects($this->any())
            ->method('setUp')
            ->will($this->returnValue(new Location));

        $prognosisRepository->expects($this->any())
            ->method('setUp')
            ->will($this->returnValue(new Prognosis));

        $this->checkpointRepository = new CheckpointRepository($locationRepository, $prognosisRepository);
    }

    /**
     * Test setup of a checkpoint entity via the repository
     */
    public function testSetup()
    {
        $data = array(
                   'prognosis' => array(),
                   'station' => array(),
                   'arrival' => '2013-01-01 00:00:01',
                   'departure' => '2013-01-01 00:00:20',
                   'delay' => 0,
                   'platform' => 2
               );

        $result = $this->checkpointRepository->setUp($data);

        $this->assertInstanceOf('Thormeier\TransportClientBundle\Entity\Checkpoint', $result);
        $this->assertInstanceOf('Thormeier\TransportClientBundle\Entity\Location', $result->getStation());
        $this->assertInstanceOf('Thormeier\TransportClientBundle\Entity\Prognosis', $result->getPrognosis());
        $this->assertInstanceOf('DateTime', $result->getArrival());
        $this->assertInstanceOf('DateTime', $result->getDeparture());

        $this->assertEquals($data['arrival'], $result->getArrival()->format('Y-m-d H:i:s'));
        $this->assertEquals($data['departure'], $result->getDeparture()->format('Y-m-d H:i:s'));

        $this->assertEquals($data['delay'], $result->getDelay());
        $this->assertEquals($data['platform'], $result->getPlatform());
    }

    /**
     * Test throwing of InvalidDataException
     */
    public function testSetupInvalidKeys()
    {
        $this->setExpectedException('Thormeier\TransportClientBundle\Exception\InvalidDataException');

        $this->checkpointRepository->setUp(array());
    }
}
