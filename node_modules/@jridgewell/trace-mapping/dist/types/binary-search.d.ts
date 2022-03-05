/**
 * A binary search implementation that returns the index if a match is found,
 * or the negated index of where the `needle` should be inserted.
 *
 * The `comparator` callback receives both the `item` under comparison and the
 * needle we are searching for. It must return `0` if the `item` is a match,
 * any negative number if `item` is too small (and we must search after it), or
 * any positive number if the `item` is too large (and we must search before
 * it).
 *
 * The `len` param allows you to treat contiguous blocks of memory as a single item. Eg, a 5-length
 * tuple (with values at indices 0-4) would only test index 0.
 *
 * If no match is found, then the left-index (the index associated with the item that comes just
 * before the desired index) is returned. To maintain proper sort order, a splice would happen at
 * the next index:
 *
 * ```js
 * const array = [1, 3];
 * const needle = 2;
 * const index = binarySearch(array, needle, (item, needle) => item - needle);
 *
 * assert.equal(index, 0);
 * array.splice(index + 1, 0, needle);
 * assert.deepEqual(array, [1, 2, 3]);
 * ```
 */
export declare function binarySearch<T, S>(haystack: ArrayLike<T>, needle: S, comparator: (item: T, needle: S) => number, low: number, high: number, len: number): number;
declare type SearchState = {
    _lastLine: number;
    _lastColumn: number;
    _lastIndex: number;
};
/**
 * This overly complicated beast is just to record the last tested line/column and the resulting
 * index, allowing us to skip a few tests if mappings are monotonically increasing.
 */
export declare function memoizedBinarySearch<T, S>(haystack: ArrayLike<T>, needle: S, comparator: (item: T, needle: S) => number, low: number, high: number, len: number, state: SearchState, line: number, column: number): number;
export {};
