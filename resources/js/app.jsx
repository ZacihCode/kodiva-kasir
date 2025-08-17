import React from "react";
import ReactDOM from "react-dom/client";
import { ToastApp, showToast } from "./ToastApp.jsx";

const toastRoot = document.getElementById("toast-root");

if (toastRoot) {
  // Baca data-* SEBELUM React render
  const { success, error, info } = toastRoot.dataset || {};

  // Render container Toast
  ReactDOM.createRoot(toastRoot).render(<ToastApp />);

  // Tampilkan toast dari session (full reload case)
  if (success) showToast('success', success);
  if (error)   showToast('error', error);
  if (info)    showToast('info', info);
}

// Expose global
window.showToast = showToast;
