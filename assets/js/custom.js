// function IsNewTab() {
//   return $.cookie('TabOpen');
// }

// $(function() {
//   if (!IsNewTab()) {
//     $.cookie('TabOpen', "YES", {
//     path: '/'
//     });
//     $(window).unload(function() {
//     $.removeCookie('TabOpen', {
//       path: '/'
//     });
//     });
//   } else {
//     // alert('already some tab open')
//     //OR
//     window.top.close();
//   }
// });
/* end cookies for prevent to open the project on multiple tab */


$('.spinner').hide();
$.ajaxSetup({
    beforeSend: function(){ 
      $('#wrapperContent').addClass('faddedBox');
      $('.spinner').show();            
    },
    complete: function(){
      $('#wrapperContent').removeClass('faddedBox');
      $('.spinner').hide();
    }
});
/* end global ajax before and complete section */

$(document).ready(function(){
    $(".submenu > a").click(function(e) {
    e.preventDefault();
    var $li = $(this).parent("li");
    var $ul = $(this).next("ul");

    if($li.hasClass("open")) {
      $ul.slideUp(350);
      $li.removeClass("open");
    } else {
      $(".nav > li > ul").slideUp(350);
      $(".nav > li").removeClass("open");
      $ul.slideDown(350);
      $li.addClass("open");
    }
  });
  
});