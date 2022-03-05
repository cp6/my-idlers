/**
 * FastStringArray acts like a `Set` (allowing only one occurrence of a string
 * `key`), but provides the index of the `key` in the backing array.
 *
 * This is designed to allow synchronizing a second array with the contents of
 * the backing array, like how `sourcesContent[i]` is the source content
 * associated with `source[i]`, and there are never duplicates.
 */
export default class FastStringArray {
    private indexes;
    array: ReadonlyArray<string>;
    constructor();
    /**
     * Puts `key` into the backing array, if it is not already present. Returns
     * the index of the `key` in the backing array.
     */
    put(key: string): number;
}
