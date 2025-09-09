<div class="offcanvas  bg-primary offcanvas-bottom" tabindex="-1" id="cookieConsentOffcanvas" aria-labelledby="cookieConsentOffcanvasLabel" data-bs-backdrop="static">
    <div class="offcanvas-header bg-primary">
      <h5 class="offcanvas-title" id="cookieConsentOffcanvasLabel">Cookie Policy</h5>
      <button type="button" class="btn-close bg-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body" style="height: auto !important">
      <p>World Business Guide - WBG24.com - uses cookies and other technologies that are essential to provide you the best services and site functionality, as described in our <a class="text-secondary" href="{{ route('privacyAndPolicy') }}" target="_blank">Privacy Policy</a>.</p>
      <p>If you agree and click "Accept all", you allow us to store cookies on your device and use similar technologies.</p>
      
      <div class="d-flex gap-2 justify-content-end mt-3">
        <button type="button" class="btn btn-outline-secondary" id="declineCookies">Decline all</button>
        <button type="button" class="btn btn-secondary" id="acceptCookies">Accept all</button>
      </div>
    </div>
  </div>
  
  <style>
    
    .offcanvas-bottom {
      height: auto;
      border-top-left-radius: 0.5rem;
      border-top-right-radius: 0.5rem;
    }
    @media (min-width: 576px) {
      .offcanvas-bottom {
        left: 0%;
        bottom: 0%;
      }
    }
  </style>
  
  <script>
  $(document).ready(function() {
    // Check if cookie consent was already given
    if (!getCookie('cookie_consent')) {
      // Show the offcanvas if no consent was given yet
      var cookieOffcanvas = new bootstrap.Offcanvas(document.getElementById('cookieConsentOffcanvas'));
      cookieOffcanvas.show();
    }
  
    // Handle accept button click
    $('#acceptCookies').click(function() {
      setCookie('cookie_consent', 'accepted', 365);
      bootstrap.Offcanvas.getInstance(document.getElementById('cookieConsentOffcanvas')).hide();
      // You can add additional code here for when cookies are accepted
    });
  
    // Handle decline button click
    $('#declineCookies').click(function() {
      setCookie('cookie_consent', 'declined', 365);
      bootstrap.Offcanvas.getInstance(document.getElementById('cookieConsentOffcanvas')).hide();
      // You can add additional code here for when cookies are declined
    });
  
    // Helper function to set cookie
    function setCookie(name, value, days) {
      var expires = "";
      if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
      }
      document.cookie = name + "=" + (value || "") + expires + "; path=/; SameSite=Lax";
    }
  
    // Helper function to get cookie
    function getCookie(name) {
      var nameEQ = name + "=";
      var ca = document.cookie.split(';');
      for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
      }
      return null;
    }
  });
  </script>