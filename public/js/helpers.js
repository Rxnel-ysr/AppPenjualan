function setupDropArea({
    dropAreaId,
    inputId,
    labelId
}) {
    const dropArea = document.getElementById(dropAreaId);
    const input = document.getElementById(inputId);
    const label = document.getElementById(labelId);
    const preview = document.createElement("img");

    Object.assign(preview.style, {
        maxWidth: "85%",
        marginTop: "1rem"
    });
    preview.classList.add("rounded");
    dropArea.appendChild(preview);

    const updatePreview = (file) => {
        if (file?.type?.startsWith("image/")) {
            const reader = new FileReader();
            reader.onload = (e) => {
                preview.src = e.target.result;
                label.textContent = file.name;
            };
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
            label.textContent = file?.name || "Invalid file type.";
        }
    };

    input.addEventListener("change", () => updatePreview(input.files[0]));

    dropArea.addEventListener("click", () => input.click());

    dropArea.addEventListener("dragover", (e) => {
        e.preventDefault();
        dropArea.classList.add("border-primary");
    });

    dropArea.addEventListener("dragleave", () => {
        dropArea.classList.remove("border-primary");
    });

    dropArea.addEventListener("drop", (e) => {
        e.preventDefault();
        dropArea.classList.remove("border-primary");
        const file = e.dataTransfer.files[0];
        input.files = e.dataTransfer.files;
        updatePreview(file);
    });
}

// function setupMultiImageDrop({
//     dropAreaId,
//     inputId,
//     labelId,
//     previewContainerId,
//     carouselContainerId
// }) {
//     const dropArea = document.getElementById(dropAreaId);
//     const input = document.getElementById(inputId);
//     const label = document.getElementById(labelId);
//     const previewEl = document.getElementById(previewContainerId);
//     const carouselEl = document.getElementById(carouselContainerId);
//     const images = [];

//     // 💀 STYLE ONE PREVIEW
//     const createThumb = (src, idx) => {
//         const wrapper = document.createElement("div");
//         wrapper.className = "thumb-wrapper position-relative d-inline-block me-2 mb-2";

//         const img = document.createElement("img");
//         img.src = src;
//         img.className = "img-thumbnail";
//         img.style.maxWidth = "100px";

//         const removeBtn = document.createElement("button");
//         removeBtn.innerHTML = "&times;";
//         removeBtn.className = "btn btn-sm btn-danger position-absolute top-0 end-0";
//         removeBtn.onclick = () => {
//             images.splice(idx, 1);
//             renderPreview();
//             renderCarousel();
//         };

//         wrapper.appendChild(img);
//         wrapper.appendChild(removeBtn);
//         return wrapper;
//     };

//     const renderPreview = () => {
//         previewEl.innerHTML = '';
//         images.forEach((img, idx) => {
//             previewEl.appendChild(createThumb(img.url, idx));
//         });
//     };

//     const renderCarousel = () => {
//         if (!carouselEl) return;
//         if (images.length === 0) {
//             carouselEl.innerHTML = '';
//             return;
//         }

//         const indicators = images.map((_, idx) => `
//       <button type="button" data-bs-target="#carousel" data-bs-slide-to="${idx}"
//         class="${idx === 0 ? 'active' : ''}"
//         aria-current="${idx === 0 ? 'true' : 'false'}"
//         aria-label="Slide ${idx + 1}"></button>
//     `).join('');

//         const inner = images.map((img, idx) => `
//       <div class="carousel-item ${idx === 0 ? 'active' : ''}">
//         <img src="${img.url}" class="d-block w-100" alt="Slide ${idx + 1}">
//       </div>
//     `).join('');

//         carouselEl.innerHTML = `
//       <div id="carousel" class="carousel slide" data-bs-ride="carousel">
//         <div class="carousel-indicators">${indicators}</div>
//         <div class="carousel-inner">${inner}</div>
//         <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
//           <span class="carousel-control-prev-icon"></span>
//         </button>
//         <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
//           <span class="carousel-control-next-icon"></span>
//         </button>
//       </div>
//     `;
//     };

//     const handleFile = (fileList) => {
//         Array.from(fileList).forEach(file => {
//             if (file.type.startsWith("image/")) {
//                 const reader = new FileReader();
//                 reader.onload = (e) => {
//                     images.push({ url: e.target.result });
//                     renderPreview();
//                     renderCarousel();
//                     if (label) label.textContent = file.name;
//                 };
//                 reader.readAsDataURL(file);
//             } else {
//                 if (label) label.textContent = file.name + " (Invalid type)";
//             }
//         });
//     };

//     input.addEventListener("change", () => handleFile(input.files));
//     dropArea.addEventListener("click", () => input.click());
//     dropArea.addEventListener("dragover", e => {
//         e.preventDefault();
//         dropArea.classList.add("border-primary");
//     });
//     dropArea.addEventListener("dragleave", () => {
//         dropArea.classList.remove("border-primary");
//     });
//     dropArea.addEventListener("drop", e => {
//         e.preventDefault();
//         dropArea.classList.remove("border-primary");
//         const files = e.dataTransfer.files;
//         input.files = files;
//         handleFile(files);
//     });
// }

// function setupMultiImageDrop({
//     dropAreaId,
//     inputId,
//     labelId,
//     previewContainerId,
//     carouselContainerId
// }) {
//     const $ = id => document.getElementById(id);
//     const dropArea = $(dropAreaId);
//     const input = $(inputId);
//     const label = $(labelId);
//     const previewEl = $(previewContainerId);
//     const carouselEl = $(carouselContainerId);
//     const images = [];

//     const render = {
//         preview: () => {
//             previewEl.innerHTML = images.map((img, i) => `
//                 <div class="thumb-wrapper position-relative d-inline-block me-2 mb-2">
//                     <img src="${img.url}" class="img-thumbnail" style="max-width:100px;">
//                     <button class="btn btn-sm btn-danger position-absolute top-0 end-0" data-rm="${i}">&times;</button>
//                 </div>`).join('');
//         },
//         carousel: () => {
//             if (!carouselEl) return;
//             if (images.length === 0) return carouselEl.innerHTML = '';
//             const indicators = images.map((_, i) => `
//                 <button type="button" data-bs-target="#carousel" data-bs-slide-to="${i}"
//                     class="${i === 0 ? 'active' : ''}"
//                     aria-current="${i === 0}" aria-label="Slide ${i + 1}"></button>`).join('');
//             const inner = images.map((img, i) => `
//                 <div class="carousel-item ${i === 0 ? 'active' : ''}">
//                     <img src="${img.url}" class="d-block w-100" alt="Slide ${i + 1}">
//                 </div>`).join('');
//             carouselEl.innerHTML = `
//                 <div id="carousel" class="carousel slide" data-bs-ride="carousel">
//                     <div class="carousel-indicators">${indicators}</div>
//                     <div class="carousel-inner">${inner}</div>
//                     <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
//                         <span class="carousel-control-prev-icon"></span>
//                     </button>
//                     <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
//                         <span class="carousel-control-next-icon"></span>
//                     </button>
//                 </div>`;
//         }
//     };

//     const handleFile = files => {
//         [...files].forEach(file => {
//             if (!file.type.startsWith("image/")) {
//                 if (label) label.textContent = `${file.name} (Invalid type)`;
//                 return;
//             }
//             const reader = new FileReader();
//             reader.onload = e => {
//                 images.push({ url: e.target.result });
//                 if (label) label.textContent = file.name;
//                 render.preview();
//                 render.carousel();
//             };
//             reader.readAsDataURL(file);
//         });
//     };

//     input.onchange = () => handleFile(input.files);
//     dropArea.onclick = () => input.click();
//     ['dragover', 'dragleave', 'drop'].forEach(evt =>
//         dropArea.addEventListener(evt, e => {
//             e.preventDefault();
//             dropArea.classList.toggle('border-primary', evt === 'dragover');
//             if (evt === 'drop') {
//                 input.files = e.dataTransfer.files;
//                 handleFile(e.dataTransfer.files);
//             }
//         })
//     );

//     previewEl.addEventListener('click', e => {
//         const btn = e.target.closest('button[data-rm]');
//         if (btn) {
//             const idx = +btn.dataset.rm;
//             images.splice(idx, 1);
//             render.preview();
//             render.carousel();
//         }
//     });
// }

function debounce(fn, delay = 300) {
    let timeout;
    return function (...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => fn.apply(this, args), delay);
    };
}


function setupMultiImageDrop({
    dropAreaId,
    inputId,
    labelId,
    previewContainerId,
    carouselContainerId
}) {
    const $ = id => document.getElementById(id);

    const dropArea = $(dropAreaId);
    const input = $(inputId);
    const label = $(labelId);
    const previewEl = $(previewContainerId);
    const carouselEl = carouselContainerId ? $(carouselContainerId) : null;
    const images = [];

    const createThumb = (src, idx) => {
        const wrapper = document.createElement("div");
        wrapper.className = "thumb-wrapper position-relative d-inline-block me-2 mb-2";
        wrapper.innerHTML = `
            <img src="${src}" class="img-thumbnail" style="max-width:100px">
            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0">&times;</button>
        `;
        wrapper.querySelector("button").onclick = () => {
            images.splice(idx, 1);
            label.textContent = ((images.length > 1) ? `${images.length} items` : `${images.length} item`) + ' selected'
            renderAll();
        };
        return wrapper;
    };

    const renderPreview = () => {
        previewEl.innerHTML = "";
        const frag = document.createDocumentFragment();
        images.forEach((img, idx) => frag.appendChild(createThumb(img.url, idx)));
        previewEl.appendChild(frag);
    };

    const renderCarousel = () => {
        if (!carouselEl || images.length === 0) {
            if (carouselEl) carouselEl.innerHTML = "";
            return;
        }

        const indicators = images.map((_, i) =>
            `<button type="button" data-bs-target="#carousel" data-bs-slide-to="${i}"
              class="${i === 0 ? 'active' : ''}" aria-current="${i === 0}"
              aria-label="Slide ${i + 1}"></button>`).join('');

        const slides = images.map((img, i) =>
            `<div class="carousel-item ${i === 0 ? 'active' : ''}">
              <img src="${img.url}" class="d-block w-100" alt="Slide ${i + 1}">
            </div>`).join('');

        carouselEl.innerHTML = `
          <div id="carousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">${indicators}</div>
            <div class="carousel-inner">${slides}</div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
              <span class="carousel-control-next-icon"></span>
            </button>
          </div>`;
    };

    const renderAll = () => {
        debounce(() => {
            renderPreview();
            renderCarousel();
        }, 200)()
    };

    const handleFile = fileList => {
        Array.from(fileList).forEach((file, idx) => {
            if (!file.type.startsWith("image/")) {
                if (label) label.textContent = `${file.name} (Invalid type)`;
                return;
            }

            const url = URL.createObjectURL(file);
            images.push({ url });

            setTimeout(() => URL.revokeObjectURL(url), 30000); // 30s delay

            if (idx === 0 && label && fileList.length === 1) {
                label.textContent = file.name;
            } else if (label) {
                label.textContent = `${fileList.length} items selected`;
            }
        });

        renderAll();
    };


    input.addEventListener("change", () => handleFile(input.files));
    // dropArea.addEventListener("click", () => input.click());
    label.addEventListener("click", () => input.click());

    dropArea.addEventListener("dragover", e => {
        e.preventDefault();
        dropArea.classList.add("border-primary");
    });

    dropArea.addEventListener("dragleave", () =>
        dropArea.classList.remove("border-primary")
    );

    dropArea.addEventListener("drop", e => {
        e.preventDefault();
        dropArea.classList.remove("border-primary");
        handleFile(e.dataTransfer.files);
    });
}


const contentLoad = (fn) => {
    document.addEventListener('DOMContentLoaded', fn())
}
