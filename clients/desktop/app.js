/*
 * Demo of UI interaction with jQuery+Uniter
 *
 * MIT license.
 */
'use strict';

var $ = require('jquery'),
    php = require('phpjs'),
    fileData = require('./uniter_bundle/fileData.js'),
    mainFiles = require('./uniter_bundle/mainFiles.js'),
    hasOwn = {}.hasOwnProperty,
    uniter = require('uniter'),
    phpEngine = uniter.createEngine('PHP'),
    output = document.getElementById('output');

var file_require_string = 'require("/core/constants.fephp") ; ' ;
file_require_string += 'require("/core/isophp.fephp") ; ' ;
file_require_string += 'require("/core/init.fephp") ; ' ;
file_require_string += 'require("/core/bootstrap.fephp") ; ' ;
file_require_string += 'require("/core/index.fephp") ; ' ;

function getFileData(path) {
    if (!hasOwn.call(fileData, path)) {
        throw new Error('Unknown file "' + path + '"');
    }
    return fileData[path];
}

// Set up a PHP module loader
phpEngine.configure({
    include: function (path, promise) {
        promise.resolve(getFileData(path));
    }
});

var this_console = console ;
var this_window = window ;

phpEngine.expose($, 'jQuery');
phpEngine.expose(php, 'php');
phpEngine.expose(this_window, 'window');
phpEngine.expose(this_console, 'console');
phpEngine.expose(window.app, 'app');
phpEngine.expose(window.BrowserWindow, 'BrowserWindow');
phpEngine.expose(window.elec_path, 'path');
phpEngine.expose(window.elec_url, 'url');

// Write content HTML to the DOM
phpEngine.getStdout().on('data', function (data) {
    document.body.insertAdjacentHTML('beforeEnd', data);
});

// this is looking in the filedata file which is all the php compressed in a key value with path keys
var php_code_string = '<?php '+file_require_string+' ?>' ;

// Go!
phpEngine.execute(php_code_string).fail(function (error) {
    console.warn('ERROR: ' + error.toString());
});
