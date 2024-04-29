jQuery(document).ready(function() {
  /**
   * API HANDLERS
   */
  window.api_post = (action, data) => {
    return jQuery.ajax({
      type: "POST",
      data: JSON.stringify({action: action, parts: jsObject.parts, data: data}),
      contentType: "application/json; charset=utf-8",
      dataType: "json",
      url: jsObject.root + jsObject.parts.root + '/v1/' + jsObject.parts.type,
      beforeSend: function (xhr) {
        xhr.setRequestHeader('X-WP-Nonce', jsObject.nonce)
      }
    })
      .fail(function (e) {
        console.log(e)
      })
  }

  console.log(jsObject)

  let content = jQuery('#content')

  window.api_post( 'get_global_list', {} )
    .done(function(data) {
      let html_content = ''
      jQuery.each( data, function(i,v){
        end_time = v.stats.end_time_formatted
        if( ! v.end_time ) {
          end_time = 'running'
        }
        html_content += `<tr>
                      <td>${v.lap_number}</td>
                      <th class="white">Lap #${v.lap_number}</th>
                      <td>${ end_time }</td>
                      <td>${v.stats.participants}</td>
                      <td>${v.stats.time_elapsed_small}</td>
                      <td>
                         <a href="/prayer_app/global/${v.lap_key}/map">View Map</a>
                      </td>
                    </tr>`
      })

      jQuery('#content').html(
        `<table class="display responsive" style="width:100%;" id="list-table" >
                <thead>
                    <th></th>
                    <th>Lap Number</th>
                    <th class="desktop">Completed</th>
                    <th class="desktop">Intercessors</th>
                    <th class="desktop">Time Elapsed</th>
                    <th class="desktop">Map</th>
                  </thead>
                <tbody>
                   ${html_content}
                </tbody>
                </table>`
      )

      jQuery('#list-table').DataTable({
        lengthChange: false,
        pageLength: 30,
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
    })

  jQuery('#totals_block').html(`Totals across all Laps: Total Intercessors: ${jsObject.global_race.participants}
                        | Total Time Elapsed: ${jsObject.global_race.time_elapsed_small}`)


}) // end .ready
