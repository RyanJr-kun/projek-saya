import * as bootstrap from "bootstrap";
import "./http"; // Asumsi ini adalah file http client Anda seperti axios
import PerfectScrollbar from "perfect-scrollbar";
import "perfect-scrollbar/css/perfect-scrollbar.css";
import Scrollbar from "smooth-scrollbar";
import { Chart, registerables } from "chart.js";

// Daftarkan semua komponen Chart.js
Chart.register(...registerables);

// Jadikan variabel menjadi global agar bisa diakses dari file lain (seperti Blade)
window.bootstrap = bootstrap; // <-- INI KUNCINYA
window.PerfectScrollbar = PerfectScrollbar;
window.Scrollbar = Scrollbar;
window.Chart = Chart;
