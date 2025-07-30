import React from "react";
import ReactDOM from "react-dom/client";
import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

// Ambil data dari Blade melalui data-* attributes
const root = document.getElementById("toast-root");
const successMessage = root?.dataset.success;
const errorMessage = root?.dataset.error;
const infoMessage = root?.dataset.info;

// Tampilkan notifikasi kalau ada data dari Blade
if (successMessage) toast.success(successMessage);
if (errorMessage) toast.error(errorMessage);
if (infoMessage) toast.info(infoMessage);

// Komponen ToastContainer dengan konfigurasi custom
const ToastApp = () => (
  <ToastContainer
    position="top-right"
    autoClose={3000}
    hideProgressBar={false}
    newestOnTop={true}
    closeOnClick
    rtl={false}
    pauseOnFocusLoss
    draggable
    pauseOnHover
    theme="colored"
  />
);

if (root) {
  ReactDOM.createRoot(root).render(<ToastApp />);
}
