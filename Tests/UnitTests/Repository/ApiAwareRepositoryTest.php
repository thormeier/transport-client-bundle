<?php
namespace Thormeier\TransportClientBundle\Tests\UnitTests\Repository;

use Thormeier\TransportClientBundle\Repository\ApiAwareRepository;
use Thormeier\TransportClientBundle\Tests\UnitTests\Repository\ConcreteApiAwareRepository;

/**
 * Unit test for the api aware repository class
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class ApiAwareRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Concrete implementation of the ApiAwareRepository
     *
     * @var ApiAwareRepository
     */
    private $repository;

    /**
     * Fake base URL for the API to be called
     *
     * @var string
     */
    private $apiBaseUrl = 'http://www.example.com/';

    /**
     * @see \Thormeier\TransportClientBundle\Repository\ApiAwareRepository::__construct
     *
     * @var string
     */
    private $responseArrayKey = 'foo';

    /**
     * Mock the browser and the serializer and set up an instance of the concrete ApiAwareRepository class
     */
    public function setUp()
    {
        $response = $this->getMockForAbstractClass('Buzz\Message\MessageInterface');
        $response->expects($this->any())
            ->method('getContent')
            ->will($this->returnValue('foobar'));

        $browser = $this->getMockBuilder('Buzz\Browser')
            ->disableOriginalConstructor()
            ->getMock();
        $browser->expects($this->any())
            ->method('get')
            ->will($this->returnValue($response));

        $serializer = $this->getMockBuilder('JMS\Serializer\Serializer')
            ->disableOriginalConstructor()
            ->getMock();
        $serializer->expects($this->any())
            ->method('deserialize')
            ->will(
                $this->returnValue( // Return potential entities
                    array('foo' =>
                        array(
                            array(),
                            array(),
                        )
                    )
                )
            );

        $this->repository = new ConcreteApiAwareRepository($browser, $serializer, $this->apiBaseUrl, $this->responseArrayKey);
    }

    /**
     * Test getting of API base URL
     */
    public function testGetApiUrl()
    {
        $this->assertEquals($this->apiBaseUrl, $this->repository->getApiUrl());
    }

    /**
     * Test building of URL
     */
    public function testBuildUrl()
    {
        $params = array(
            'foo' => 'bar',
            1 => true,
        );

        $expectedResult = sprintf(
            '%s/%s?%s',
            rtrim($this->apiBaseUrl, '/'),
            ConcreteApiAwareRepository::API_METHOD_NAME,
            http_build_query($params)
        );

        $this->assertEquals($this->repository->buildUrl($params), $expectedResult);
    }

    /**
     * Test getting of entities
     */
    public function testGet()
    {
        $result = $this->repository->get(array());

        $this->assertInternalType('array', $result);
        $this->assertCount(2, $result);
        $this->assertContainsOnly('\stdClass', $result);
    }
}
