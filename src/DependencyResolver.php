<?php declare(strict_types=1);

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
     * @throws Exception\CircularReferenceException
     */
    public static function resolve(array $tree): array
    {
        $resolved = [];
        $unresolved = [];
        // Resolve dependencies for each table
        foreach (array_keys($tree) as $table) {
            [$resolved, $unresolved] = self::resolver($table, $tree, $resolved, $unresolved);
        }
        return $resolved;
    }

    /**
     * @param int|string $item
     *
     * @throws Exception\CircularReferenceException
     */
    private static function resolver($item, array $items, array $resolved, array $unresolved): array
    {
        $unresolved[] = $item;

        foreach ($items[$item] as $dep) {
            if (!in_array($dep, $resolved, true)) {
                if (!in_array($dep, $unresolved, true)) {
                    $unresolved[] = $dep;
                    [$resolved, $unresolved] = self::resolver($dep, $items, $resolved, $unresolved);
                } else {
                    throw new Exception\CircularReferenceException($item, $dep);
                }
            }
        }
        // Add $item to $resolved if it's not already there
        if (!in_array($item, $resolved, true)) {
            $resolved[] = $item;
        }
        // Remove all occurrences of $item in $unresolved
        while (($index = array_search($item, $unresolved, true)) !== false) {
            unset($unresolved[$index]);
        }

        return [$resolved, $unresolved];
    }
}
