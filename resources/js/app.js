import "./http";
import "./argon-dashboard.js";
import "./core/popper.min.js";

import "perfect-scrollbar/css/perfect-scrollbar.css";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css";
import 'filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css';

import * as bootstrap from "bootstrap";
import * as FilePond from "filepond";
import PerfectScrollbar from "perfect-scrollbar";
import Scrollbar from "smooth-scrollbar";

import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import FilePondPluginFileValidateSize from "filepond-plugin-file-validate-size";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginFilePoster from 'filepond-plugin-file-poster';
import FilePondPluginImageExifOrientation from "filepond-plugin-image-exif-orientation";
import FilePondPluginImageResize from "filepond-plugin-image-resize";
import FilePondPluginImageCrop from "filepond-plugin-image-crop";

FilePond.registerPlugin(
    FilePondPluginImagePreview,
    FilePondPluginFileValidateSize,
    FilePondPluginFileValidateType,
    FilePondPluginImageExifOrientation,
    FilePondPluginImageResize,
    FilePondPluginImageCrop,
    FilePondPluginFilePoster
);

// === JADIKAN VARIABEL GLOBAL ===
window.bootstrap = bootstrap;
window.FilePond = FilePond;
window.PerfectScrollbar = PerfectScrollbar;
window.Scrollbar = Scrollbar;
