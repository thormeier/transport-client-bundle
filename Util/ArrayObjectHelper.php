<?php
namespace Thormeier\TransportClientBundle\Util;

/**
 * Helper class used inside entity classes to manage collections
 *
 * No doctrine collections are used to omit this dependency
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class ArrayObjectHelper
{
    /**
     * Append an element to an ArrayObject
     *
     * @param \ArrayObject $arrayObject
     * @param unknown      $element
     *
     * @return \ArrayObject
     */
    public static function appendElement(\ArrayObject $arrayObject, $element)
    {
        $arrayObject->append($element);

        return $arrayObject;
    }

    /**
     * Remove an element from an ArrayObject
     *
     * @param \ArrayObject $arrayObject
     * @param unknown      $element
     *
     * @return \ArrayObject
     */
    public static function removeElement(\ArrayObject $arrayObject, $element)
    {
        // Get a copy of the array values of given object
        $array = $arrayObject->getArrayCopy();

        // Serialize every element for usage of array_diff
        $serializedArrayElement = array(serialize($element));
        foreach ($array as $key => $value) {
            $array[$key] = serialize($value);
        }

        $newArray = array_diff($array, $serializedArrayElement);

        // Reassign keys
        $newArray = array_values($newArray);

        // Unserialize all array elements again
        foreach ($newArray as $key => $value) {
            $newArray[$key] = unserialize($value);
        }

        // Replace old array with new one
        $arrayObject->exchangeArray($newArray);

        return $arrayObject;
    }
}
