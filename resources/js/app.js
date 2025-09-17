import "./http";
import "perfect-scrollbar/css/perfect-scrollbar.css";

import * as bootstrap from "bootstrap";
import PerfectScrollbar from "perfect-scrollbar";
import Scrollbar from "smooth-scrollbar";

// Impor fungsionalitas inti dari Argon Dashboard
import * as argonDashboard from "./argon-dashboard.js";

// === JADIKAN VARIABEL GLOBAL (OPSIONAL, TAPI DIPERLUKAN OLEH TEMPLATE) ===
window.bootstrap = bootstrap;
window.PerfectScrollbar = PerfectScrollbar;
window.Scrollbar = Scrollbar;

// === INISIALISASI KOMPONEN SETELAH DOM SIAP ===
document.addEventListener("DOMContentLoaded", function () {
    // Inisialisasi semua tooltip yang ada di halaman
    const tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // --- Ekstrak fungsi dari argon-dashboard.js ke window agar bisa diakses dari HTML ---
    // Ini diperlukan untuk onclick="darkMode(this)", onclick="sidebarType(this)", dll.
    window.darkMode = argonDashboard.darkMode;
    window.sidebarColor = argonDashboard.sidebarColor;
    window.sidebarType = argonDashboard.sidebarType;
    window.navbarFixed = argonDashboard.navbarFixed;
    window.navbarMinimize = argonDashboard.navbarMinimize;
    window.focused = argonDashboard.focused; // Tambahkan baris ini
    window.defocused = argonDashboard.defocused; // Tambahkan baris ini
    window.toggleSidenav = argonDashboard.toggleSidenav; // Jika Anda membutuhkannya secara global
});

// === INISIALISASI SCROLLBAR UNTUK SIDEBAR ===
// Dijalankan setelah DOM siap untuk memastikan elemen #sidenav-scrollbar ada.
document.addEventListener("DOMContentLoaded", function () {
    const sidenavScrollbar = document.querySelector("#sidenav-scrollbar");
    // Hanya inisialisasi jika elemennya ada dan platformnya Windows (sesuai logika asli)
    if (sidenavScrollbar && navigator.platform.indexOf("Win") > -1) {
        Scrollbar.init(sidenavScrollbar, { damping: "0.5" });
    }
});
