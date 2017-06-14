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
        __dirname + '/www/app/*.fephp',
        __dirname + '/www/app/*/*.fephp',
        __dirname + '/www/app/*/*/*.fephp',
        __dirname + '/www/app/*/*/*.fephp',
        __dirname + '/www/app/*/View/*.fephp',
        __dirname + '/www/app/*/View/desktop/*.phptpl',
        __dirname + '/www/app/*/View/mobile/*.phptpl',
        __dirname + '/www/app/*/View/web/*.phptpl',
        __dirname + '/www/app/*/View/*.phptpl',
        __dirname + '/www/core/*.fephp',
        __dirname + '/www/core/*/*.fephp',
        __dirname + '/www/core/*/*/*.fephp',
        __dirname + '/www/core/*/*/*/*.fephp'
    ]),
    file_index = [],
    file_data = {},
    root = __dirname + '/' ;

console.log("filesData\n") ;
files.forEach(function (filePath) {
    // fileData[path.relative(root, filePath)] = fs.readFileSync(filePath).toString();
    var short_path = filePath.replace(root, '') ;
    short_path = short_path.replace('www/', '') ;
    console.log(short_path) ;
    var one_file = fs.readFileSync(filePath).toString() ;
    // console.log("File for: " + short_path + one_file) ;
    file_data[short_path] = one_file ;
    // console.log('fd', short_path, one_file) ;
    file_index.push(short_path) ;
});

console.log("\n\nfile_data\n", file_data, JSON.stringify(file_data)) ;
fs.writeFileSync(
    __dirname + '/www/uniter_bundle/file_data.js',
    'module.exports = ' + JSON.stringify(file_data) + ';'
);

console.log("\n\nfile_index\n", JSON.stringify(file_index)) ;
fs.writeFileSync(
    __dirname + '/www/uniter_bundle/file_index.js',
    'module.exports = ' + JSON.stringify(file_index) + ';'
);
