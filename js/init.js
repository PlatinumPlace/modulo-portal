(function($){
  $(function(){

    $('.sidenav').sidenav();

  }); // end of document ready
})(jQuery); // end of jQuery name space



// Selects
document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('select');
  var instances = M.FormSelect.init(elems, options);
});
// Or with jQuery
$(document).ready(function(){
  $('select').formSelect();
});


// Floating Action Button
document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('.fixed-action-btn');
  var instances = M.FloatingActionButton.init(elems, options);
});
// Or with jQuery
$(document).ready(function(){
  $('.fixed-action-btn').floatingActionButton();
});





// Tooltips
document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('.tooltipped');
  var instances = M.Tooltip.init(elems, options);
});
// Or with jQuery
$(document).ready(function(){
  $('.tooltipped').tooltip();
});





//Navbar
document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('.sidenav');
  var instances = M.Sidenav.init(elems, options);
});
// Or with jQuery
$(document).ready(function(){
  $('.sidenav').sidenav();
});



//Modals
document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('.modal');
  var instances = M.Modal.init(elems, options);
});
// Or with jQuery
$(document).ready(function(){
  $('.modal').modal();
});


//Dropdown
document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('.dropdown-trigger');
  var instances = M.Dropdown.init(elems, options);
});
// Or with jQuery
$('.dropdown-trigger').dropdown();