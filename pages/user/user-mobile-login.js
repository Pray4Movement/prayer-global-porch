import app from "./firebase-app.js";
import {
  getAuth,
  GoogleAuthProvider,
  signInWithCredential,
} from "https://www.gstatic.com/firebasejs/11.4.0/firebase-auth.js";
import { signInSuccessWithAuthResult } from "./utilities.js";

jQuery(document).ready(function () {
  /* We can access all of the top level constants and functions declared in login-shortcodes.php for the login shortcode */
  const googleButtonSelector = "#signin-google";

  const isMedian = navigator.userAgent.indexOf("gonative") >= 0;

  if (isMedian) {
    initialiseMobileButton(
      googleButtonSelector,
      "google",
      providerLoginCallback
    );
  }

  function initialiseMobileButton(selector, socialProvider, callback) {
    console.log(`initialising ${socialProvider} mobile button`);

    if (!["google", "facebook"].includes(socialProvider)) {
      console.log("social Provider not recognized");
      return;
    }
    const buttonElement = document.querySelector(selector);

    const buttonClone = buttonElement.cloneNode(true);
    const parentNode = buttonElement.parentNode;

    buttonElement.remove();

    buttonClone.onclick = () =>
      window.median.socialLogin[socialProvider].login({ callback: callback });

    parentNode.appendChild(buttonClone);
  }

  function providerLoginCallback(response) {
    console.log(`${response.type} Login Callback response`, response);

    let token;

    const provider = response.type;
    if (provider === "google") {
      token = response.idToken;
    }
    if (provider === "facebook") {
      token = response.accessToken;
    }

    if (token) {
      console.log("we have an idToken", token);

      let credential;

      if (provider === "google") {
        credential = GoogleAuthProvider.credential(token);
      }
      if (provider === "facebook") {
        credential = FacebookAuthProvider.credential(token);
      }

      console.log("attempting signIn with credential", credential);

      console.log("app", app);
      const auth = getAuth(app);
      console.log("auth", auth);
      // Sign in with credential from the Google user.
      signInWithCredential(auth, credential)
        .then((userCredential) => {
          /* Then we will send *that* token to WP to exchange for a token :O) */

          console.log("signInWithCredential response", userCredential);

          return signInSuccessWithAuthResult(userCredential);
        })
        .catch((error) => {
          // Handle Errors here.
          const errorCode = error.code;
          const errorMessage = error.message;
          // The email of the user's account used.
          const email = error.email;

          console.log(
            "signInWithCredential errors",
            errorCode,
            errorMessage,
            email
          );
        });
    } else {
      console.log("User cancelled login or did not fully authorize.");
    }
  }
});
