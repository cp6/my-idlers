import type { SourceMapV3, DecodedSourceMap, EncodedSourceMap, InvalidMapping, Mapping, SourceMapSegment, SourceMapInput, Needle, MapSegmentFn } from './types';
export type { SourceMapSegment, SourceMapInput, DecodedSourceMap, EncodedSourceMap, MapSegmentFn, } from './types';
export declare class TraceMap {
    version: SourceMapV3['version'];
    file: SourceMapV3['file'];
    names: SourceMapV3['names'];
    sourceRoot: SourceMapV3['sourceRoot'];
    sources: SourceMapV3['sources'];
    sourcesContent: SourceMapV3['sourcesContent'];
    resolvedSources: SourceMapV3['sources'];
    private _impl;
    constructor(map: SourceMapInput, mapUrl?: string | null);
    /**
     * Returns the encoded (VLQ string) form of the SourceMap's mappings field.
     */
    encodedMappings(): EncodedSourceMap['mappings'];
    /**
     * Returns the decoded (array of lines of segments) form of the SourceMap's mappings field.
     */
    decodedMappings(): DecodedSourceMap['mappings'];
    /**
     * Similar to Array.p.map, maps each segment into a new  segment. Passes -1 for any values that do
     * not exist in the SourceMapSegment. Both generatedLine and generatedColumn are 0-based.
     */
    map<T>(fn: MapSegmentFn<T>): NonNullable<T>[][];
    /**
     * A low-level API to find the segment associated with a generated line/column (think, from a
     * stack trace). Line and column here are 0-based, unlike `originalPositionFor`.
     */
    traceSegment(line: number, column: number): SourceMapSegment | null;
    /**
     * A higher-level API to find the source/line/column associated with a generated line/column
     * (think, from a stack trace). Line is 1-based, but column is 0-based, due to legacy behavior in
     * `source-map` library.
     */
    originalPositionFor({ line, column }: Needle): Mapping | InvalidMapping;
}
export { TraceMap as default };
