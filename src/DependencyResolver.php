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
     * @throws Exception\ResolveException
     */
    public static function resolve(array $tree, ?ResolveBehaviour $resolveBehaviour = null): array
    {
        $resolveBehaviour = $resolveBehaviour ?? ResolveBehaviour::create()->setThrowOnCircularReference(true);
        $resolved = [];
        $unresolved = [];

        // Resolve dependencies for each table
        foreach (array_keys($tree) as $table) {
            [$resolved, $unresolved, $returnImmediately] = self::resolver($table, $tree, $resolved, $unresolved, $resolveBehaviour);

            if ($returnImmediately) {
                return $resolved;
            }
        }

        return $resolved;
    }

    /**
     * @param int|string $item
     *
     * @throws Exception\ResolveException
     */
    private static function resolver($item, array $items, array $resolved, array $unresolved, ResolveBehaviour $resolveBehaviour): array
    {
        $unresolved[] = $item;

        foreach ($items[$item] as $dep) {
            if (!array_key_exists($dep, $items)) {
                if ($resolveBehaviour->isThrowOnMissingReference()) {
                    throw new Exception\MissingReferenceException($item, $dep);
                }

                return [$resolved, $unresolved, true];
            }

            if (in_array($dep, $resolved, true)) {
                continue;
            }

            if (in_array($dep, $unresolved, true)) {
                if ($resolveBehaviour->isThrowOnCircularReference()) {
                    throw new Exception\CircularReferenceException($item, $dep);
                }

                return [$resolved, $unresolved, true];
            }

            $unresolved[] = $dep;
            [$resolved, $unresolved, $returnImmediately] = self::resolver($dep, $items, $resolved, $unresolved, $resolveBehaviour);

            if ($returnImmediately) {
                return [$resolved, $unresolved, $returnImmediately];
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

        return [$resolved, $unresolved, false];
    }
}
