<?php
namespace Thormeier\TransportClientBundle\Exception;

/**
 * Thrown on invalid argument for repository factory getter
 */
class RepositoryNotFoundException extends \InvalidArgumentException
{
    const MESSAGE = 'Transport API Method "%s" does not have a repository or is not configured to call the API';
}
