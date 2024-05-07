const translations = window.pg_js.escapeObject(window.pg_active_list.translations);

jQuery(document).ready(function() {
  /**
   * API HANDLERS
   */
  window.api_post = (action, data) => {
    return window.api_fetch( window.pg_global.root + window.pg_active_list.parts.root + '/v1/' + window.pg_active_list.parts.type, {
      method: "POST",
      body: JSON.stringify({action: action, parts: window.pg_active_list.parts, data: data}),
    })
      .catch(function (e) {
        console.log(e)
      })
  }

  window.api_post( 'get_global_list', {} )
    .then(function(data) {

            let html_content_active = ''
            let html_content_completed = ''

            jQuery.each( data, function(i,v){
              const lapNumber = v.lap_number || '1'
              if ( v.status === 'active' ){
                html_content_active += `<tr>
                                <td>${v.start_time}</td>
                                <th class="white">${v.post_title} ${!window.pg_active_list.is_rolling_laps_feature_on || v.single_lap === '1' ? '' : translations.lap.replace('%d', lapNumber)}</th>
                                <td style="text-align:right;">
                                  <a href="/prayer_app/custom/${v.lap_key}">${translations.pray}</a> |
                                  <a href="/prayer_app/custom/${v.lap_key}/map">${translations.map}</a> |
                                  <a href="/prayer_app/custom/${v.lap_key}/tools">${translations.sharing}</a> |
                                  <a href="/prayer_app/custom/${v.lap_key}/display">${translations.display}</a>
                                </td>
                              </tr>`
              } else if ( v.status === 'complete' ) {
                html_content_completed += `<tr>
                                <td>${v.start_time}</td>
                                <th class="white">${v.post_title} ${!window.pg_active_list.is_rolling_laps_feature_on || v.single_lap === '1' ? '' : translations.lap.replace('%d', lapNumber)}</th>
                                <td>${v.stats.participants}</td>
                                <td>${v.stats.time_elapsed_small}</td>
                                <td style="text-align:right;">
                                  <a href="/prayer_app/custom/${v.lap_key}/map">${translations.map}</a>
                                </td>
                              </tr>`
              }

            })

            jQuery('#active_content').html(
                  `<table class="display " style="width:100%;" id="list-table-active" data-order='[[ 0, "desc" ]]'>
                          <thead>
                              <th></th>
                              <th>${translations.name}</th>
                              <th class="desktop">${translations.links}</th>
                            </thead>
                          <tbody>
                             ${html_content_active}
                          </tbody>
                          </table>`
            )
            /* DataTable contains internationalisation for 50 languages with 40 others partially translated */
            /* They can be used by adding language: { url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json' } according to https://datatables.net/plug-ins/i18n/ */
            jQuery('#list-table-active').DataTable({
              /*language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json'
              },*/
              lengthChange: false,
              pageLength: 6,
              pagingType: 'simple',
              responsive: true,
              order: [[0, 'desc']],
              columnDefs: [
                {
                  target: 0,
                  visible: false,
                }
              ],
            });


          jQuery('#complete_content').html(
            `<table class="display " style="width:100%;" id="list-table-completed" data-order='[[ 0, "desc" ]]'>
                                    <thead>
                                        <th></th>
                                        <th>${translations.name}</th>
                                        <th class="desktop">${translations.intercessors}</th>
                                        <th class="desktop">${translations.time_elapsed}</th>
                                        <th class="desktop">${translations.links}</th>
                                      </thead>
                                    <tbody>
                                       ${html_content_completed}
                                    </tbody>
                                    </table>`
          )
          jQuery('#list-table-completed').DataTable({
            lengthChange: false,
            pageLength: 3,
            pagingType: 'simple',
            responsive: true,
            order: [[0, 'desc']],
            columnDefs: [
              {
                target: 0,
                visible: false,
              }
            ],
          });

    }) // end post api
}) // end .ready
