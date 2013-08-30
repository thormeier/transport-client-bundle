<?php
namespace Thormeier\TransportClientBundle\Exception;

/**
 * Thrown in repositories, when a certain array key in the source data is not present
 */
class InvalidDataException extends \OutOfBoundsException
{
}
