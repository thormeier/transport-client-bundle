<?php
namespace Thormeier\TransportClientBundle\Tests\UnitTests\Repository;

use Thormeier\TransportClientBundle\Repository\PrognosisRepository;

/**
 * Unit test for the prognosis repository class
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class PrognosisRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PrognosisRepository
     */
    public $prognosisRepository;

    /**
     * Set up an instance of the repository
     */
    public function setUp()
    {
        $this->prognosisRepository = new PrognosisRepository;
    }

    /**
     * Test setting up an entity
     */
    public function testSetUp()
    {
        $data = array(
            'arrival' => '2013-01-01 17:00:00',
            'capacity1st' => 1,
            'capacity2nd' => 2,
            'departure' => '2013-01-01 17:30:00',
            'platform' => 13,
        );

        $result = $this->prognosisRepository->setUp($data);

        $this->assertInstanceOf('Thormeier\TransportClientBundle\Model\Prognosis', $result);

        $this->assertEquals($result->getArrival(), new \DateTime($data['arrival']));
        $this->assertInstanceOf('\DateTime', $result->getArrival());

        $this->assertEquals($result->getCapacity1st(), $data['capacity1st']);

        $this->assertEquals($result->getCapacity2nd(), $data['capacity2nd']);

        $this->assertEquals($result->getDeparture(), new \DateTime($data['departure']));
        $this->assertInstanceOf('\DateTime', $result->getDeparture());

        $this->assertEquals($result->getPlatform(), $data['platform']);
    }

    /**
     * Test throwing of InvalidDataException
     */
    public function testSetupInvalidKeys()
    {
        $this->setExpectedException('Thormeier\TransportClientBundle\Exception\InvalidDataException');

        $this->prognosisRepository->setUp(array());
    }
}
