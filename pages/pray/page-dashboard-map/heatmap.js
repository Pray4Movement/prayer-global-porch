  window.get_page = (action, data = null) => {
    action = action.replaceAll('_', '-');
    if (action === 'get-user-locations'){
      //return empty promise base on jquery ajax
      return new Promise((resolve, reject) => {
        resolve([]);
      });
    }
    return jQuery
      .ajax({
        type: "GET",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        url: window.jsObject?.public_endpoint_url + '/' + action,
        beforeSend: function (xhr) {
          xhr.setRequestHeader('X-WP-Nonce', window.pg_global.nonce);
        },

      })
      .fail(function (e) {
        console.error(e);
        jQuery("#error").html(e);
      });
  };
  window.api_post_global = (type, action, data = []) => {
    return window.api_fetch(
      `${window.pg_global.root}pg-api/v1/${type}/${action}`,
      {
        method: "POST",
        body: JSON.stringify(data),
      }
    );
  };
  