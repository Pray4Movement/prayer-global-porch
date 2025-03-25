import { getAdditionalUserInfo } from "https://www.gstatic.com/firebasejs/11.4.0/firebase-auth.js";

export function signInSuccessWithAuthResult(userCredential) {
  const AdditionalUserInfo = getAdditionalUserInfo(userCredential);
  const is_new_user = AdditionalUserInfo.isNewUser;
  const is_register =
    document.getElementById("signin-google").getAttribute("data-type") ===
    "register";
  if (is_register && is_new_user) {
    const marketing =
      document.getElementById("extra_register_input_marketing").checked ||
      false;
    completeLogin(userCredential, marketing);
  } else if (is_new_user) {
    // Show modal asking about news signup
    const modal = document.getElementById("modal-news-signup");
    modal.style.display = "flex";

    // Handle modal responses
    document.getElementById("modal-yes").addEventListener("click", () => {
      const marketing = true;
      modal.style.display = "none";
      completeLogin(userCredential, marketing);
    });
    document.getElementById("modal-no").addEventListener("click", () => {
      const marketing = false;
      modal.style.display = "none";
      completeLogin(userCredential, marketing);
    });
  } else {
    completeLogin(userCredential, false);
  }
  // Function to complete the login process
  function completeLogin(userCredential, marketing) {
    userCredential.extraData = {
      marketing: marketing,
    };
    return fetch(`${jsObject.rest_url}/session/login`, {
      method: "POST",
      body: JSON.stringify(userCredential),
    }).then(() => {
      location.href = "/dashboard";
    });
  }
}
