(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? module.exports = factory(require('@jridgewell/trace-mapping'), require('sourcemap-codec')) :
    typeof define === 'function' && define.amd ? define(['@jridgewell/trace-mapping', 'sourcemap-codec'], factory) :
    (global = typeof globalThis !== 'undefined' ? globalThis : global || self, global.remapping = factory(global.traceMapping, global.sourcemapCodec));
})(this, (function (TraceMap, sourcemapCodec) { 'use strict';

    function _interopDefaultLegacy (e) { return e && typeof e === 'object' && 'default' in e ? e : { 'default': e }; }

    var TraceMap__default = /*#__PURE__*/_interopDefaultLegacy(TraceMap);

    /**
     * A "leaf" node in the sourcemap tree, representing an original, unmodified
     * source file. Recursive segment tracing ends at the `OriginalSource`.
     */
    class OriginalSource {
        constructor(filename, content) {
            this.filename = filename;
            this.content = content;
        }
        /**
         * Tracing a `SourceMapSegment` ends when we get to an `OriginalSource`,
         * meaning this line/column location originated from this source file.
         */
        originalPositionFor(line, column, name) {
            return { column, line, name, source: this };
        }
    }

    /**
     * FastStringArray acts like a `Set` (allowing only one occurrence of a string
     * `key`), but provides the index of the `key` in the backing array.
     *
     * This is designed to allow synchronizing a second array with the contents of
     * the backing array, like how `sourcesContent[i]` is the source content
     * associated with `source[i]`, and there are never duplicates.
     */
    class FastStringArray {
        constructor() {
            this.indexes = Object.create(null);
            this.array = [];
        }
        /**
         * Puts `key` into the backing array, if it is not already present. Returns
         * the index of the `key` in the backing array.
         */
        put(key) {
            const { array, indexes } = this;
            // The key may or may not be present. If it is present, it's a number.
            let index = indexes[key];
            // If it's not yet present, we need to insert it and track the index in the
            // indexes.
            if (index === undefined) {
                index = indexes[key] = array.length;
                array.push(key);
            }
            return index;
        }
    }

    const INVALID_MAPPING = undefined;
    const SOURCELESS_MAPPING = null;
    /**
     * SourceMapTree represents a single sourcemap, with the ability to trace
     * mappings into its child nodes (which may themselves be SourceMapTrees).
     */
    class SourceMapTree {
        constructor(map, sources) {
            this.map = map;
            this.sources = sources;
        }
        /**
         * traceMappings is only called on the root level SourceMapTree, and begins the process of
         * resolving each mapping in terms of the original source files.
         */
        traceMappings() {
            const names = new FastStringArray();
            const sources = new FastStringArray();
            const sourcesContent = [];
            const { sources: rootSources, map } = this;
            const rootNames = map.names;
            let lastGenLine = -1;
            let lastSourcesIndex = -1;
            let lastSourceLine = -1;
            let lastSourceColumn = -1;
            const mappings = map.map(trace);
            if (mappings.length > lastGenLine + 1) {
                mappings.length = lastGenLine + 1;
            }
            // TODO: Make all sources relative to the sourceRoot.
            return Object.assign({}, this.map, {
                mappings,
                names: names.array,
                sources: sources.array,
                sourcesContent,
            });
            function trace(genLine, genColumn, sourcesIndex, sourceLine, sourceColumn, namesIndex) {
                let traced = SOURCELESS_MAPPING;
                // 1-length segments only move the current generated column, there's no source information
                // to gather from it.
                if (sourcesIndex !== -1) {
                    const source = rootSources[sourcesIndex];
                    traced = source.originalPositionFor(sourceLine, sourceColumn, namesIndex === -1 ? '' : rootNames[namesIndex]);
                    // If the trace is invalid, then the trace ran into a sourcemap that doesn't contain a
                    // respective segment into an original source.
                    if (traced === INVALID_MAPPING)
                        return null;
                }
                if (traced === SOURCELESS_MAPPING) {
                    if (lastSourcesIndex === -1) {
                        // This is a consecutive source-less segment, which doesn't carry any new information.
                        return null;
                    }
                    lastSourcesIndex = lastSourceLine = lastSourceColumn = -1;
                    return [genColumn];
                }
                // So we traced a segment down into its original source file. Now push a
                // new segment pointing to this location.
                const { column, line, name } = traced;
                const { content, filename } = traced.source;
                // Store the source location, and ensure we keep sourcesContent up to
                // date with the sources array.
                const sIndex = sources.put(filename);
                sourcesContent[sIndex] = content;
                if (lastGenLine === genLine &&
                    lastSourcesIndex === sIndex &&
                    lastSourceLine === line &&
                    lastSourceColumn === column) {
                    // This is a duplicate mapping pointing at the exact same starting point in the source
                    // file. It doesn't carry any new information, and only bloats the sourcemap.
                    return null;
                }
                lastGenLine = genLine;
                lastSourcesIndex = sIndex;
                lastSourceLine = line;
                lastSourceColumn = column;
                // This looks like unnecessary duplication, but it noticeably increases performance. If we
                // were to push the nameIndex onto length-4 array, v8 would internally allocate 22 slots!
                // That's 68 wasted bytes! Array literals have the same capacity as their length, saving
                // memory.
                if (name)
                    return [genColumn, sIndex, line, column, names.put(name)];
                return [genColumn, sIndex, line, column];
            }
        }
        /**
         * traceSegment is only called on children SourceMapTrees. It recurses down
         * into its own child SourceMapTrees, until we find the original source map.
         */
        originalPositionFor(line, column, name) {
            const segment = this.map.traceSegment(line, column);
            // If we couldn't find a segment, then this doesn't exist in the sourcemap.
            if (segment == null)
                return INVALID_MAPPING;
            // 1-length segments only move the current generated column, there's no source information
            // to gather from it.
            if (segment.length === 1)
                return SOURCELESS_MAPPING;
            const source = this.sources[segment[1]];
            return source.originalPositionFor(segment[2], segment[3], segment.length === 5 ? this.map.names[segment[4]] : name);
        }
    }

    function asArray(value) {
        if (Array.isArray(value))
            return value;
        return [value];
    }
    /**
     * Recursively builds a tree structure out of sourcemap files, with each node
     * being either an `OriginalSource` "leaf" or a `SourceMapTree` composed of
     * `OriginalSource`s and `SourceMapTree`s.
     *
     * Every sourcemap is composed of a collection of source files and mappings
     * into locations of those source files. When we generate a `SourceMapTree` for
     * the sourcemap, we attempt to load each source file's own sourcemap. If it
     * does not have an associated sourcemap, it is considered an original,
     * unmodified source file.
     */
    function buildSourceMapTree(input, loader) {
        const maps = asArray(input).map((m) => new TraceMap__default["default"](m));
        const map = maps.pop();
        for (let i = 0; i < maps.length; i++) {
            if (maps[i].sources.length > 1) {
                throw new Error(`Transformation map ${i} must have exactly one source file.\n` +
                    'Did you specify these with the most recent transformation maps first?');
            }
        }
        let tree = build(map, loader);
        for (let i = maps.length - 1; i >= 0; i--) {
            tree = new SourceMapTree(maps[i], [tree]);
        }
        return tree;
    }
    function build(map, loader) {
        const { resolvedSources, sourcesContent } = map;
        const children = resolvedSources.map((sourceFile, i) => {
            const source = sourceFile || '';
            // Use the provided loader callback to retrieve the file's sourcemap.
            // TODO: We should eventually support async loading of sourcemap files.
            const sourceMap = loader(source);
            // If there is no sourcemap, then it is an unmodified source file.
            if (!sourceMap) {
                // The source file's actual contents must be included in the sourcemap
                // (done when generating the sourcemap) for it to be included as a
                // sourceContent in the output sourcemap.
                const sourceContent = sourcesContent ? sourcesContent[i] : null;
                return new OriginalSource(source, sourceContent);
            }
            // Else, it's a real sourcemap, and we need to recurse into it to load its
            // source files.
            return build(new TraceMap__default["default"](sourceMap, source), loader);
        });
        return new SourceMapTree(map, children);
    }

    /**
     * A SourceMap v3 compatible sourcemap, which only includes fields that were
     * provided to it.
     */
    class SourceMap {
        constructor(map, options) {
            this.version = 3; // SourceMap spec says this should be first.
            if ('file' in map)
                this.file = map.file;
            this.mappings = options.decodedMappings ? map.mappings : sourcemapCodec.encode(map.mappings);
            this.names = map.names;
            // TODO: We first need to make all source URIs relative to the sourceRoot
            // before we can support a sourceRoot.
            // if ('sourceRoot' in map) this.sourceRoot = map.sourceRoot;
            this.sources = map.sources;
            if (!options.excludeContent && 'sourcesContent' in map) {
                this.sourcesContent = map.sourcesContent;
            }
        }
        toString() {
            return JSON.stringify(this);
        }
    }

    /**
     * Traces through all the mappings in the root sourcemap, through the sources
     * (and their sourcemaps), all the way back to the original source location.
     *
     * `loader` will be called every time we encounter a source file. If it returns
     * a sourcemap, we will recurse into that sourcemap to continue the trace. If
     * it returns a falsey value, that source file is treated as an original,
     * unmodified source file.
     *
     * Pass `excludeContent` to exclude any self-containing source file content
     * from the output sourcemap.
     *
     * Pass `decodedMappings` to receive a SourceMap with decoded (instead of
     * VLQ encoded) mappings.
     */
    function remapping(input, loader, options) {
        const opts = typeof options === 'object' ? options : { excludeContent: !!options, decodedMappings: false };
        const graph = buildSourceMapTree(input, loader);
        return new SourceMap(graph.traceMappings(), opts);
    }

    return remapping;

}));
//# sourceMappingURL=remapping.umd.js.map
