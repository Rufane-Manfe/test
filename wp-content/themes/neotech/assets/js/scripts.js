(function($){
  "use strict";

  var $window = $(window);

  $window.on('load', function() {
    $window.trigger("resize");
  });

  // Preloader
  $('.loader').fadeOut();
  $('.loader-mask').delay(350).fadeOut('slow');


  // Init
  initFlickity();
  initMasonry();

  $window.on('resize', function() {
    hideSidenav();
  });

  /* Detect Browser Size
  -------------------------------------------------------*/
  var minWidth;
  if (Modernizr.mq('(min-width: 0px)')) {
    // Browsers that support media queries
    minWidth = function (width) {
      return Modernizr.mq('(min-width: ' + width + 'px)');
    };
  }
  else {
    // Fallback for browsers that does not support media queries
    minWidth = function (width) {
      return $window.width() >= width;
    };
  }

  /* Mobile Detect
  -------------------------------------------------------*/
  if (/Android|iPhone|iPad|iPod|BlackBerry|Windows Phone/i.test(navigator.userAgent || navigator.vendor || window.opera)) {
     $("html").addClass("mobile");
     $('.dropdown-toggle').attr('data-toggle', 'dropdown');
  }
  else {
    $("html").removeClass("mobile");
  }

  /* IE Detect
  -------------------------------------------------------*/
  if(Function('/*@cc_on return document.documentMode===10@*/')()){ $("html").addClass("ie"); }

  /* Sticky Navigation
  -------------------------------------------------------*/
  $window.scroll(function(){
    scrollToTop();
    stickyNav();
  });

  var $stickyNav = $('.nav--sticky');
  var $nav = $('.nav');

  function stickyNav() {
    if ($window.scrollTop() > 2) {
      $stickyNav.addClass('sticky');
      $nav.addClass('sticky');
    } else {
      $stickyNav.removeClass('sticky');
      $nav.removeClass('sticky');
    }
  }

  /* Mobile Navigation
  -------------------------------------------------------*/
  var $sidenav = $('#sidenav'),
      $mainContainer = $('#main-container'),
      $navIconToggle = $('#nav-icon-toggle'),
      $navHolder = $('.nav__holder'),
      $contentOverlay = $('.content-overlay'),
      $htmlContainer = $('html');


  $navIconToggle.on('click', function(e) {
    e.stopPropagation();
    $(this).toggleClass('nav-icon-toggle--is-open');
    $sidenav.toggleClass('sidenav--is-open');
    $mainContainer.toggleClass('main-container--is-pushed');
    $navHolder.toggleClass('nav__holder--is-pushed');
    $contentOverlay.toggleClass('content-overlay--is-visible');
    $htmlContainer.toggleClass('oh');
  });

  function resetNav() {
    $navIconToggle.removeClass('nav-icon-toggle--is-open');
    $sidenav.removeClass('sidenav--is-open');
    $mainContainer.removeClass('main-container--is-pushed');
    $navHolder.removeClass('nav__holder--is-pushed');
    $contentOverlay.removeClass('content-overlay--is-visible');
    $htmlContainer.removeClass('oh');
  }

  function hideSidenav() {
    if( minWidth(992) ) {
      resetNav();
    }
  }

  $contentOverlay.on('click', function() {
    resetNav();
  });

  var $dropdownTrigger = $('.nav__dropdown-trigger'),
      $navDropdownMenu = $('.nav__dropdown-menu'),
      $navDropdown = $('.nav__dropdown');


  if ( $('html').hasClass('mobile') ) {

    $('body').on('click',function() {
      $navDropdownMenu.addClass('hide-dropdown');
    });

    if ( minWidth(992) ) {
      $navDropdown.on('click', '> a', function(e) {
        e.preventDefault();
      });
    }    

    $navDropdown.on('click',function(e) {
      e.stopPropagation();
      $navDropdownMenu.removeClass('hide-dropdown');
    });
  }


  /* Sidenav Menu
  -------------------------------------------------------*/
  $('.sidenav__menu-toggle').on('click', function(e) {
    e.preventDefault();

    var $this = $(this);

    $this.parent().siblings().removeClass('sidenav__menu--is-open');
    $this.parent().siblings().find('li').removeClass('sidenav__menu--is-open');
    $this.parent().find('li').removeClass('sidenav__menu--is-open');
    $this.parent().toggleClass('sidenav__menu--is-open');

    if ($this.next().hasClass('show')) {
      $this.next().removeClass('show').slideUp(350);
    } else {
      $this.parent().parent().find('li .sidenav__menu-dropdown').removeClass('show').slideUp(350);
      $this.next().toggleClass('show').slideToggle(350);
    }
  });


  /* Nav Seacrh
  -------------------------------------------------------*/
  (function() {
    var navSearchTrigger = $('.nav__search-trigger'),
        navSearchTriggerIcon = navSearchTrigger.find('i'),
        navSearchBox = $('.nav__search-box'),
        navSearchInput = $('.nav__search-input');

    navSearchTrigger.on('click', function(e){
      e.preventDefault();
      navSearchTriggerIcon.toggleClass('ui-close');
      navSearchBox.slideToggle();
      navSearchInput.focus();
    });
  })();


  /* YouTube Video Playlist
  -------------------------------------------------------*/
  (function(){
    var videoPlaylistListItem = $('.video-playlist__list-item'),
        videoPlaylistContentVideo = $('.video-playlist__content-video');

    videoPlaylistListItem.on('click', function(e){
      e.preventDefault();
      var $this = $(this);
      var thumbVideoUrl = $this.attr('href');

      videoPlaylistContentVideo.attr('src', thumbVideoUrl);

      $this.siblings().removeClass('video-playlist__list-item--active');
      $this.addClass('video-playlist__list-item--active');

    });

  })();


  /* Tabs
  -------------------------------------------------------*/
  $('.tabs__trigger').on('click', function(e) {
    var currentAttrValue = $(this).attr('href');
    $('.tabs__content-trigger ' + currentAttrValue).stop().fadeIn(1000).siblings().hide();
    $(this).parent('li').addClass('tabs__item--active').siblings().removeClass('tabs__item--active');
    e.preventDefault();
  });


  /* Flickity Slider
  -------------------------------------------------------*/
  function initFlickity() {
    // Single post gallery
    $('.flickity-single-carousel').flickity({
      cellAlign: 'left',
      imagesLoaded: true,
      pageDots: true,
      wrapAround: true,
    });
  }

  /* Masonry
  -------------------------------------------------------*/
  function initMasonry() {
    var $grid = $('.masonry-grid').imagesLoaded( function() {
      $grid.masonry({
        itemSelector: '.masonry-item',
        columnWidth: '.masonry-item',
        percentPosition: true
      });
    });
  }


  /* Sticky sidebar
  -------------------------------------------------------*/
  (function() {
    var $stickyCol = $('.sticky-col');
    if( $stickyCol.length ) {
      $stickyCol.stick_in_parent({
        offset_top: 100
      });
    }
  })();


  /* Responsive Tables
  -------------------------------------------------------*/
  (function() {
    var $table = $('.wp-block-table');
    if ( $table.length > 0 ) {
      $table.wrap('<div class="table-responsive"></div>');
    }
  })();
  

  /* Scroll to Top
  -------------------------------------------------------*/
  function scrollToTop() {
    var scroll = $window.scrollTop();
    var $backToTop = $("#back-to-top");
    if (scroll >= 50) {
      $backToTop.addClass("show");
    } else {
      $backToTop.removeClass("show");
    }
  }

  $('a[href="#top"]').on('click',function(){
    $('html, body').animate({scrollTop: 0}, 550 );
    return false;
  });

})(jQuery);