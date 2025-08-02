import React from "react";
import ReactDOM from "react-dom/client";
import { ToastApp, showToast } from "./ToastApp.jsx";

// Render container ke HTML (cek bawah untuk blade-nya)
const toastRoot = document.getElementById("toast-root");
if (toastRoot) {
    ReactDOM.createRoot(toastRoot).render(<ToastApp />);
}

// Expose global supaya bisa dipakai di mana saja (bahkan inline JS di Blade)
window.showToast = showToast;
