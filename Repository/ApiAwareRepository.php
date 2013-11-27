<?php
namespace Thormeier\TransportClientBundle\Repository;

use Thormeier\TransportClientBundle\Exception\InsufficientParametersException;

use Buzz\Browser;
use Buzz\Message\MessageInterface;

use JMS\Serializer\Serializer;
use Thormeier\TransportClientBundle\Exception\ApiErrorException;

/**
 * Abstract repository class that allows repositories to query the API
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
abstract class ApiAwareRepository extends Repository implements ApiAwareRepositoryInterface
{
    /**
     * Buzz browser instance
     *
     * @var Browser
     */
    protected $browser;

    /**
     * JMS Serializer instance
     *
     * @var Serializer
     */
    protected $serializer;

    /**
     * API URL
     *
     * @var string
     */
    protected $apiUrl;

    /**
     * Key that represents the first dimension of the response array
     *
     * @var string
     */
    protected $reponseArrayKey = null;

    /**
     * Repository class used to call the API
     *
     * @param Browser    $browser         Used to query the API
     * @param Serializer $serializer      Used to deserialize the JSON response
     * @param string     $apiUrl          URL of the API
     * @param string     $reponseArrayKey Key that represents the first dimension of the response array
     */
    public function __construct(
            Browser $browser,
            Serializer $serializer,
            $apiUrl,
            $reponseArrayKey
        )
    {
        $this->browser           = $browser;
        $this->serializer        = $serializer;
        $this->apiUrl            = $apiUrl;
        $this->reponseArrayKey   = $reponseArrayKey;
    }

    /**
     * Get an array of entities by an array of given parameters
     *
     * @param array $params
     *
     * @return array
     */
    public function get(array $params)
    {
        $params = $this->sanatizeParameters($params);

        $url = $this->buildUrl($params);

        $response = $this->browser->get($url);

        // Catch API errors and throw Exception
        $this->checkApiErrors($response, $url);

        // No error, proceed to parse the returned JSON and set up all entities
        $responseArray = $this->serializer->deserialize($response->getContent(), 'array', 'json');

        $entities = array();
        foreach ($responseArray[$this->reponseArrayKey] as $entityData) {
            $entities[] = $this->setUp($entityData);
        }

        return $entities;
    }

    /**
     * Get API URL
     *
     * @return string
     */
    public function getApiUrl()
    {
        return $this->apiUrl;
    }

    /**
     * Build the URL according to parameters
     *
     * @param array $params
     *
     * @return string
     */
    public function buildUrl(array $params)
    {
        return sprintf(
            '%s/%s?%s',
            rtrim($this->getApiUrl(), '/'),
            static::API_METHOD_NAME,
            http_build_query($params)
        );
    }

    /**
     * Sanatize parameters and check if every parameter given exists in the Repository
     * Also check if all required parameters are given
     *
     * @param array $params
     *
     * @throws InsufficientParametersException
     *
     * @return array
     */
    abstract public function sanatizeParameters(array $params);

    /**
     * Catches any API errors and throws an Exception for them
     *
     * @param MessageInterface $response
     * @param string           $url
     *
     * @throws ApiErrorException
     */
    protected function checkApiErrors(MessageInterface $response, $url)
    {
        if (false === $response->isSuccessful()) {
            throw new ApiErrorException(
                sprintf(
                    ApiErrorException::MESSAGE,
                    $response->getStatusCode(),
                    $url
                )
            );
        }
    }
}
