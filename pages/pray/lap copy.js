window.addEventListener('load', function(){
  /**
   * API HANDLERS
   */
  window.api_post = ( action, data ) => {
    return window.api_fetch( window.pg_global.root + jsObject.parts.root + '/v1/' + jsObject.parts.type, {
      method: "POST",
      body: JSON.stringify({ action: action, parts: jsObject.parts, data: data }),
    })
  }
  window.api_post_global = ( type, action, data = null ) => {
    return window.api_fetch( `${window.pg_global.root}pg-api/v1/${type}/${action}`, {
      method: "POST",
      body: data !== null ? JSON.stringify(data) : null,
    })
  }
  function load_next_content() {
    window.api_post( 'refresh', { grid_id: window.current_content.location.grid_id } )
      .then(function(location) {
        if ( location === false ) {
          window.location = '/'+jsObject.parts.root+'/'+jsObject.parts.type+'/'+jsObject.parts.public_key
        }
        window.next_content = location
      })
  }
  function advance_to_next_location() {
    toggle_timer( false )
    button_progress.css('width', '0' )
    window.time = 0
    window.time_finished = false
    load_location()
  }
  function ip_location() {
    window.api_post_global( 'user', 'ip_location' )
      .then(function(location) {
        window.user_location = []
        if ( location ) {
          let pg_user_hash = localStorage.getItem('pg_user_hash')
          if ( ! pg_user_hash || pg_user_hash === 'undefined' ) {
            localStorage.setItem('pg_user_hash', location.hash )
          } else {
            location.hash = pg_user_hash
          }
          window.user_location = location
        }
      })
  }


  /**
   * Progress widget
   */
  let div = jQuery('#content')

  let praying_panel = jQuery('#praying-panel')
  let decision_panel = jQuery('#decision-panel')
  let question_panel = jQuery('#question-panel')
  let celebrate_panel = jQuery('#celebrate-panel')
  let location_name = jQuery('#location-name')
  let footer = jQuery('.pg-footer')

  let praying_button = jQuery('#praying_button')
  let button_progress = jQuery('.praying__progress')
  let button_text = jQuery('.praying__text')
  let praying_pause_button = jQuery('#praying__pause_button')
  let praying_continue_button = jQuery('#praying__continue_button')

  let decision_home = jQuery('#decision__home')
  let decision_map = jQuery('#decision__map')
  let decision_next = jQuery('#decision__next')

  let decision_leave = jQuery('#decision__leave')
  let decision_keep_praying = jQuery('#decision__keep_praying')

  // let question_no = jQuery('#question__no')
  let question_yes_done = jQuery('#question__yes_done')
  let question_yes_next = jQuery('#question__yes_next')

  let pace_open_options = jQuery('#option_filter')
  let open_welcome = jQuery('#welcome_screen')
  let decision_modal = jQuery('#decision_leave_modal')
  let pace_buttons = jQuery('.pace')

  let location_map_wrapper = jQuery('#location-map')

  let more_prayer_fuel = jQuery('#more_prayer_fuel')
  let prayer_odometer = jQuery('.prayer-odometer')
  let odometer_location_count = jQuery('.location-count')
  let i

  const ONE_MINUTE = 60 // seconds
  const CELEBRATION_DURATION = 3000 // milliseconds

  window.previous_grids = []
  window.interval = false
  window.percent = 0
  window.time = 0
  window.seconds = ONE_MINUTE
  window.time_finished = false
  window.pace = localStorage.getItem('pg_pace')
  if ( typeof window.pace === 'undefined' || ! window.pace ) {
    window.pace = '1'
    localStorage.setItem('pg_pace', '1' )
  }
  setup_seconds(window.pace)
  setup_items(window.pace)
  window.viewed = localStorage.getItem('pg_viewed')
  if ( typeof window.viewed === 'undefined' || ! window.viewed ) {
    window.viewed = '0'
    localStorage.setItem('pg_viewed', '0' )
  }
  window.items = parseInt( window.pace ) + 6
  window.odometer = {
    location_count: 0,
  }
  window.report_content = []

  footer.hide()

  /**
   * INITIALIZE
   */
  function initialize_location() {
    setup_listeners()

    // set options fields
    pace_buttons.removeClass('btn-secondary').addClass('btn-outline-secondary')
    jQuery('#pace__'+window.pace).removeClass('btn-outline-secondary').addClass('btn-secondary')

    /* Passing query params through api allows different types of laps to use query params in different ways */
    const grid_id = new URL(window.location.href).searchParams.get('grid_id')
    console.log(grid_id)
    // load current location
    window.api_post( 'refresh', { grid_id } )
      .then( function(l1) {
        // no remaining locations, send to map
        console.log(l1)
        if ( ! l1 ) {
          window.location.href = jsObject.map_url
          return
        }
        // load variables
        window.report_content = window.current_content = test_for_redundant_grid( l1 )
        load_location()

        // modal logic
        if ( window.viewed === '0' ) {
          toggle_timer( true )
          open_welcome.modal('show')
          localStorage.setItem('pg_viewed', '1' )
        } else {
          setTimeout(function() {
            jQuery('.tutorial').animate({
              opacity: "toggle"
            })
          }, 5000);
        }

      })

    // load ip tracking
    ip_location()

    // load next location
    window.api_post('refresh', {} )
      .then( function(l2) {
        window.next_content = test_for_redundant_grid( l2 )
      })

    more_prayer_fuel.on('click', function(){
      jQuery('.container.block').show()
      jQuery('#more_prayer_fuel').hide()
    })
  }
  initialize_location() // initialize prayer framework

  function test_for_redundant_grid( content ) {
    if ( typeof content === 'undefined' || typeof content.location === 'undefined' || typeof content.location.grid_id === 'undefined' ){
      return content
    }
    if ( window.previous_grids.includes( content.location.grid_id ) ) {
      window.api_post('refresh', {} )
        .then( function(new_content) {
          // return test_for_redundant_grid( new_content )
          if ( typeof window.test_for_redundant === 'undefined' ) {
            window.test_for_redundant = 0
          }
          if ( window.test_for_redundant < 3 ) {
            window.test_for_redundant++
            return test_for_redundant_grid( new_content )
          }
        })
    } else {
      window.test_for_redundant = 0
      window.previous_grids.push(content.location.grid_id )
      return content
    }
  }
  function setup_seconds(pace) {
    window.seconds = pace * ONE_MINUTE
  }
  function setup_items(pace) {
    window.items = parseInt(pace) + 6
  }
  /**
   * Widget Listeners
   */
  function setup_listeners() {
    praying_button.off('click')
    praying_button.on('click', function( e ) {
      toggle_timer()
    })
    praying_pause_button.off('click')
    praying_pause_button.on('click', function( e ) {
      toggle_timer( true )
    })
    praying_continue_button.off('click')
    praying_continue_button.on('click', function( e ) {
      toggle_timer( false )
    })
    decision_home.off('click')
    decision_home.on('click', () => open_decision_modal( home_callback ))
    function home_callback( e ) {
      if ( jsObject.is_custom ) {
        window.location.href = jsObject.map_url
      } else {
        window.location.href = '/'
      }
    }
    decision_map.off('click')
    decision_map.on('click', () => open_decision_modal( map_callback ) )
    function map_callback( e ) {
      if ( jsObject.is_cta_feature_on === true ) {
        window.location = jsObject.map_url + '?show_cta'
      } else {
        window.location = jsObject.map_url
      }

    }
    decision_next.off('click')
    decision_next.on('click', () => open_decision_modal( next_callback ) )
    function next_callback( e ) {
      window.api_post( 'refresh', {} )
        .then( function(l1) {
          window.report_content = window.current_content = test_for_redundant_grid( l1 )
          load_next_content()
          advance_to_next_location()
        })
    }
    decision_keep_praying.off('click')
    decision_keep_praying.on('click', function(e) {
      toggle_timer()
    })

    function open_decision_modal(callback) {

      if ( window.time < ONE_MINUTE ) {
        decision_modal.modal('show')
      } else {
        // We have prayed for at least a minute so let's celebrate before they move on
        celebrate_prayer()
        setTimeout(
          callback,
          CELEBRATION_DURATION,
        )
      }

      decision_leave.on('click', callback)
    }

    question_yes_done.off('click')
    question_yes_done.on('click', function( e ) {
      celebrate_prayer()
      setTimeout(
        function() {
          if ( jsObject.is_cta_feature_on ) {
            window.location = jsObject.map_url + '?show_cta'
          } else {
            window.location = jsObject.map_url
          }
        }, CELEBRATION_DURATION);
    })
    question_yes_next.off('click')
    question_yes_next.on('click', function( e ) {
      celebrate_prayer()
      setTimeout(
        function()
        {
          advance_to_next_location()
        }, CELEBRATION_DURATION);
    })
    function celebrate_prayer() {
      praying_panel.hide()
      question_panel.hide()
      decision_panel.hide()
      clear_timer()
      celebrate()
      window.celebrationFireworks(CELEBRATION_DURATION)
      update_odometer({ location_count: window.odometer.location_count + 1})
    }
    pace_buttons.off('click')
    pace_buttons.on('click', function(e) {
      console.log(e.currentTarget.id)
      pace_buttons.removeClass('btn-secondary').addClass('btn-outline-secondary')
      jQuery('#'+e.currentTarget.id).removeClass('btn-outline-secondary').addClass('btn-secondary')


      window.pace = e.currentTarget.value
      localStorage.setItem( 'pg_pace', window.pace )

      setup_seconds(window.pace)
      setup_items(window.pace)

      jQuery('.container.block').show()
      jQuery('.container.block:nth-child(+n+' + window.items + ')').hide()
    })
    pace_open_options.off('show.bs.modal')
    pace_open_options.on('show.bs.modal', function () {
      toggle_timer( true )
    })
    pace_open_options.off('hide.bs.modal')
    pace_open_options.on('hide.bs.modal', function () {
      toggle_timer( true )
    })
    open_welcome.off('hide.bs.modal')
    open_welcome.on('hide.bs.modal', function () {
      toggle_timer( false )
      setTimeout(function() {
        jQuery('.tutorial').animate({
          opacity: "toggle"
        })
      }, 5000);
    })
  }
  function toggle_timer( set_to_pause = false ) {
    /* Default to set_to_pause param; fall back to window.paused */
    const pauseTimer = set_to_pause === true || typeof set_to_pause === 'undefined' && ( typeof window.paused === 'undefined' || window.paused === '' )

    if ( pauseTimer ) {
      // console.log('pausing')
      praying_pause_button.hide()
      praying_continue_button.show()

      decision_panel.show()

      button_text.html(translate('Praying Paused'))
      clearInterval(window.interval)
      window.paused = true
    } else {
      // console.log('activating')
      praying_pause_button.show()
      praying_continue_button.hide()

      praying_panel.show()
      decision_panel.hide()
      question_panel.hide()

      button_text.html(translate('Keep Praying...'))
      prayer_progress_indicator( window.time )
      window.paused = ''
    }
  }

  function clear_timer() {
    clearInterval(window.interval)
  }

  function update_odometer({ location_count }) {
    window.odometer = {
      location_count,
    }
    odometer_location_count.html(location_count)
 }

  /**
   * FRAMEWORK LOADERS
   */
  function load_location( ) {
    let content = window.report_content = window.current_content
    if ( typeof content === 'undefined' ) {
      window.current_content = window.next_content
      content = window.next_content
      if ( typeof content === 'undefined' ) {
        window.location.href = jsObject.map_url
        return
      }
    }

    button_text.html(translate('Keep Praying...'))
    button_progress.css('width', '0' )

    praying_panel.show()
    decision_panel.hide()
    question_panel.hide()
    celebrate_panel.hide()

    location_name.html( translations.state_of_location.replace('%1$s', content.location.admin_level_name_cap).replace('%2$s', content.location.full_name) )
    div.empty()

    location_map_wrapper.show()
    mapbox_border_map()

    div.append('<div class="container"><hr></div>')
    // LOOP STACK
    jQuery.each(content.list, function(i,block) {
      get_template( block )
    })

    attatch_popper_listeners()

    // FOOTER
    jQuery('.container.block:nth-child(+n+' + window.items + ')').hide()

    prayer_progress_indicator( window.time ) // SETS THE PRAYER PROGRESS WIDGET

    window.load_report_modal()
  }
  function attatch_popper_listeners() {
    const redBodyIcons = document.querySelectorAll('.ion-ios-body.brand')
    const config = {
      trigger: 'focus',
    }
    redBodyIcons.forEach((element) => {
      new bootstrap.Popover(element, { ...config, content: translate("Don't Know Jesus")})
    })
    const orangeBodyIcons = document.querySelectorAll('.ion-ios-body.brand-lighter')
    orangeBodyIcons.forEach((element) => {
      new bootstrap.Popover(element, { ...config, content: translate("Know About Jesus")})
    })
    const greenBodyIcons = document.querySelectorAll('.ion-ios-body.secondary')
    greenBodyIcons.forEach((element) => {
      new bootstrap.Popover(element, { ...config, content: translate("Know Jesus")})
    })
  }
  function prayer_progress_indicator( time_start ) {
    window.time = time_start
    if ( window.interval ) {
      clearInterval(window.interval)
    }
    window.tick = 0
    window.interval = setInterval(function() {
      window.time = window.time + .1

      if (window.time <= window.seconds) {
        window.percent = 1.6666 * ( window.time / window.pace )
        if ( window.percent > 100 ) {
          window.percent = 100
        }
        // console.log( window.time + ' ' + window.percent )
        button_progress.css('width', window.percent+'%' )
      }
      else if (!window.time_finished) {
        window.api_post( 'log', { grid_id: window.current_content.location.grid_id, pace: window.pace, user: window.user_location } )
          .then(function(x) {
            if ( ! x ) {
              window.location.href = jsObject.map_url
              return
            }
            window.current_content = false
            window.current_content = window.next_content
            window.next_content = false
            window.next_content = test_for_redundant_grid( x )
          })
        praying_panel.hide()
        question_panel.show()
        button_progress.css('width', '0' )
        button_text.html(translate('Keep Praying...'))
        /* Set a variable so that we know that the timer has stopped running and that we've logged it once*/
        window.time_finished = true
      }

      if (window.time_finished === true) {
        window.tick = window.tick + 0.1
      }

      if (window.tick > ONE_MINUTE) {
        window.api_post( 'increment_log', { report_id: window.next_content['report_id'] } )
          .then(function(x) {
            console.log('incremented log', x)
          })
        window.tick = 0
      }
    }, 100);
  }

  /**
   * CELEBRATE FUNCTION
   */
  function celebrate(){
    div.empty()
    location_map_wrapper.hide()
    more_prayer_fuel.show()

    let rint = Math.floor(Math.random() * 4 ) + 1

    const celebrateHTML = `
      <p style="padding-top:2em;">
        <div>
          <h2>
            ${translate('Great Job!')}
            <br />
            ${translate('Prayer Added!')}
          </h2>

          <img width="400px" src="${jsObject.image_folder}celebrate${rint}.gif" class="rounded-3 img-fluid celebrate-image" alt="photo" />

        </div>
      </p>
        `
    celebrate_panel.html(celebrateHTML).show()
  }

})
