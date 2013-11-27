<?php
namespace Thormeier\TransportClientBundle\Repository;

use Thormeier\TransportClientBundle\Exception\InvalidDataException;

/**
 * Abstract repository class thet every repository should implement
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
abstract class Repository implements RepositoryInterface
{
    /**
     * Validates the presence of all needed keys in the given data array
     *
     * @param array $data
     * @param array $neededKeys
     *
     * @throws InvalidDataException
     */
    public function validateDataPresence(array $data, array $neededKeys)
    {
        $presentKeys = array_keys($data);

        $missingKeys = array_diff($neededKeys, $presentKeys);

        if (count(array_diff($neededKeys, $presentKeys)) > 0) {
            throw new InvalidDataException(
                sprintf(
                    InvalidDataException::MESSAGE,
                    implode('", "', $missingKeys),
                    get_called_class()
                )
            );
        }
    }
}
