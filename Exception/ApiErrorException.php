<?php
namespace Thormeier\TransportClientBundle\Exception;

/**
 * Thrown on API error (i.e. response status code >= 400)
 */
class ApiErrorException extends \RuntimeException
{
    const MESSAGE = 'API error occured with status code %s when calling %s';
}
