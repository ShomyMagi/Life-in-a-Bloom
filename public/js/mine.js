(function ($){
    
    'use strict';
    
    $(document).ready(function(){
        test();
    });
    
    function test()
    {
        var div = $('.errors');
        if(div.children().length > 0)
        {
            div.fadeIn();
            div.siblings('.close').fadeIn();
        }
    }
    
})(jQuery);

$(function() {

    $('#login-form-link').click(function(e) {
		$("#login-form").delay(100).fadeIn(100);
 		$("#register-form").fadeOut(100);
		$('#register-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});
	$('#register-form-link').click(function(e) {
		$("#register-form").delay(100).fadeIn(100);
 		$("#login-form").fadeOut(100);
		$('#login-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});

});


$(document).ready(function() {
  $(".wrapper-paging").show();
  TABLE.paginate('.table', 5);
});

var TABLE = {};

TABLE.paginate = function(table, pageLength) {
  // 1. Set up paging information
  var $table = $(table);
  var $rows = $table.find('tbody > tr');
  var numPages = Math.ceil($rows.length / pageLength) - 1;
  var current = 0;
  
  // 2. Set up the navigation controls
  var $nav = $table.parents('.table-wrapper').find('.wrapper-paging ul');
  var $back = $nav.find('li:first-child a');
  var $next = $nav.find('li:last-child a');
  
  $nav.find('a.paging-this strong').text(current + 1);
  $nav.find('a.paging-this span').text(numPages + 1);
  $back
    .addClass('paging-disabled')
    .click(function() {
      pagination('<');
    });
  $next.click(function() {
    pagination('>');
  });
  
  // 3. Show initial rows
  $rows
    .hide()
    .slice(0,pageLength)
    .show();
    
  pagination = function (direction){
    reveal = function (current){
      $back.removeClass('paging-disabled');
      $next.removeClass('paging-disabled');
      
      $rows
        .hide()
        .slice(current * pageLength, current * pageLength + pageLength)
        .show();
        
      $nav.find('a.paging-this strong').text(current + 1);
    };
    // 4. Move previous and next  
  	if (direction == '<') { // previous
      if (current > 1) {
        reveal(current -= 1);
      }
      else if (current == 1) {
        reveal (current -= 1);
        $back.addClass('paging-disabled');
      }
    } else {
      if (current < numPages - 1) {
        reveal(current += 1);
      }
      else if (current == numPages - 1) {
        reveal(current += 1);
        $next.addClass('paging-disabled');
      }
    }
  }
}