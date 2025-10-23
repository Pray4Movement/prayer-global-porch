import {
  getAuth,
  GoogleAuthProvider,
  signInWithPopup,
} from "https://www.gstatic.com/firebasejs/11.4.0/firebase-auth.js";
import app from "./firebase-app.js";
import { signInSuccessWithAuthResult } from "./utilities.js";

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

document.getElementById("register-password").addEventListener("click", () => {
  document.getElementById("register-email-password-form").style.display =
    "block";
  document.getElementById("login-buttons").classList.add("hidden");
});
document
  .getElementById("register-email-password-form-back")
  .addEventListener("click", () => {
    document.getElementById("register-email-password-form").style.display =
      "none";
    document.getElementById("login-buttons").classList.remove("hidden");
  });

const strength = {
  0: "Worst",
  1: "Bad",
  2: "Weak",
  3: "Good",
  4: "Strong",
};
const minStrength = 1;
let isSubmitting = false;

const form = document.getElementById("loginform");
const password_field = document.getElementById("password");
const password2 = document.getElementById("password2");
const passwordStrengthError = document.getElementById(
  "password-error-too-weak"
);
const passwordsDontMatchError = document.getElementById("password-error-2");
const meter = document.getElementById("password-strength-meter");

function getPasswordStrength(p) {
  if (typeof zxcvbn !== "function") {
    return p.length >= 8 ? 3 : 0;
  }
  return zxcvbn(p).score;
}

password_field.addEventListener("input", function () {
  const password = password_field.value;
  const password_strength = getPasswordStrength(password);
  // Update the password strength meter
  meter.value = password_strength;

  if (password_strength >= minStrength) {
    passwordStrengthError.style.display = "none";
  }
});

form.addEventListener("submit", function (event) {
  const password = password_field.value;
  const password_strength = getPasswordStrength(password);

  if (password_strength < minStrength) {
    event.preventDefault();
    passwordStrengthError.style.display = "block";
    return;
  }

  if (password_field.value !== password2.value) {
    event.preventDefault();
    passwordsDontMatchError.style.display = "block";
    return;
  }

  if (isSubmitting) {
    event.preventDefault();
    return;
  }
  event.preventDefault();

  const submitButtenElement = document.querySelector("#register-submit");
  submitButtenElement.querySelector(".loading-spinner").classList.add("active");
  submitButtenElement.classList.add("disabled");
  submitButtenElement.setAttribute("disabled", "");

  isSubmitting = true;

  const email = event.target.email?.value;
  if (email === "") {
    event.preventDefault();
    return;
  }
  const pass = event.target.password?.value;
  if (pass === "") {
    event.preventDefault();
    return;
  }

  const name = event.target.name?.value || email;

  // Get the Turnstile token
  const turnstileResponse = document.querySelector(
    '[name="cf-turnstile-response"]'
  ).value;
  if (!turnstileResponse) {
    document.getElementById("login-error").innerText =
      jsObject.translations.turnstile_error;
    document.getElementById("login-error").style.display = "block";
    submitButtenElement
      .querySelector(".loading-spinner")
      .classList.remove("active");
    submitButtenElement.classList.remove("disabled");
    submitButtenElement.removeAttribute("disabled");
    isSubmitting = false;
    return;
  }

  // Send registration data to our endpoint
  fetch(`${window.pg_global.root}pg/register/password`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      email: email,
      password: pass,
      name: name,
      extra_data: {
        marketing:
          document.getElementById("extra_register_input_marketing").checked ||
          false,
        turnstile_token: turnstileResponse,
      },
    }),
  })
    .then((response) => {
      return response.ok ? response.json() : Promise.reject(response);
    })
    .then(() => {
      location.href = "/dashboard";
    })
    .catch((response) => {
      response.json().then((error) => {
        document.getElementById("login-error").innerText = error.message;
        document.getElementById("login-error").style.display = "block";
        submitButtenElement
          .querySelector(".loading-spinner")
          .classList.remove("active");
        submitButtenElement.classList.remove("disabled");
        submitButtenElement.removeAttribute("disabled");
        isSubmitting = false;
      });
    });
});
