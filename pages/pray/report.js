window.load_report_modal = () => {
  const correction_modal = document.querySelector("#correction_modal");
  const correction_button = document.querySelector("#correction_button");
  const correction_close = document.querySelector("#correction_close");

  const correction_title = document.querySelector("#correction_title");
  const correction_select = document.querySelector("#correction_select");
  const correction_submit = document.querySelector("#correction_submit_button");
  const correction_spinner = document.querySelector(
    ".loading-spinner.correction_modal_spinner"
  );
  const correction_error = document.querySelector("#correction_error");
  const correction_response = document.querySelector("#correction_response");

  correction_button.addEventListener("click", function () {
    correction_title.innerHTML = `<strong>${jsObject.location.location.full_name}</strong>`;
    correction_select.innerHTML = "";
    correction_select.innerHTML += `<option value=""></option><option value="map">Map</option>`;
    jsObject.location.list.forEach(function (v) {
      correction_select.innerHTML += `<option value="${v.type}">${v.data.section_label}</option>`;
    });
    correction_select.innerHTML += `<option value="other">Other</option>`;

    correction_modal.classList.add("show");
  });
  correction_submit.removeEventListener("click", submitCorrection);
  correction_submit.addEventListener("click", submitCorrection);
  correction_close.addEventListener("click", closeCorrectionModal);

  function submitCorrection() {
    console.log("submitting");
    correction_error.innerHTML = "";

    let data = {
      grid_id: jsObject.location.location.grid_id,
      current_content: jsObject.location,
      user: window.user_location,
      language: "en",
      section: correction_select.value,
      section_label:
        correction_select.options[correction_select.selectedIndex].textContent,
      response: correction_response.value,
    };

    if (!data.response) {
      correction_error.innerHTML = `You must enter a correction in order to submit.`;
      return;
    }

    correction_spinner.classList.add("active");
    correction_submit.setAttribute("disabled", true);

    fetch(
      `${jsObject.rest_route}prayer-global/prayer/correction`,
      {
        method: "POST",
        body: JSON.stringify({
          data: data,
        }),
        headers: {
          "Content-Type": "application/json",
          "X-WP-Nonce": pg_global.nonce,
        },
      }
    ).then((response) => {
      if (!response.ok) {
      }
      closeCorrectionModal();
    });
  }
  function closeCorrectionModal() {
    correction_modal.classList.remove("show");
    correction_response.value = "";
    correction_select.value = "";
    correction_submit.removeAttribute("disabled");
    correction_spinner.classList.remove("active");
  }
  /** end correction report */
};
