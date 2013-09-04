<?php
namespace Thormeier\TransportClientBundle\Tests\Repository;

use Thormeier\TransportClientBundle\Model\Location;
use Thormeier\TransportClientBundle\Model\Checkpoint;
use Thormeier\TransportClientBundle\Model\Section;
use Thormeier\TransportClientBundle\Model\Service;

use Thormeier\TransportClientBundle\Repository\CheckpointRepository;
use Thormeier\TransportClientBundle\Repository\ConnectionRepository;
use Thormeier\TransportClientBundle\Repository\SectionRepository;
use Thormeier\TransportClientBundle\Repository\ServiceRepository;

/**
 * Unit test for the connection repository class
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class ConnectionRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CheckpointRepository
     */
    private $checkpointRepository;

    /**
     * @var ConnectionRepository
     */
    private $connectionRepository;

    /**
     * @var SectionRepository
     */
    private $sectionRepository;

    /**
     * @var ServiceRepository
     */
    private $serviceRepository;

    /**
     * Mock all needed repositories and their behaviour and set up an instance of the repository class
     */
    public function setUp()
    {
        // Mock repositories that are to be injected into the tested one
        $checkpointRepository = $this->getMockBuilder('Thormeier\TransportClientBundle\Repository\CheckpointRepository')
            ->setMethods(array(
                'setUp',
            ))
            ->disableOriginalConstructor()
            ->getMock();

        $serviceRepository = $this->getMockBuilder('Thormeier\TransportClientBundle\Repository\ServiceRepository')
            ->setMethods(array(
                'setUp',
            ))
            ->disableOriginalConstructor()
            ->getMock();

        $sectionRepository = $this->getMockBuilder('Thormeier\TransportClientBundle\Repository\SectionRepository')
            ->setMethods(array(
                'setUp',
            ))
            ->disableOriginalConstructor()
            ->getMock();

        // Mock repository behaviour
        $checkpointRepository->expects($this->any())
            ->method('setUp')
            ->will($this->returnValue(new Checkpoint));

        $sectionRepository->expects($this->any())
            ->method('setUp')
            ->will($this->returnValue(new Section));

        $serviceRepository->expects($this->any())
            ->method('setUp')
            ->will($this->returnValue(new Service));

        // Mock dependencies: browser and serializer
        $browser = $this->getMockBuilder('Buzz\Browser')
            ->disableOriginalConstructor()
            ->getMock();

        $serializer = $this->getMockBuilder('JMS\Serializer\Serializer')
            ->disableOriginalConstructor()
            ->getMock();

        // Set up repository that is to be tested
        $this->connectionRepository = new ConnectionRepository($browser, $serializer, 'http://www.example.com', 'foo');

        $this->connectionRepository->setCheckpointRepository($checkpointRepository)
            ->setSectionRepository($sectionRepository)
            ->setServiceRepository($serviceRepository);
    }

    /**
     * Test set up
     */
    public function testSetUp()
    {
        $data = array(
                    'duration' => '0d00:20:00',
                    'from' => array(),
                    'to' => array(),
                    'service' => array(),
                    'capacity1st' => 1,
                    'capacity2nd' => 2,
                    'products' => array(
                                'foo',
                                'bar',
                            ),
                    'sections' => array(
                                array(),
                                array(),
                            ),
                );

        $result = $this->connectionRepository->setUp($data);

        $this->assertInstanceOf('Thormeier\TransportClientBundle\Model\Connection', $result);

        $this->assertInstanceOf('Thormeier\TransportClientBundle\Model\Checkpoint', $result->getFrom());
        $this->assertInstanceOf('Thormeier\TransportClientBundle\Model\Checkpoint', $result->getTo());

        $this->assertEquals($result->getCapacity1st(), $data['capacity1st']);
        $this->assertEquals($result->getCapacity2nd(), $data['capacity2nd']);

        $this->assertInstanceOf('\DateInterval', $result->getDuration());

        $this->assertCount(2, $result->getProduct());

        $this->assertInstanceOf('Thormeier\TransportClientBundle\Model\Service', $result->getService());

        $this->assertContainsOnly('Thormeier\TransportClientBundle\Model\Section', $result->getSection());
        $this->assertCount(2, $result->getSection());
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
        $result = $this->connectionRepository->sanatizeParameters($inputParameters);

        $this->assertEquals($result, $expectedOutcome);
    }

    /**
     * Test throwing of exception when a required parameter is missing
     *
     * @param array $inputParameters
     *
     * @dataProvider sanatizeExceptionProvider
     */
    public function testSanatizeParametersException(array $inputParameters)
    {
        $this->setExpectedException('Thormeier\TransportClientBundle\Exception\InsufficientParametersException');

        $this->connectionRepository->sanatizeParameters($inputParameters);
    }

    /**
     * Test getting of possible parameters
     */
    public function testGetPossibleParameters()
    {
        $result = $this->connectionRepository->getPossibleParameters();

        $this->assertInternalType('array', $result);
        $this->assertGreaterThan(0, count($result));
    }

    /**
     * Data provider to test sanatizing of given parameters
     *
     * @return array
     */
    public function sanatizeProvider()
    {
        $locationOneName = 'Foo';
        $locationTwoName = 'Bar';

        $locationOne = new Location;
        $locationOne->setName($locationOneName);

        $locationTwo = new Location;
        $locationTwo->setName($locationTwoName);

        $date = '2013-01-01';
        $time = '17:00';

        $data = array();

        // Required to not trigger the throwing of a InsufficientParametersException
        $requiredBaseParameters = array(
                    'from' => $locationOneName,
                    'to' => $locationTwoName,
                );

        // From/To part
        $data[] = array(
                    array(
                        'from' => $locationOne,
                        'to' => $locationTwo,
                    ),
                    array(
                        'from' => $locationOneName,
                        'to' => $locationTwoName,
                    ),
                );
        $data[] = array(
                    array(
                            'from' => $locationOneName,
                            'to' => $locationTwoName,
                    ),
                    array(
                            'from' => $locationOneName,
                            'to' => $locationTwoName,
                    ),
                );

        // Via part
        $data[] = array(
                    array_merge($requiredBaseParameters, array(
                        'via' => $locationOne
                    )),
                    array_merge($requiredBaseParameters, array(
                        'via' => array($locationOneName),
                    )),
                );
        $data[] = array(
                    array_merge($requiredBaseParameters, array(
                        'via' => array($locationOne),
                    )),
                    array_merge($requiredBaseParameters, array(
                        'via' => array($locationOneName),
                    )),
                );
        $data[] = array(
                    array_merge($requiredBaseParameters, array(
                        'via' => $locationOneName,
                    )),
                    array_merge($requiredBaseParameters, array(
                        'via' => array($locationOneName),
                    )),
                );
        $data[] = array(
                    array_merge($requiredBaseParameters, array(
                        'via' => array($locationOneName),
                    )),
                    array_merge($requiredBaseParameters, array(
                        'via' => array($locationOneName),
                    )),
                );

        // Date/Time part
        $data[] = array(
                    array_merge($requiredBaseParameters, array(
                        'datetime' => "$date $time",
                    )),
                    $requiredBaseParameters,
                );
        $data[] = array(
                    array_merge($requiredBaseParameters, array(
                        'datetime' => new \DateTime("$date $time"),
                    )),
                    array_merge($requiredBaseParameters, array(
                        'date' => $date,
                        'time' => $time,
                    )),
                );

        // Arrival time part
        $data[] = array(
                    array_merge($requiredBaseParameters, array(
                        'isArrivalTime' => true
                    )),
                    array_merge($requiredBaseParameters, array(
                        'isArrivalTime' => true
                    )),
                );
        $data[] = array(
                    array_merge($requiredBaseParameters, array(
                        'isArrivalTime' => 1
                    )),
                    array_merge($requiredBaseParameters, array(
                        'isArrivalTime' => true
                    )),
                );

        // Transportations part
        $data[] = array(
                    array_merge($requiredBaseParameters, array(
                        'transportations' => 'foo',
                    )),
                    array_merge($requiredBaseParameters, array(
                        'transportations' => 'foo',
                    )),
                );

        // Limit part
        $data[] = array(
                    array_merge($requiredBaseParameters, array(
                        'limit' => 12,
                    )),
                    array_merge($requiredBaseParameters, array(
                        'limit' => 12,
                    )),
                );
        $data[] = array(
                    array_merge($requiredBaseParameters, array(
                        'limit' => 0,
                    )),
                    $requiredBaseParameters,
                );
        $data[] = array(
                    array_merge($requiredBaseParameters, array(
                        'limit' => '12',
                    )),
                    array_merge($requiredBaseParameters, array(
                        'limit' => 12,
                    )),
                );

        // Page part
        $data[] = array(
                    array_merge($requiredBaseParameters, array(
                        'page' => 12,
                    )),
                    array_merge($requiredBaseParameters, array(
                        'page' => 12,
                    )),
                );
        $data[] = array(
                    array_merge($requiredBaseParameters, array(
                        'page' => 0,
                    )),
                    $requiredBaseParameters,
                );
        $data[] = array(
                    array_merge($requiredBaseParameters, array(
                        'page' => '12',
                    )),
                    array_merge($requiredBaseParameters, array(
                        'page' => 12,
                    )),
                );

        // Sleeper part
        $data[] = array(
                    array_merge($requiredBaseParameters, array(
                        'sleeper' => true
                    )),
                    array_merge($requiredBaseParameters, array(
                        'sleeper' => true
                    )),
                );
        $data[] = array(
                    array_merge($requiredBaseParameters, array(
                        'sleeper' => 1
                    )),
                    array_merge($requiredBaseParameters, array(
                        'sleeper' => true
                    )),
                );

        // Couchet part
        $data[] = array(
                    array_merge($requiredBaseParameters, array(
                        'couchet' => true
                    )),
                    array_merge($requiredBaseParameters, array(
                        'couchet' => true
                    )),
                );
        $data[] = array(
                    array_merge($requiredBaseParameters, array(
                        'couchet' => 1
                    )),
                    array_merge($requiredBaseParameters, array(
                        'couchet' => true
                    )),
                );

        // Bike part
        $data[] = array(
                    array_merge($requiredBaseParameters, array(
                        'bike' => true
                    )),
                    array_merge($requiredBaseParameters, array(
                        'bike' => true
                    )),
                );
        $data[] = array(
                    array_merge($requiredBaseParameters, array(
                        'bike' => 1
                    )),
                    array_merge($requiredBaseParameters, array(
                        'bike' => true
                    )),
                );

        // Non-existant parameter
        $data[] = array(
                    array_merge($requiredBaseParameters, array(
                        'foo' => 'bar',
                    )),
                    $requiredBaseParameters,
                );

        return $data;
    }

    /**
     * Data provider method for triggering of exceptions while sanatizing parameters
     *
     * @return array
     */
    public function sanatizeExceptionProvider()
    {
        $data = array();

        // Both required parameters missing
        $data[] = array(array());

        // "to" parameter missing
        $data[] = array(array('from' => 'foo'));

        // "from" parameter missing
        $data[] = array(array('to' => 'bar'));

        return $data;
    }
}
