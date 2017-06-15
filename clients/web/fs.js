/*
 * Demo of packaging PHP files up with Browserify+Uniter
 *
 * MIT license.
 */
'use strict';

var fs = require('fs'),
    globby = require('globby'),
    path = require('path'),
    files = globby.sync([
        __dirname + '/app/*.fephp',
        __dirname + '/app/*/*.fephp',
        __dirname + '/app/*/*/*.fephp',
        __dirname + '/app/*/*/*.fephp',
        __dirname + '/app/*/View/*.fephp',
        __dirname + '/app/*/View/desktop/*.phptpl',
        __dirname + '/app/*/View/mobile/*.phptpl',
        __dirname + '/app/*/View/web/*.phptpl',
        __dirname + '/app/*/View/*.phptpl',
        __dirname + '/core/*.fephp',
        __dirname + '/core/*/*.fephp',
        __dirname + '/core/*/*/*.fephp',
        __dirname + '/core/*/*/*/*.fephp'
    ]),
    file_index = [],
    file_data = {},
    root = __dirname + '/' ;

console.log("filesData\n") ;
files.forEach(function (filePath) {
    var short_path = filePath.replace(root, '') ;
    short_path = short_path.replace('www/', '') ;
    console.log(short_path) ;
    // file_data[short_path] = fs.readFileSync(filePath).toString() ;
    file_index.push(short_path) ;
});

console.log("\n\nfile_index\n", JSON.stringify(file_index)) ;
fs.writeFileSync(
    __dirname + '/uniter_bundle/file_index.js',
    'module.exports = ' + JSON.stringify(file_index) + ' ;'
);
