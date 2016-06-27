/*
  By Osvaldas Valutis, www.osvaldas.info
  Available for use under the MIT License
*/



;(function( $, window, document, undefined )
{
  $.fn.doubleTapToGo = function( params )
  {
    if( !( 'ontouchstart' in window ) &&
      !navigator.msMaxTouchPoints &&
      !navigator.userAgent.toLowerCase().match( /windows phone os 7/i ) ) return false;

    this.each( function()
    {
      var curItem = false;

      $( this ).on( 'click', function( e )
      {
        var item = $( this );
        if( item[ 0 ] != curItem[ 0 ] )
        {
          e.preventDefault();
          curItem = item;
        }
      });

      $( document ).on( 'click touchstart MSPointerDown', function( e )
      {
        var resetItem = true,
          parents   = $( e.target ).parents();

        for( var i = 0; i < parents.length; i++ )
          if( parents[ i ] == curItem[ 0 ] )
            resetItem = false;

        if( resetItem )
          curItem = false;
      });
    });
    return this;
  };
})( jQuery, window, document );



/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 * ======================================================================== */

(function($) {

  // Use this variable to set up the common and page specific functions. If you
  // rename this variable, you will also need to rename the namespace below.
  var Sage = {
    // All pages
    'common': {
      init: function() {
        // JavaScript to be fired on all pages
      },
      finalize: function() {
        // JavaScript to be fired on all pages, after page specific JS is fired
      }
    },
    // Home page
    'home': {
      init: function() {
        // JavaScript to be fired on the home page
      },
      finalize: function() {
        // JavaScript to be fired on the home page, after the init JS
      }
    },
    // About us page, note the change from about-us to about_us.
    'about_us': {
      init: function() {
        // JavaScript to be fired on the about us page
      }
    }
  };

  // The routing fires all common scripts, followed by the page specific scripts.
  // Add additional events for more control over timing e.g. a finalize event
  var UTIL = {
    fire: function(func, funcname, args) {
      var fire;
      var namespace = Sage;
      funcname = (funcname === undefined) ? 'init' : funcname;
      fire = func !== '';
      fire = fire && namespace[func];
      fire = fire && typeof namespace[func][funcname] === 'function';

      if (fire) {
        namespace[func][funcname](args);
      }
    },
    loadEvents: function() {
      // Fire common init JS
      UTIL.fire('common');

      // Fire page-specific init JS, and then finalize JS
      $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function(i, classnm) {
        UTIL.fire(classnm);
        UTIL.fire(classnm, 'finalize');
      });

      // Fire common finalize JS
      UTIL.fire('common', 'finalize');
    }
  };

  // Load Events
  $(document).ready(UTIL.loadEvents);
  
  //on page load in mobile close tile finder blocks 
  function checkIfMobile() {
      if( (navigator.appVersion.toLowerCase().indexOf("mobile")>=0 && navigator.appVersion.toLowerCase().indexOf("android")>=0) || (navigator.appVersion.toLowerCase().indexOf("mobile")>=0 && navigator.appVersion.toLowerCase().indexOf("ipad")<0) ) {
          $('#store_categories_content').slideUp("slow");
          $('#featured_content').slideUp("slow");
      }
  }
  checkIfMobile();
  // Scripts for booking form
  $('#retrieve_form').submit(function(){
      var booking_id = parseInt(""+document.forms['retrieve_form'].booking_id.value,10);  
      var last_booking_id = parseInt("<?=$last_booking_id?>",10);
      var alertMessage = 'Sorry, your booking number is invalid, if you had previously \nmade a booking, please find your booking reference number \nin your email entitled: \n"TileMob.com.au - Your In-Showroom Consultation Booking"';
      if(document.forms['retrieve_form'].booking_id.value == "" && document.forms['retrieve_form'].booking_email.value == ""){
        alert(alertMessage);
        return false;
      } else if(booking_id.length < 4 || booking_id > last_booking_id || booking_id == 0) {
        alert(alertMessage);
        return false;
      } else {
        return true;
      }
  });
  var ConsultationBookingForm = {
    projectType: function(){
                    var value = $('#option_question2').val();
                    if(value.indexOf('Residential') >= 0) {
                      $('#residential_row').show();
                      $('#commercial_row').hide();
                    }
                    else if(value.indexOf('Commercial')>=0){
                      $('#residential_row').hide();
                      $('#commercial_row').show();
                    }
                    else {
                      $('#residential_row').hide();
                      $('#commercial_row').hide();
                    }
                }
  }
  $('#option_question2').change(function(){
      ConsultationBookingForm.projectType();
  });
  $('#clear-form').click(function(){
      $('input[type="text"],textarea,input[type="date"],input[type="email"],input[type="tel"]').each(function() {
          $(this).val('');
      });
      $('select').each(function(){
          $(this).val('------ Make a Selection ------');
      });
      $('input[type="checkbox"]').each(function(){
          $(this).prop('checked',false);
      });
  });


  //prevent page from navigating on single top on mobile devices

  $( '#store_categories li:has(ul)' ).doubleTapToGo();

  // make storage categories as accordion in mobile view
  $('.slide_store h1').click(function(event) {
      if( (navigator.appVersion.toLowerCase().indexOf("mobile")>=0 && navigator.appVersion.toLowerCase().indexOf("android")>=0) || (navigator.appVersion.toLowerCase().indexOf("mobile")>=0 && navigator.appVersion.toLowerCase().indexOf("ipad")<0) ) {
          $('#store_categories_content').toggle("slow");
      }
  });
  $('.slide_feature h1').click(function(event) {
      if( (navigator.appVersion.toLowerCase().indexOf("mobile")>=0 && navigator.appVersion.toLowerCase().indexOf("android")>=0) || (navigator.appVersion.toLowerCase().indexOf("mobile")>=0 && navigator.appVersion.toLowerCase().indexOf("ipad")<0) ) {
          $('#featured_content').toggle("slow");
      }
      // $('#featured_content').slideToggle( "slow" );
  });

  //change active tab color

  var Navigation = {
    activate: function(e){
        // console.log('activate function called');
        $(e).find('li').each(function(){
            var href = $(this).find('a').attr('href').split(document.domain+"/")[1],
                splitHref = location.href.split(document.domain+"/")[1];
                //splitHref = $(this).find('a').attr('href').split('.aspx')[0]+"/";
            
            if(!href) {
              href=$(this).find('a').attr('href').slice(1);
            }
            // console.log('this href is '+href+' and splitHref is '+splitHref+'---');
            if(splitHref && href) {
              
                if(splitHref.length>0 && splitHref.indexOf(href)>=0 ) {
                    $(this).addClass("active");
                }
                else {
                    $(this).removeClass("active");
                }
              
            }
        });
    }
  }
  Navigation.activate('#menu-primary-menu');
  
})(jQuery); // Fully reference jQuery after this point.








