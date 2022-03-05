export interface SourceMapV3 {
    file?: string | null;
    names: string[];
    sourceRoot?: string;
    sources: (string | null)[];
    sourcesContent?: (string | null)[];
    version: 3;
}
declare type Column = number;
declare type SourcesIndex = number;
declare type SourceLine = number;
declare type SourceColumn = number;
declare type NamesIndex = number;
export declare type SourceMapSegment = [Column] | [Column, SourcesIndex, SourceLine, SourceColumn] | [Column, SourcesIndex, SourceLine, SourceColumn, NamesIndex];
export interface EncodedSourceMap extends SourceMapV3 {
    mappings: string;
}
export interface DecodedSourceMap extends SourceMapV3 {
    mappings: SourceMapSegment[][];
}
export declare type Mapping = {
    source: string | null;
    line: number;
    column: number;
    name: string | null;
};
export declare type InvalidMapping = {
    source: null;
    line: null;
    column: null;
    name: null;
};
export declare type SourceMapInput = string | EncodedSourceMap | DecodedSourceMap;
export declare type Needle = {
    line: number;
    column: number;
};
export declare type MapSegmentFn<T> = (generatedLine: number, generatedColumn: number, sourcesIndex: number, line: number, column: number, namesIndex: number) => T;
export declare abstract class SourceMap {
    abstract encodedMappings(): EncodedSourceMap['mappings'];
    abstract decodedMappings(): DecodedSourceMap['mappings'];
    abstract map<T>(fn: MapSegmentFn<T>): NonNullable<T>[][];
    abstract traceSegment(this: SourceMap, line: number, column: number): SourceMapSegment | null;
}
export {};
