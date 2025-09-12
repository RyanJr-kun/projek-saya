/**
 * Inisialisasi FilePond dengan konfigurasi yang dapat digunakan kembali.
 * @param {string} elementSelector - Selector CSS untuk elemen input file.
 * @param {string} submitBtnSelector - Selector CSS untuk tombol submit form.
 * @param {string} cancelBtnSelector - Selector CSS untuk tombol batal.
 * @param {string} formId - ID dari form.
 * @param {object} customOptions - Opsi tambahan khusus untuk instance FilePond (misalnya, 'files' untuk edit).
 */
function setupProductFilePond(
    elementSelector,
    submitBtnSelector,
    cancelBtnSelector,
    formId,
    customOptions = {}
) {
    // 1. Daftarkan semua plugin yang dibutuhkan
    FilePond.registerPlugin(
        FilePondPluginImagePreview,
        FilePondPluginFileValidateSize,
        FilePondPluginImageCrop,
        FilePondPluginFileValidateType,
        FilePondPluginImageTransform
    );

    const inputElement = document.querySelector(elementSelector);
    const submitBtn = document.querySelector(submitBtnSelector);
    const cancelBtn = document.querySelector(cancelBtnSelector);

    if (!inputElement || !submitBtn || !cancelBtn) {
        console.error(
            "Satu atau lebih elemen (input, submit, cancel) tidak ditemukan."
        );
        return;
    }

    // 2. Ambil CSRF token dari meta tag
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    // 3. Konfigurasi default untuk semua instance FilePond produk
    const defaultConfig = {
        labelIdle: `Seret & Lepas gambar atau <span class="filepond--label-action">Cari</span>`,
        allowImagePreview: true,
        imagePreviewHeight: 300,
        allowFileSizeValidation: true,
        maxFileSize: "2MB",
        allowImageCrop: true,
        imageCropAspectRatio: "1:1",
        labelMaxFileSizeExceeded: "Ukuran file terlalu besar",
        labelMaxFileSize: "Ukuran file maksimum adalah 2MB",
        acceptedFileTypes: [
            "image/png",
            "image/jpeg",
            "image/webp",
            "image/svg+xml",
        ],
        labelFileTypeNotAllowed: "Jenis file tidak valid.",
        server: {
            process: {
                url: "/dashboard/produk/upload",
                headers: { "X-CSRF-TOKEN": csrfToken },
            },
            revert: {
                url: "/dashboard/produk/revert",
                method: "DELETE",
                headers: { "X-CSRF-TOKEN": csrfToken },
            },
        },
    };

    // 4. Gabungkan konfigurasi default dengan opsi kustom
    const finalConfig = { ...defaultConfig, ...customOptions };
    const pond = FilePond.create(inputElement, finalConfig);

    // 5. Logika untuk menonaktifkan tombol submit saat upload
    const originalSubmitText = submitBtn.innerHTML;
    pond.on("addfile", () => {
        submitBtn.disabled = true;
        submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Mengunggah...`;
    });
    pond.on("processfile", () => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalSubmitText;
    });
    pond.on("removefile", () => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalSubmitText;
    });

    // 6. Logika untuk tombol "Batalkan"
    cancelBtn.addEventListener("click", function (e) {
        e.preventDefault();
        const newFile = pond
            .getFiles()
            .find(
                (file) =>
                    file.origin === FilePond.FileOrigin.INPUT &&
                    file.status === FilePond.FileStatus.PROCESSING_COMPLETE
            );

        if (newFile && newFile.serverId) {
            // Jika ada file baru yang sudah diunggah, hapus dulu dari server
            fetch("/dashboard/produk/revert", {
                method: "DELETE",
                headers: { "X-CSRF-TOKEN": csrfToken },
                body: newFile.serverId,
            }).finally(() => {
                window.location.href = this.href;
            });
        } else {
            // Jika tidak ada file baru, langsung navigasi
            window.location.href = this.href;
        }
    });
}
