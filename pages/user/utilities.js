import { getAdditionalUserInfo } from "https://www.gstatic.com/firebasejs/11.4.0/firebase-auth.js";

export function signInSuccessWithAuthResult(userCredential) {
  const AdditionalUserInfo = getAdditionalUserInfo(userCredential);
  const is_new_user = AdditionalUserInfo.isNewUser;
  if (is_new_user) {
    // Show modal asking about news signup
    const modal = document.getElementById("modal-news-signup");
    modal.style.display = "flex";

    // Handle modal responses
    document.getElementById("modal-yes").addEventListener("click", () => {
      const marketing = true;
      completeLogin(userCredential, marketing);
      modal.style.display = "none";
    });
    document.getElementById("modal-no").addEventListener("click", () => {
      const marketing = false;
      completeLogin(userCredential, marketing);
      modal.style.display = "none";
    });
  } else {
    completeLogin(userCredential, false);
  }
  // Function to complete the login process
  function completeLogin(userCredential, marketing) {
    userCredential.extraData = {
      marketing: marketing,
    };
    fetch(`${jsObject.rest_url}/session/login`, {
      method: "POST",
      body: JSON.stringify(userCredential),
    }).then(() => {
      location.href = "/dashboard";
    });
  }
}
