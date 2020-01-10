(function($){
  $(function(){

    $('.sidenav').sidenav();

  }); // end of document ready
})(jQuery); // end of jQuery name space


// Mobile Collapse Button and Sidenav
document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('.sidenav');
  var instances = M.Sidenav.init(elems, options);
});
// Initialize collapsible (uncomment the lines below if you use the dropdown variation)
// var collapsibleElem = document.querySelector('.collapsible');
// var collapsibleInstance = M.Collapsible.init(collapsibleElem, options);
// Or with jQuery
$(document).ready(function(){
  $('.sidenav').sidenav();
});
// Mobile Collapse Button and Sidenav


// Selects
document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('select');
  var instances = M.FormSelect.init(elems, options);
});
// Or with jQuery
$(document).ready(function(){
  $('select').formSelect();
});
// Selects


// Floating Action Button
document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('.fixed-action-btn');
  var instances = M.FloatingActionButton.init(elems, options);
});
// Or with jQuery
$(document).ready(function(){
  $('.fixed-action-btn').floatingActionButton();
});
// Floating Action Button


// Tooltips
document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('.tooltipped');
  var instances = M.Tooltip.init(elems, options);
});
// Or with jQuery
$(document).ready(function(){
  $('.tooltipped').tooltip();
});
// Tooltips



// Navbar
document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('.sidenav');
  var instances = M.Sidenav.init(elems, options);
});
// Or with jQuery
$(document).ready(function(){
  $('.sidenav').sidenav();
});
$(".dropdown-trigger").dropdown();
// Navbar