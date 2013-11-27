<?php
namespace Thormeier\TransportClientBundle\Exception;

/**
 * Thrown in repositories, when a certain array key in the source data is not present
 */
class InvalidDataException extends \OutOfBoundsException
{
    const MESSAGE = 'Incorrupt data given for the method setUp: Missing keys "%s" in %s';
}
