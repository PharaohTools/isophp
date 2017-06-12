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
        __dirname + '/php_classes/*.php',
        __dirname + '/php_core/*.php'
    ]),
    main_files = globby.sync([
        __dirname + '/php_classes/*.php',
        __dirname + '/php_core/*.php'
    ]),
    fileData = {},
    mainFileData = [],
    root = __dirname + '/' ;

files.forEach(function (filePath) {
    // fileData[path.relative(root, filePath)] = fs.readFileSync(filePath).toString();
    var short_path = filePath.replace(root, '') ;
    console.log(short_path) ;
    fileData[short_path] = fs.readFileSync(filePath).toString();
});

main_files.forEach(function (filePath) {
    // fileData[path.relative(root, filePath)] = fs.readFileSync(filePath).toString();
    var short_path = filePath.replace(root, '') ;
    console.log(short_path) ;
    mainFileData.push(short_path) ;
});

fs.writeFileSync(
    __dirname + '/uniter_bundle/fileData.js',
    'module.exports = ' + JSON.stringify(fileData) + ';'
);

fs.writeFileSync(
    __dirname + '/uniter_bundle/mainFiles.js',
    'module.exports = ' + JSON.stringify(mainFileData) + ';'
);