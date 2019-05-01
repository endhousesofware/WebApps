/*!
 * ehswebring.js
 * Copyright(c) 2019 End House Software
 * 
 * Version 1.0.0  Initial Version
 */

var ringname = "";
var ringsite = 0;

function initwebring(webringname) {
  ringname = webringname;
  setTimeout("initwebringinternal();",1000); // to make sure the DOM is setup
}

function initwebringinternal() {
  displaywebring(ringname,0);
}

function displaywebring(name,site) {
  ringsite = site; // store current web ring sitye index in a global var
  webringurl = encodeURI("https://ehsphpapps.herokuapp.com/ehswebrings/ehswebring.php?webringname=" + name + "&webringindex=" + site);
  $('#ehswebring').load(webringurl);
}

function setringsite(num) {
  ringsite = num;
}
