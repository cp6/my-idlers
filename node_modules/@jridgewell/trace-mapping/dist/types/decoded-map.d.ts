import type { SourceMap, SourceMapSegment, EncodedSourceMap, DecodedSourceMap, MapSegmentFn } from './types';
export declare class DecodedSourceMapImpl implements SourceMap {
    private _mappings;
    _lastIndex: number;
    _lastLine: number;
    _lastColumn: number;
    constructor(map: DecodedSourceMap, owned: boolean);
    encodedMappings(): EncodedSourceMap['mappings'];
    decodedMappings(): DecodedSourceMap['mappings'];
    map<T>(fn: MapSegmentFn<T>): NonNullable<T>[][];
    traceSegment(line: number, column: number): SourceMapSegment | null;
}
