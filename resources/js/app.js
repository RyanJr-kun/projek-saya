import "./http";
import "perfect-scrollbar/css/perfect-scrollbar.css";

import * as bootstrap from "bootstrap";
import PerfectScrollbar from "perfect-scrollbar";
import Scrollbar from "smooth-scrollbar";
import "bootstrap";

import "./argon-dashboard.js";
window.bootstrap = bootstrap;
window.PerfectScrollbar = PerfectScrollbar;
window.Scrollbar = Scrollbar;

// === INISIALISASI KOMPONEN SETELAH DOM SIAP ===
document.addEventListener("DOMContentLoaded", function () {
    const tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    window.sidebarType = argonDashboard.sidebarType;
    window.navbarFixed = argonDashboard.navbarFixed;
    window.navbarMinimize = argonDashboard.navbarMinimize;
});

document.addEventListener("DOMContentLoaded", function () {
    const sidenavScrollbar = document.querySelector("#sidenav-scrollbar");
    if (sidenavScrollbar && navigator.platform.indexOf("Win") > -1) {
        Scrollbar.init(sidenavScrollbar, { damping: "0.5" });
    }
});
