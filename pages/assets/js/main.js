window.addEventListener("DOMContentLoaded", function () {
  const $ = jQuery;

  ("use strict");

  var loader = function () {
    setTimeout(function () {
      if ($("#pb_loader").length > 0) {
        $("#pb_loader").removeClass("show");
      }
    }, 700);
  };
  loader();

  // scroll
  var scrollWindow = function () {
    let wasDarkNav = false;
    $(window).scroll(function () {
      const scrollTop = window.scrollY;
      const navbar = document.querySelector(".pg-navbar");

      if (scrollTop > 0 && navbar.getAttribute("data-home") === "") {
        navbar.classList.add("scrolled");
      }

      if (scrollTop === 0 && navbar.getAttribute("data-home") === "") {
        navbar.classList.remove("scrolled");
      }
    });
  };
  scrollWindow();

  const scrollElement = function (selector) {
    const element = $(selector);
    toggleElement();
    $(window).scroll(function () {
      toggleElement();
    });
    function toggleElement() {
      const scrollTop = $(window).scrollTop();

      if (scrollTop > 350) {
        element.addClass("show");
        element.removeClass("hide");
      }
      if (scrollTop < 350) {
        element.removeClass("show");
        element.addClass("hide");
      }
    }
  };
  scrollElement(".btn-top");

  // slick sliders
  var slickSliders = function () {
    $(".single-item").slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      dots: true,
      infinite: true,
      autoplay: false,
      autoplaySpeed: 2000,
      nextArrow:
        '<span class="next"><i class="ion-ios-arrow-right"></i></span>',
      prevArrow: '<span class="prev"><i class="ion-ios-arrow-left"></i></span>',
      arrows: true,
      draggable: false,
      adaptiveHeight: true,
    });

    $(".single-item-no-arrow").slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      dots: true,
      infinite: true,
      autoplay: true,
      autoplaySpeed: 3000,
      nextArrow:
        '<span class="next"><i class="ion-ios-arrow-right"></i></span>',
      prevArrow: '<span class="prev"><i class="ion-ios-arrow-left"></i></span>',
      arrows: false,
      draggable: false,
    });

    $(".multiple-items").slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      dots: true,
      infinite: true,

      autoplay: true,
      autoplaySpeed: 2000,

      arrows: true,
      nextArrow:
        '<span class="next"><i class="ion-ios-arrow-right"></i></span>',
      prevArrow: '<span class="prev"><i class="ion-ios-arrow-left"></i></span>',
      draggable: false,
      responsive: [
        {
          breakpoint: 1125,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1,
            infinite: true,
            dots: true,
          },
        },
        {
          breakpoint: 900,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
          },
        },
        {
          breakpoint: 580,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
          },
        },
      ],
    });

    $(".js-pb_slider_content").slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      fade: true,
      asNavFor: ".js-pb_slider_nav",
      adaptiveHeight: false,
    });
    $(".js-pb_slider_nav").slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      asNavFor: ".js-pb_slider_content",
      dots: false,
      centerMode: true,
      centerPadding: "0px",
      focusOnSelect: true,
      arrows: false,
    });

    $(".js-pb_slider_content2").slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      fade: true,
      asNavFor: ".js-pb_slider_nav2",
      adaptiveHeight: false,
    });
    $(".js-pb_slider_nav2").slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      asNavFor: ".js-pb_slider_content2",
      dots: false,
      centerMode: true,
      centerPadding: "0px",
      focusOnSelect: true,
      arrows: false,
    });
  };
  slickSliders();

  // navigation
  var OnePageNav = function () {
    $(".smoothscroll[href^='#'], #probootstrap-navbar a[href^='#']").on(
      "click",
      function (e) {
        e.preventDefault();
        var hash = this.hash,
          navToggler = $(".navbar-toggler"),
          navBar = $(".pg-navmenu");
        $("html, body").animate(
          {
            scrollTop: $(hash).offset().top,
          },
          700,
          "easeInOutExpo",
          function () {
            window.location.hash = hash;
          }
        );
        if (navBar.hasClass("show")) {
          navToggler.click();
        }
      }
    );
    $("body").on("activate.bs.scrollspy", function () {
      console.log("nice");
    });
  };
  OnePageNav();

  var offCanvasNav = function () {
    var toggleNav = $(".js-pb_nav-toggle"),
      offcanvasNav = $(".js-pb_offcanvas-nav_v1");
    if (toggleNav.length > 0) {
      toggleNav.click(function (e) {
        $(this).toggleClass("active");
        offcanvasNav.addClass("active");
        e.preventDefault();
      });
    }
    offcanvasNav.click(function (e) {
      if (offcanvasNav.hasClass("active")) {
        offcanvasNav.removeClass("active");
        toggleNav.removeClass("active");
      }
      e.preventDefault();
    });
  };
  offCanvasNav();

  var ytpPlayer = function () {
    if ($(".ytp_player").length > 0) {
      $(".ytp_player").mb_YTPlayer();
    }
  };
  ytpPlayer();

  const tooltipTriggerList = document.querySelectorAll(
    '[data-bs-toggle="tooltip"]'
  );
  const tooltipList = [...tooltipTriggerList].map(
    (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
  );

  $(".dt-magic-link-language-selector a").click((e) => {
    const val = $(e.currentTarget).data("value");
    const urlParams = new URLSearchParams(window.location.search);
    urlParams.set("lang", val);
    window.location.search = urlParams;
  });
});

window.addEventListener("load", function ($) {
  jQuery("body")
    .data("spy", "scroll")
    .data("target", "#pg-navbar")
    .data("offset", "200");

  function showElements(selector, show) {
    document
      .querySelectorAll(selector)
      .forEach((element) => (element.style.display = show ? "block" : "none"));
  }
});

if (pg_global.is_logged_in && !pg_global.user.language) {
  /* save the user details with the current language */

  window.api_fetch(`${pg_global.root}pg-api/v1/user/save_details`, {
    method: "POST",
    body: JSON.stringify({
      language: pg_global.current_language,
    }),
  });
}

if (window.Sentry) {
  const environments = {
    "prayer.global": "production",
    "staging.prayer.global": "staging",
  };
  const environment = environments[window.location.hostname] || "development";
  Sentry.init({
    dsn: "https://f3b365f3b25c46e9ac46b9406d01cdc0@red-gopher.pikapod.net/2",
    tracesSampleRate: 0.01,
    environment,
  });
}
