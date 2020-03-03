(function($){
  $(function(){

    $('.sidenav').sidenav();

  }); // end of document ready
})(jQuery); // end of jQuery name space


$(document).ready(function() {
  $('input#input_text, textarea#textarea2').characterCounter();
});


document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('select');
  var instances = M.FormSelect.init(elems, options);
});
$(document).ready(function(){
  $('select').formSelect();
});


document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('.modal');
  var instances = M.Modal.init(elems, options);
});

// Or with jQuery

$(document).ready(function(){
  $('.modal').modal();
});