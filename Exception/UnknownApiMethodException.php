<?php
namespace Thormeier\TransportClientBundle\Exception;

/**
 * Thrown on invalid API method call
 */
class UnknownApiMethodException extends \RuntimeException
{
    const MESSAGE = 'Transport API Method %s does not exist';
}
