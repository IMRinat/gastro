/*
YUI 3.18.0 (build 790466e)
Copyright 2014 Yahoo! Inc. All rights reserved.
Licensed under the BSD License.
http://yuilibrary.com/license/
*/

YUI.add('json-parse', function (Y, NAME) {

var _JSON = Y.config.global.JSON;

Y.namespace('JSON').parse = function (obj, reviver, space) {
    return _JSON.parse((typeof obj === 'string' ? obj : obj + ''), reviver, space);
};


}, '3.18.0', {"requires": ["yui-base"]});
