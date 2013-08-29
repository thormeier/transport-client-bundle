<?php
namespace Thormeier\TransportClientBundle\Tests\UnitTests\Repository;

use Thormeier\TransportClientBundle\Entity\Journey;
use Thormeier\TransportClientBundle\Entity\Checkpoint;

use Thormeier\TransportClientBundle\Repository\SectionRepository;

/**
 * Unit test for the section repository class
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class SectionRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SectionRepository
     */
    private $sectionRepository;

    /**
     * Mock all needed repositories and their behaviour and set up an instance of the repository class
     */
    public function setUp()
    {
        $journeyRepository = $this->getMockBuilder('Thormeier\TransportClientBundle\Repository\JourneyRepository')
            ->setMethods(array(
                    'setUp',
            ))
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $journeyRepository->expects($this->any())
            ->method('setUp')
            ->will($this->returnValue(new Journey));

        $checkpointRepository = $this->getMockBuilder('Thormeier\TransportClientBundle\Repository\CheckpointRepository')
            ->setMethods(array(
                    'setUp',
            ))
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $checkpointRepository->expects($this->any())
            ->method('setUp')
            ->will($this->returnValue(new Checkpoint));

        $this->sectionRepository = new SectionRepository($checkpointRepository, $journeyRepository);
    }

    /**
     * Test setting up an entity
     */
    public function testSetUp()
    {
        $data = array(
                    'journey' => array(),
                    'arrival' => array(),
                    'departure' => array(),
                    'walk' => 12,
                );

        $result = $this->sectionRepository->setUp($data);

        $this->assertInstanceOf('Thormeier\TransportClientBundle\Entity\Section', $result);
        $this->assertInstanceOf('Thormeier\TransportClientBundle\Entity\Journey', $result->getJourney());
        $this->assertInstanceOf('Thormeier\TransportClientBundle\Entity\Checkpoint', $result->getDeparture());
        $this->assertInstanceOf('Thormeier\TransportClientBundle\Entity\Checkpoint', $result->getArrival());
        $this->assertEquals($data['walk'], $result->getWalk());
    }

    /**
     * Test throwing of InvalidDataException
     */
    public function testSetupInvalidKeys()
    {
        $this->setExpectedException('Thormeier\TransportClientBundle\Exception\InvalidDataException');

        $this->sectionRepository->setUp(array());
    }
}
