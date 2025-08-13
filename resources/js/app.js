import Uppy from '@uppy/core';
import Dashboard from '@uppy/dashboard';
import ImageEditor from '@uppy/image-editor';
import XHRUpload from '@uppy/xhr-upload';
import './argon-dashboard.js';
import './core/popper.min.js';

import 'perfect-scrollbar/css/perfect-scrollbar.css';
import '@uppy/core/dist/style.min.css';
import '@uppy/dashboard/dist/style.min.css';
import '@uppy/image-editor/dist/style.min.css';

import * as bootstrap from 'bootstrap';
import './http';
import PerfectScrollbar from 'perfect-scrollbar';
import Scrollbar from 'smooth-scrollbar';

// === JADIKAN VARIABEL GLOBAL ===
window.bootstrap = bootstrap;
window.PerfectScrollbar = PerfectScrollbar;
window.Scrollbar = Scrollbar;

window.Uppy = Uppy;
window.Dashboard = Dashboard;
window.ImageEditor = ImageEditor;
window.XHRUpload = XHRUpload;
