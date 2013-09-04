<?php
namespace Thormeier\TransportClientBundle\Tests\UnitTests\Repository;

use Thormeier\TransportClientBundle\Repository\LocationRepository;

use Thormeier\TransportClientBundle\Model\Coordinate;

/**
 * Unit test for the location repository class
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class LocationRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LocationRepository
     */
    private $locationRepository;

    /**
     * Mock browser, serializer and all needed repositories and their behaviour and set up an instance of the repository
     */
    public function setUp()
    {
        // Mock the coordinate repository and its behaviour that is injected into the tested repository
        $coordinateRepository = $this->getMockBuilder('Thormeier\TransportClientBundle\Repository\CoordinateRepository')
            ->setMethods(array(
                'setUp',
            ))
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $coordinateRepository->expects($this->any())
            ->method('setUp')
            ->will($this->returnValue(new Coordinate));

        // Mock dependencies: browser and serializer
        $browser = $this->getMockBuilder('Buzz\Browser')
            ->disableOriginalConstructor()
            ->getMock();

        $serializer = $this->getMockBuilder('JMS\Serializer\Serializer')
            ->disableOriginalConstructor()
            ->getMock();

        // Set up repository that is to be tested
        $this->locationRepository = new LocationRepository($browser, $serializer, 'http://www.example.com', 'foo');
        $this->locationRepository->setCoordinateRepository($coordinateRepository);
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
        $result = $this->locationRepository->sanatizeParameters($inputParameters);

        $this->assertEquals($result, $expectedOutcome);
    }

    /**
     * Test throwing of exception when a required parameter is missing
     */
    public function testSanatizeParametersException()
    {
        $this->setExpectedException('Thormeier\TransportClientBundle\Exception\InsufficientParametersException');

        $this->locationRepository->sanatizeParameters(array());
    }

    /**
     * Test getting of possible parameters
     */
    public function testGetPossibleParameters()
    {
        $result = $this->locationRepository->getPossibleParameters();

        $this->assertInternalType('array', $result);
        $this->assertGreaterThan(0, count($result));
    }

    /**
     * Test setting up an entity
     */
    public function testSetUp()
    {
        $data = array(
                    'coordinate' => array(),
                    'distance' => '12',
                    'id' => 13,
                    'name' => 'foo',
                    'score' => '12',
                    'type' => 'bar',
                );

        $result = $this->locationRepository->setUp($data);

        $this->assertInstanceOf('Thormeier\TransportClientBundle\Model\Location', $result);

        $this->assertInstanceOf('Thormeier\TransportClientBundle\Model\Coordinate', $result->getCoordinate());
        $this->assertEquals($data['distance'], $result->getDistance());
        $this->assertEquals($data['id'], $result->getId());
        $this->assertEquals($data['name'], $result->getName());
        $this->assertEquals($data['score'], $result->getScore());
        $this->assertEquals($data['type'], $result->getType());
    }

    /**
     * Test throwing of InvalidDataException
     */
    public function testSetupInvalidKeys()
    {
        $this->setExpectedException('Thormeier\TransportClientBundle\Exception\InvalidDataException');

        $this->locationRepository->setUp(array());
    }

    /**
     * Data provider method for testing of sanatizing parameters
     *
     * @return array
     */
    public function sanatizeProvider()
    {
        // Set up values for easier comparance
        $xValue = 12;
        $yValue = 13;
        $queryValue = 'foo';
        $typeValue = 'bar';

        $data = array();

        // Query part
        $data[] = array(
                array(
                        'query' => $queryValue,
                ),
                array(
                        'query' => $queryValue,
                ),
        );

        // Coordinates part
        $coordinate = new Coordinate;
        $coordinate->setX($xValue)
            ->setY($yValue)
            ->setType('foo');

        $data[] = array(
                    array(
                        'query' => $queryValue,
                        'coordinate' => $coordinate
                    ),
                    array(
                        'query' => $queryValue,
                        'x' => $xValue,
                        'y' => $yValue,
                    ),
                );

        $data[] = array(
                    array(
                        'query' => $queryValue,
                        'x' => $xValue,
                        'y' => $yValue,
                    ),
                    array(
                        'query' => $queryValue,
                        'x' => $xValue,
                        'y' => $yValue,
                    ),
                );

        // Type part
        $data[] = array(
                    array(
                        'query' => $queryValue,
                        'type' => $typeValue,
                    ),
                    array(
                        'query' => $queryValue,
                        'type' => $typeValue,
                    ),
                );

        // Nonexistant parameter part
        $data[] = array(
                    array(
                        'query' => $queryValue,
                        'foo' => 'bar',
                    ),
                    array(
                        'query' => $queryValue,
                    ),
                );

        return $data;
    }
}
