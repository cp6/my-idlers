import type { DecodedSourceMap, RawSourceMap, Options } from './types';
/**
 * A SourceMap v3 compatible sourcemap, which only includes fields that were
 * provided to it.
 */
export default class SourceMap implements SourceMap {
    file?: string | null;
    mappings: RawSourceMap['mappings'] | DecodedSourceMap['mappings'];
    sourceRoot?: string;
    names: string[];
    sources: (string | null)[];
    sourcesContent?: (string | null)[];
    version: 3;
    constructor(map: DecodedSourceMap, options: Options);
    toString(): string;
}
