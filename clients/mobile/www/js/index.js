// progress on transfers from the server to the client (downloads)
function updateProgress (oEvent) {
    if (oEvent.lengthComputable) {
        var percentComplete = oEvent.loaded / oEvent.total;
        str = "The transfer is " + percentComplete + "% complete." ;
        console.log(str);
    } else {
        // Unable to compute progress information since the total size is unknown
        str = "Unable to compute progress information since the total size is unknown" ;
        console.log(str);
    }
}

function transferComplete(evt) {
    console.log("The transfer is complete.");
    console.log("Begin app code eval") ;
    eval(this.responseText);
    console.log("End app code eval") ;
}

function transferFailed(evt) {
    console.log("An error occurred while transferring the file.");
}

function transferCanceled(evt) {
    console.log("The transfer has been canceled by the user.");
}

/*
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */
function app_initialize() {
    // document.addEventListener('deviceready', this.onDeviceReady.bind(this), false);
}

// deviceready Event Handler
//
// Bind any cordova events here. Common events are:
// 'pause', 'resume', etc.
function on_device_ready() {
    // this.receivedEvent('deviceready');
    // document.getElementById("app-loader").className = "";
    console.log('device ready notify') ;
    var oReq = new XMLHttpRequest();
    console.log('new http req object') ;
    oReq.addEventListener("progress", updateProgress);
    oReq.addEventListener("load", transferComplete);
    oReq.addEventListener("error", transferFailed);
    oReq.addEventListener("abort", transferCanceled);
    oReq.open("GET", "file:///android_asset/www/uniter_bundle/bundle.js");
    oReq.send() ;
    console.log('req open') ;
}

app_initialize();

document.addEventListener("deviceready", on_device_ready, false);