interface SourceMapV3 {
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
export interface RawSourceMap extends SourceMapV3 {
    mappings: string;
}
export interface DecodedSourceMap extends SourceMapV3 {
    mappings: SourceMapSegment[][];
}
export interface SourceMapSegmentObject {
    column: number;
    line: number;
    name: string;
    source: {
        content: string | null;
        filename: string;
    };
}
export declare type SourceMapInput = string | RawSourceMap | DecodedSourceMap;
export declare type SourceMapLoader = (file: string) => SourceMapInput | null | undefined;
export declare type Options = {
    excludeContent?: boolean;
    decodedMappings?: boolean;
};
export {};
