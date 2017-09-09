/*
 * Demo of UI interaction with jQuery+Uniter
 *
 * MIT license.
 */
'use strict';

var $ = require('jquery'),
    php = require('phpjs'),
    hasOwn = {}.hasOwnProperty,
    uniter = require('uniter'),
    phpEngine = uniter.createEngine('PHP'),
    file_index = require('./uniter_bundle/file_index.js'),
    output = document.getElementById('output');

var file_require_string = 'require("/core/constants.fephp") ; ' ;
file_require_string += 'require("/core/app_vars.fephp") ; ' ;
file_require_string += '\\ISOPHP\\core::$php = $php ; ' ;
file_require_string += '\\ISOPHP\\core::$file_index = $file_index ; ' ;
file_require_string += 'require("/core/init.fephp") ; ' ;
file_require_string += 'require("/core/WindowMessage.fephp") ; ' ;
file_require_string += 'require("/core/bootstrap.fephp") ; ' ;
file_require_string += 'require("/core/index.fephp") ; ' ;

function getParameterByName(name, url) {
    if (!url) {
        url = window.location.href;
    }
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function getFileData(path) {
    var filedata ;
    $.ajax({
        url: path,
        dataType: 'text',
        async: false,
        success: function (data, textStatus, jqXHR) {
            filedata = jqXHR.responseText ;
        },
        failure: function (data, textStatus, jqXHR) {
            filedata = jqXHR.responseText ;
        }
    });
    return filedata;
}

// Set up a PHP module loader
phpEngine.configure({
    include: function (path, promise) {
        var fd = getFileData(path) ;
        promise.resolve(fd);
    }
});

var this_console = console ;
var this_window = window ;
var jQuery = $ ;

var object_to_array = function (source_object) {
    var arr = $.map(source_object, function(el) { return el });
    return arr ;
} ;

phpEngine.expose(jQuery, 'jQuery');
phpEngine.expose(this_window, 'window');
phpEngine.expose(this_console, 'console');
phpEngine.expose(php, 'php');
phpEngine.expose(file_index, 'file_index');
phpEngine.expose(object_to_array, 'object_to_array');

// Write content HTML to the DOM
phpEngine.getStdout().on('data', function (data) {
    document.body.insertAdjacentHTML('beforeEnd', data);
});

// this is looking in the filedata file which is all the php compressed in a key value with path keys
var php_code_string = '<?php '+file_require_string+' ?>' ;
console.log(php_code_string) ;

// Go!
phpEngine.execute(php_code_string).fail(function (error) {
    console.warn('ERROR: ' + error.toString());
});

[].forEach.call(document.querySelectorAll('script[type="text/x-uniter"]'), function (script) {
    console.log('found this ' + script.textContent)  ;
    phpEngine.execute('<?php ' + script.textContent).fail(function (error) {
        console.error(error);
    });
});
