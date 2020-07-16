<?php
namespace Algorithm;

/**
 * Created by Anthony K GROSS.
 * User: anthony.k.gross@gmail.com
 * Date: 23/3/17
 * Time: 20:25 PM
 */
class DependencyResolver
{
    /**
     * @param array $tree
     * @return array|mixed
     * @throws Exception\CircularReferenceException
     */
    public static function resolve(array $tree)
    {
        $resolved = array();
        $unresolved = array();
        // Resolve dependencies for each table
        foreach (array_keys($tree) as $table) {
            list ($resolved, $unresolved) = self::resolver($table, $tree, $resolved, $unresolved);
        }
        return $resolved;
    }

    /**
     * @param $item
     * @param array $items
     * @param array $resolved
     * @param array $unresolved
     * @throws Exception\CircularReferenceException
     * @return array
     */
    private static function resolver($item, array $items, array $resolved, array $unresolved)
    {
        array_push($unresolved, $item);
        foreach ($items[$item] as $dep) {
            if (!in_array($dep, $resolved)) {
                if (!in_array($dep, $unresolved)) {
                    array_push($unresolved, $dep);
                    list($resolved, $unresolved) = self::resolver($dep, $items, $resolved, $unresolved);
                } else {
                    throw new Exception\CircularReferenceException($item, $dep);
                }
            }
        }
        // Add $item to $resolved if it's not already there
        if (!in_array($item, $resolved)) {
            array_push($resolved, $item);
        }
        // Remove all occurrences of $item in $unresolved
        while (($index = array_search($item, $unresolved)) !== false) {
            unset($unresolved[$index]);
        }

        return array($resolved, $unresolved);
    }
}