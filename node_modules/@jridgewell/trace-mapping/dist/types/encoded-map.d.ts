import type { SourceMap, SourceMapSegment, DecodedSourceMap, EncodedSourceMap, MapSegmentFn } from './types';
export declare class EncodedSourceMapImpl implements SourceMap {
    _lastIndex: number;
    _lastLine: number;
    _lastColumn: number;
    private _lineIndices;
    private _encoded;
    private _mappings;
    constructor(map: EncodedSourceMap);
    encodedMappings(): EncodedSourceMap['mappings'];
    decodedMappings(): DecodedSourceMap['mappings'];
    map<T>(fn: MapSegmentFn<T>): NonNullable<T>[][];
    traceSegment(line: number, column: number): SourceMapSegment | null;
}
