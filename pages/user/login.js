let redirectTo = "";
window.addEventListener("load", function () {
  if (pg_global.is_logged_in) {
    const url = new URL(location.href);
    redirectTo = url.searchParams.has("redirect_to") ? decodeURIComponent(url.searchParams.get("redirect_to")) : "/dashboard";

    location.href = redirectTo;
  }
});

import {
  getAuth,
  GoogleAuthProvider,
  signInWithPopup,
  signInWithEmailAndPassword,
  sendPasswordResetEmail,
} from "https://www.gstatic.com/firebasejs/11.4.0/firebase-auth.js";

import app from "./firebase-app.js";
import { signInSuccessWithAuthResult } from "./utilities.js";

let rest_url = jsObject.rest_url;

//handle sign in with Google
document.getElementById("signin-google").addEventListener("click", () => {
  const auth = getAuth(app);
  const provider = new GoogleAuthProvider();
  signInWithPopup(auth, provider)
    .then((userCredential) => {
      signInSuccessWithAuthResult(userCredential);
    })
    .catch((error) => {
      document.getElementById("login-error").innerText = error.message;
      document.getElementById("login-error").style.display = "block";
    });
});

if (document.getElementById("section-login")) {
  document.getElementById("register-password").addEventListener("click", () => {
    document.getElementById("login-email-password-form").style.display =
      "block";
    document.getElementById("login-buttons").classList.add("hidden");
  });
  document
    .getElementById("login-email-password-form-back")
    .addEventListener("click", () => {
      document.getElementById("login-email-password-form").style.display =
        "none";
      document.getElementById("login-buttons").classList.remove("hidden");
    });

  let isSubmitting = false;
  const form = document.getElementById("loginform");
  const email_field = document.getElementById("email");
  const password_field = document.getElementById("password");
  const emailError = document.getElementById("email-error");
  const passwordError = document.getElementById("password-error");

  form.addEventListener("submit", function (event) {
    if (email_field.value === "") {
      event.preventDefault();
      emailError.style.display = "block";
      return;
    }
    if (password_field.value === "") {
      event.preventDefault();
      passwordError.style.display = "block";
      return;
    }

    if (isSubmitting) {
      event.preventDefault();
      return;
    }
    event.preventDefault();

    const submitButtenElement = document.querySelector("#login-submit");
    submitButtenElement
      .querySelector(".loading-spinner")
      .classList.add("active");
    submitButtenElement.classList.add("disabled");
    submitButtenElement.setAttribute("disabled", "");

    isSubmitting = true;

    function handleAuthError(error) {
      const errorCode = error.code;
      const errorMessage = error.message;

      // Toggle the spinner and button
      document
        .querySelector("#login-submit .loading-spinner")
        .classList.remove("active");
      document.querySelector("#login-submit").classList.remove("disabled");
      document.querySelector("#login-submit").removeAttribute("disabled");
      isSubmitting = false;

      // Show specific error messages based on the error code
      if (
        errorCode === "auth/wrong-password" ||
        errorCode === "invalid_credentials"
      ) {
        // Use a generic error message for both WordPress and Firebase invalid credential errors
        document.getElementById("login-error").innerText =
          jsObject.translations.invalid_credentials;
        document.getElementById("login-error").style.display = "block";
      } else if (errorCode === "auth/user-not-found") {
        emailError.style.display = "block";
        emailError.innerText = jsObject.translations.email_not_found;
      } else {
        document.getElementById("login-error").innerText =
          errorMessage || jsObject.translations.auth_failed;
        document.getElementById("login-error").style.display = "block";
      }
    }

    // First try WordPress authentication
    fetch(`${window.pg_global.root}pg/login/wp-login`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        email: email_field.value,
        password: password_field.value,
      }),
    })
      .then((response) => {
        if (!response.ok) {
          return Promise.reject(response);
        }
        // WordPress authentication successful
        console.log("WordPress authentication successful");
        return response.json();
      })
      .then(({ data }) => data.email)
      .catch((error) => {
        // If WordPress auth fails, try Firebase (legacy users)
        console.log("WordPress authentication failed, trying Firebase...");

        let wordpressErrorMessage = "";

        // Try to parse the error response if it exists
        if (error.json) {
          error
            .json()
            .then((errorData) => {
              console.log("WordPress auth error:", errorData);
              wordpressErrorMessage = errorData.message;
              // If the error is from WordPress auth, we'll continue to Firebase fallback
              // but store the error in case Firebase also fails
            })
            .catch(() => {
              // JSON parsing error, continue to Firebase silently
            });
        }

        const auth = getAuth(app);
        return signInWithEmailAndPassword(
          auth,
          email_field.value,
          password_field.value
        )
          .then((userCredential) => {
            // Signed in with Firebase
            console.log("Firebase authentication successful (legacy account)");
            return fetch(`${rest_url}/session/login`, {
              method: "POST",
              body: JSON.stringify(userCredential),
            })
              .then(() => {
                return userCredential.user.email;
              })
              .catch((fetchError) => {
                // Failed to make the login request after Firebase auth
                console.error("Firebase token validation error:", fetchError);
                handleAuthError({
                  code: "fetch_error",
                  message: "Error validating credentials",
                });
              });
          })
          .catch((firebaseError) => {
            // Both WordPress and Firebase auth failed
            console.error("All authentication methods failed:", firebaseError);

            // If WordPress returned an "invalid_credentials" error, prioritize that message
            // instead of showing the Firebase-specific error
            if (
              wordpressErrorMessage &&
              wordpressErrorMessage.includes("Invalid email or password")
            ) {
              handleAuthError({
                code: "invalid_credentials",
                message: wordpressErrorMessage || "Invalid email or password",
              });
            } else {
              handleAuthError(firebaseError);
            }
          });
      })
      .then((data) => {
        location.href = redirectTo;
      });
  });

  // Helper function to handle authentication errors
  // Password reset handlers
  const forgotPasswordLink = document.getElementById("forgot-password-link");
  const resetPasswordContainer = document.getElementById("reset-password-form");
  const resetPasswordForm = document.getElementById(
    "reset-password-form-element"
  );
  const resetPasswordBackButton = document.getElementById(
    "reset-password-back"
  );
  const resetPasswordSubmit = document.getElementById("reset-password-submit");
  const resetEmail = document.getElementById("reset-email");
  const resetEmailError = document.getElementById("reset-email-error");
  const resetSuccessMessage = document.getElementById("reset-success-message");

  if (forgotPasswordLink) {
    forgotPasswordLink.addEventListener("click", (e) => {
      e.preventDefault();
      document.getElementById("login-email-password-form").style.display =
        "none";
      document.getElementById("login-buttons").style.display = "none";
      resetPasswordContainer.style.display = "block";
    });
  }

  if (resetPasswordBackButton) {
    resetPasswordBackButton.addEventListener("click", () => {
      resetPasswordContainer.style.display = "none";
      document.getElementById("login-email-password-form").style.display =
        "block";
      resetSuccessMessage.style.display = "none";
      resetEmailError.style.display = "none";
    });
  }

  if (resetPasswordForm) {
    resetPasswordForm.addEventListener("submit", function (event) {
      event.preventDefault();

      if (resetEmail.value === "") {
        resetEmailError.style.display = "block";
        resetEmailError.innerText = jsObject.translations.email_required;
        return;
      }

      resetPasswordSubmit
        .querySelector(".loading-spinner")
        .classList.add("active");
      resetPasswordSubmit.classList.add("disabled");
      resetPasswordSubmit.setAttribute("disabled", "");
      resetEmailError.style.display = "none";

      // Try WordPress password reset first
      fetch(`${window.pg_global.root}pg/login/reset-password`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          email: resetEmail.value,
        }),
      })
        .then((response) => {
          if (!response.ok) {
            return Promise.reject(response);
          }
          return response.json();
        })
        .then((data) => {
          // WordPress reset successful
          console.log("WordPress password reset email sent");
          resetSuccessMessage.style.display = "block";
          resetPasswordSubmit
            .querySelector(".loading-spinner")
            .classList.remove("active");
          resetPasswordSubmit.classList.remove("disabled");
          resetPasswordSubmit.removeAttribute("disabled");
        })
        .catch((error) => {
          // If WordPress reset fails, try Firebase (legacy users)
          console.log("WordPress reset failed, trying Firebase...");

          const auth = getAuth(app);
          sendPasswordResetEmail(auth, resetEmail.value)
            .then(() => {
              // Firebase reset email sent
              console.log("Firebase password reset email sent");
              resetSuccessMessage.style.display = "block";
            })
            .catch((firebaseError) => {
              // Both reset methods failed
              console.error(
                "All password reset methods failed:",
                firebaseError
              );

              resetEmailError.innerText =
                jsObject.translations.no_account_found;
              resetEmailError.style.display = "block";
            })
            .finally(() => {
              resetPasswordSubmit
                .querySelector(".loading-spinner")
                .classList.remove("active");
              resetPasswordSubmit.classList.remove("disabled");
              resetPasswordSubmit.removeAttribute("disabled");
            });
        });
    });
  }
}
