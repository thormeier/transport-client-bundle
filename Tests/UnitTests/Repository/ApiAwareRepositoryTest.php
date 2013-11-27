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
     * Mocked Buzz Response
     *
     * @var Buzz\Message\Response
     */
    private $response;

    /**
     * Mock the browser and the serializer and set up an instance of the concrete ApiAwareRepository class
     */
    public function setUp()
    {
        $response = $this->getMockBuilder('Buzz\Message\Response')
            ->disableOriginalConstructor()
            ->getMock();
        $response->expects($this->any())
            ->method('getContent')
            ->will($this->returnValue('foobar'));
        $this->response = $response;

        $browser = $this->getMockBuilder('Buzz\Browser')
            ->disableOriginalConstructor()
            ->getMock();
        $browser->expects($this->any())
            ->method('get')
            ->will($this->returnValue($this->response));

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

        // Get concrete implementation for abstract class to only
        // test the inherited methods, abstract methods are tested
        // in their respective repository test
        $this->repository = new ConcreteApiAwareRepository(
            $browser,
            $serializer,
            $this->apiBaseUrl,
            $this->responseArrayKey
        );
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
     *
     * @param number $statuscode
     *
     * @dataProvider successStatuscodeProvider
     */
    public function testGetSuccess($statuscode)
    {
        $this->setReturnedStatuscode($statuscode);

        $result = $this->repository->get(array());

        $this->assertInternalType('array', $result);
        $this->assertCount(2, $result);
        $this->assertContainsOnly('\stdClass', $result);
    }

    /**
     * Test throwing of exception during
     *
     * @param number $statuscode
     *
     * @dataProvider errorStatuscodeProvider
     */
    public function testGetError($statuscode)
    {
        $this->setReturnedStatuscode($statuscode);

        $this->setExpectedException('Thormeier\TransportClientBundle\Exception\ApiErrorException');

        $result = $this->repository->get(array());
    }

    /**
     * Data Provider method for successful status codes
     *
     * @return array
     */
    public function successStatuscodeProvider()
    {
        return array(
            array(200),
            array(203),
            array(204),
        );
    }

    /**
     * Data Provider method for error status codes
     *
     * @return array
     */
    public function errorStatuscodeProvider()
    {
        // non-successful status codes according to Buzz implementation
        return array(
            array(301),
            array(302),
            array(400),
            array(403),
            array(404),
            array(500),
        );
    }

    /**
     * Sets the returnd thatus code of the response to the given one
     *
     * @param number $statuscode
     */
    private function setReturnedStatuscode($statuscode)
    {
        $this->response->expects($this->any())
            ->method('isSuccessful')
            ->will($this->returnValue(($statuscode >= 200 && $statuscode < 300)));

        $this->response->expects($this->any())
            ->method('getStatusCode')
            ->will($this->returnValue($statuscode));
    }
}
