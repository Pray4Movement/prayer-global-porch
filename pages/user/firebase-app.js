import { initializeApp } from "https://www.gstatic.com/firebasejs/11.4.0/firebase-app.js";

const firebaseConfig = {
  apiKey: "AIzaSyCJEy7tJL_YSQPYH4H92_n0kQBhmYcj1l8",
  authDomain: "auth.prayer.global",
  projectId: "prayer-global-dbbaa",
  storageBucket: "prayer-global-dbbaa.firebasestorage.app",
  messagingSenderId: "764994067122",
  appId: "1:764994067122:web:a8d34e86451c0d966947ab",
  measurementId: "G-HTYNN26M7X",
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);

export default app;
