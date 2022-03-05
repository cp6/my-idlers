"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = mergeSourceMap;

function _remapping() {
  const data = require("@ampproject/remapping");

  _remapping = function () {
    return data;
  };

  return data;
}

function mergeSourceMap(inputMap, map) {
  const result = _remapping()([rootless(map), rootless(inputMap)], () => null);

  if (typeof inputMap.sourceRoot === "string") {
    result.sourceRoot = inputMap.sourceRoot;
  }

  return result;
}

function rootless(map) {
  return Object.assign({}, map, {
    sourceRoot: null
  });
}