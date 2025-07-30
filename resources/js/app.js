import "./http";
import "bootstrap";
import PerfectScrollbar from "perfect-scrollbar";
import "perfect-scrollbar/css/perfect-scrollbar.css";
import Scrollbar from "smooth-scrollbar";
import { Chart, registerables } from "chart.js";
Chart.register(...registerables);

window.PerfectScrollbar = PerfectScrollbar; // Jika perlu akses global
window.Scrollbar = Scrollbar; 
window.Chart = Chart;
