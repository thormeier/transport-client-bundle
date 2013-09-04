<?php
namespace Thormeier\TransportClientBundle\Tests\UnitTests\Repository;

use Thormeier\TransportClientBundle\Model\Location;

use Thormeier\TransportClientBundle\Repository\StopRepository;

/**
 * Unit test for the stop repository class
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class StopRepositoryTest extends \PHPUnit_FrameWork_TestCase
{
    /**
     * @var StopRepository
     */
    private $stopRepository;

    /**
     * Mocks all needed repositories and their behaviour and sets up an instance of the repository class
     */
    public function setUp()
    {
        // Mock location repository and its behaviour that is to be injected into the tested one
        $locationRepository = $this->getMockBuilder('Thormeier\TransportClientBundle\Repository\LocationRepository')
            ->setMethods(array(
                    'get',
                    'setUp',
            ))
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $locationRepository->expects($this->any())
            ->method('get')
            ->will($this->returnValue(array(new Location)));

        $locationRepository->expects($this->any())
            ->method('setUp')
            ->will($this->returnValue(new Location));

        // Mock dependencies: browser and serializer
        $browser = $this->getMockBuilder('Buzz\Browser')
            ->disableOriginalConstructor()
            ->getMock();

        $serializer = $this->getMockBuilder('JMS\Serializer\Serializer')
            ->disableOriginalConstructor()
            ->getMock();

        // Set up repository that is to be tested
        $this->stopRepository = new StopRepository($browser, $serializer, 'http://www.example.com', 'foo');
        $this->stopRepository->setLocationRepository($locationRepository);
    }

    /**
     * Test setting up an entity
     */
    public function testSetUp()
    {
        $data = array(
                    'station' => array(),
                    'to' => array(),
                    'category' => 'foo',
                    'name' => 'bar',
                    'number' => 12,
                    'operator' => 'baz',
                );

        $result = $this->stopRepository->setUp($data);

        $this->assertInstanceOf('Thormeier\TransportClientBundle\Model\Stop', $result);

        $this->assertInstanceOf('Thormeier\TransportClientBundle\Model\Location', $result->getStation());
        $this->assertInstanceOf('Thormeier\TransportClientBundle\Model\Location', $result->getTo());

        $this->assertEquals($data['category'], $result->getCategory());
        $this->assertEquals($data['name'], $result->getName());
        $this->assertEquals($data['number'], $result->getNumber());
        $this->assertEquals($data['operator'], $result->getOperator());
    }

    /**
     * Test throwing of InvalidDataException
     */
    public function testSetupInvalidKeys()
    {
        $this->setExpectedException('Thormeier\TransportClientBundle\Exception\InvalidDataException');

        $this->stopRepository->setUp(array());
    }

    /**
     * Test getting of possible parameters
     */
    public function testGetPossibleParameters()
    {
        $result = $this->stopRepository->getPossibleParameters();

        $this->assertInternalType('array', $result);
        $this->assertGreaterThan(0, count($result));
    }

    /**
     * Test sanatizing of parameters
     *
     * @param array $inputParameters
     * @param array $expectedOutcome
     *
     * @dataProvider sanatizeProvider
     */
    public function testSanatizeParameters(array $inputParameters, array $expectedOutcome)
    {
        $result = $this->stopRepository->sanatizeParameters($inputParameters);

        $this->assertEquals($result, $expectedOutcome);
    }

    /**
     * Test throwing of exception when a required parameter is missing
     */
    public function testSanatizeParametersException()
    {
        $this->setExpectedException('Thormeier\TransportClientBundle\Exception\InsufficientParametersException');

        $this->stopRepository->sanatizeParameters(array());
    }

    /**
     * Data provider method for testing of sanatizing parameters
     *
     * @return array
     */
    public function sanatizeProvider()
    {
        $data = array();

        $stationValue = 'foo';
        $stationObject = new Location;
        $stationObject->setName($stationValue);

        $idValue = 12;
        $transportationsValue = 'bar';
        $datetimeValue = '2013-01-01 17:00';

        // Station part
        $data[] = array(
                    array(
                        'station' => $stationValue,
                    ),
                    array(
                        'station' => $stationValue,
                    ),
                );
        $data[] = array(
                    array(
                        'station' => $stationObject,
                    ),
                    array(
                        'station' => $stationValue,
                    ),
                );

        // ID part
        $data[] = array(
                    array(
                        'station' => $stationValue,
                        'id' => $idValue,
                    ),
                    array(
                        'station' => $stationValue,
                        'id' => $idValue,
                    ),
                );

        // Transportation part
        $data[] = array(
                    array(
                        'station' => $stationValue,
                        'transportations' => $transportationsValue,
                    ),
                    array(
                        'station' => $stationValue,
                        'transportations' => $transportationsValue,
                    ),
                );

        // DateTime part
        $data[] = array(
                    array(
                        'station' => $stationValue,
                        'datetime' => $datetimeValue,
                    ),
                    array(
                        'station' => $stationValue,
                        'datetime' => $datetimeValue,
                    ),
                );

        $data[] = array(
                    array(
                        'station' => $stationValue,
                        'datetime' => new \DateTime($datetimeValue),
                    ),
                    array(
                        'station' => $stationValue,
                        'datetime' => $datetimeValue,
                    ),
                );

        return $data;
    }
}
