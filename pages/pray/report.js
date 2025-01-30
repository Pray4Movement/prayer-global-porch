window.load_report_modal = () => {
  let correction_modal = jQuery("#correction_modal");
  let correction_button = jQuery("#correction_button");
  let correction_close = jQuery("#correction_close");

  let correction_field = jQuery(".correction_field");
  let correction_title = jQuery("#correction_title");
  let correction_select = jQuery("#correction_select");
  let correction_submit = jQuery("#correction_submit_button");
  let correction_spinner = jQuery(".loading-spinner.correction_modal_spinner");
  let correction_error = jQuery("#correction_error");
  let correction_response = jQuery("#correction_response");

  correction_button.on("click", function () {
    console.log(jsObject.location);
    correction_title.html(
      `<strong>${jsObject.location.location.full_name}</strong>`
    );
    correction_select.empty();
    correction_select.append(
      `<option value=""></option><option value="map">Map</option>`
    );
    jQuery.each(jsObject.location.list, function (i, v) {
      correction_select.append(
        `<option value="${v.type}">${v.data.section_label}</option>`
      );
    });
    correction_select.append(`<option value="other">Other</option>`);

    if (typeof correction_modal.modal === "function") {
      correction_modal.modal("show");
    } else if (typeof correction_modal.foundation === "function") {
      correction_modal.foundation("open");
    }
  });
  correction_submit.off("click");
  correction_submit.on("click", function () {
    correction_error.empty();

    let data = {
      grid_id: jsObject.location.location.grid_id,
      current_content: jsObject.location,
      user: window.user_location,
      language: "en",
      section: correction_select.val(),
      section_label: jQuery("#correction_select option:selected").text(),
      response: correction_response.val(),
    };

    if (!data.response) {
      correction_error.html(`You must enter a correction in order to submit.`);
      return;
    }

    correction_spinner.addClass("active");
    correction_submit.prop("disabled", true);

    jQuery
      .ajax({
        type: "POST",
        data: JSON.stringify({
          action: "correction",
          parts: jsObject.parts,
          data: data,
        }),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        url:
          window.pg_global.root +
          jsObject.parts.root +
          "/v1/" +
          jsObject.parts.type,
      })
      .done(function (x) {
        console.log(x);
        correction_modal.modal("hide");
        correction_field.empty().val("");
        correction_submit.prop("disabled", false);
        correction_spinner.removeClass("active");
      });
  });
  correction_close.on("click", function () {
    correction_field.empty().val("");
    correction_submit.prop("disabled", false);
    correction_spinner.removeClass("active");
  });
  /** end correction report */
};
