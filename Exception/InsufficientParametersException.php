<?php
namespace Thormeier\TransportClientBundle\Exception;

/**
 * Thrown in repositories where not all required parameters are given for a GET
 */
class InsufficientParametersException extends \Exception
{
    const MESSAGE = 'Required parameters "%s" missing in GET call in %s';
}
