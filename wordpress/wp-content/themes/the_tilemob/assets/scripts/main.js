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
})(jQuery); // Fully reference jQuery after this point.
