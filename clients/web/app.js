/*
 * Demo of UI interaction with jQuery+Uniter
 *
 * MIT license.
 */
'use strict';

var $ = require('jquery'),
    hasOwn = {}.hasOwnProperty,
    uniter = require('uniter'),
    phpEngine = uniter.createEngine('PHP'),
    output = document.getElementById('output');

var file_require_string = 'require("/core/index.fephp") ; ' ;
// file_require_string += 'require("/assets/php/main.fephp") ; ' ;

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
//var socket = new WebSocket('ws://127.0.0.1:33004') ;



phpEngine.expose($, 'jQuery');
phpEngine.expose(this_window, 'window');
phpEngine.expose(this_console, 'console');
//phpEngine.expose(window.socket, 'socket');

// Write content HTML to the DOM
phpEngine.getStdout().on('data', function (data) {
    document.body.insertAdjacentHTML('beforeEnd', data);
});

// this is looking in the filedata file which is all the php compressed in a key value with path keys
var php_code_string = '<?php echo "dave" ; '+file_require_string+' ?>' ;

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
