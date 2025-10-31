<script>
  (function($) {
    'use strict';
    // ====== Config ======
    const items = [{
        key: 'paint',
        label: 'Paint'
      },
      {
        key: 'windshield',
        label: 'Windshield'
      },
      {
        key: 'windows',
        label: 'Windows'
      },
      {
        key: 'mirrors',
        label: 'Mirrors'
      },
      {
        key: 'rear_window',
        label: 'Rear Window'
      },
      {
        key: 'tires',
        label: 'Tires'
      },
      {
        key: 'wheels',
        label: 'Wheels'
      }
    ];

    const photos = {
      front: null,
      rear: null,
      left: null,
      right: null
    };

    let activeZone = null;

    // ====== Signature Pad ======
    function initSignature() {
      const canvas = document.getElementById('signature-pad');
      const pad = new SignaturePad(canvas);
      $('#clear-signature').on('click', () => pad.clear());
      return pad;
    }

    // ====== Build Inspection UI ======
    function buildInspectionUI() {
      const $list = $('#inspection-list').empty();

      items.forEach(({
        key,
        label
      }) => {
        $list.append(`
        <div class="mb-3 border-bottom pb-2">
          <div class="d-flex justify-content-between align-items-center">
            <div><strong>${label}</strong></div>
            <div class="small-muted">G = Good | F = Fair | P = Poor</div>
          </div>

          <div class="mt-2 btn-group" role="group">
            ${['G','F','P'].map(v => `
              <input type="radio" class="btn-check" name="${key}" id="${key}-${v}" value="${v}" autocomplete="off">
              <label class="btn btn-outline-primary btn-sm" for="${key}-${v}">${v}</label>
            `).join('')}
          </div>

          <div class="mt-2">
            <textarea class="form-control form-control-sm notes" placeholder="Notes (optional)"></textarea>
          </div>
        </div>
      `);
      });
    }

    document.querySelectorAll('.upload-zone').forEach(zone => {
      zone.addEventListener('click', () => {
        const part = zone.dataset.part;
        const fileInput = document.getElementById('fileInput');

        // listen for file selection once
        fileInput.onchange = async (e) => {
          const file = e.target.files[0];
          if (!file) return;

          const reader = new FileReader();
          reader.onload = (event) => {
            const base64 = event.target.result;
            zone.dataset.photoBase64 = base64;

            // give user some visual feedback
            zone.style.backgroundImage = `url(${base64})`;
            zone.style.backgroundSize = 'cover';
            zone.style.backgroundPosition = 'center';
            zone.textContent = part.charAt(0).toUpperCase() + part.slice(1);
          };
          reader.readAsDataURL(file);
        };

        fileInput.click(); // trigger file picker
      });
    });


    // ====== Helpers ======
    async function gatherFormData(signaturePad) {
      // helper to turn file -> base64
      async function fileToBase64(file) {
        if (!file) return null;
        return new Promise((resolve, reject) => {
          const reader = new FileReader();
          reader.onload = () => resolve(reader.result);
          reader.onerror = reject;
          reader.readAsDataURL(file);
        });
      }

      const inspections = [];

      // process inspection items (Paint, Glass, Tires, etc.)
      for (const {
          key,
          label
        }
        of items) {
        const selected = $(`input[name="${key}"]:checked`);
        const notes = selected.closest('.mb-3').find('textarea').val() || '';
        const file = selected.closest('.mb-3').find('input[type="file"]')[0]?.files[0] || null;
        const base64Photo = file ? await fileToBase64(file) : null;

        inspections.push({
          key,
          label,
          value: selected.val() || '-',
          notes,
          photo: base64Photo
        });
      }

      // handle car overview photos (front, rear, left, right)
      const photoParts = ['front', 'rear', 'left', 'right'];
      const photos = {};
      for (const part of photoParts) {
        const zone = document.querySelector(`#zone-${part}`);
        photos[part] = zone?.dataset.photoBase64 || null;
      }

      console.log(photos);
      // its contain null


      // full object to return
      return {
        details: {
          customer: ($('#firstName').val() + ' ' + $('#lastName').val()).trim() || 'N/A',
          license: $('#license').val() || 'N/A',
          mileage: $('#mileage').val() || 'N/A',
          model: $('#model').val() || 'N/A',
          inspector: 'Hilmi',
          location: $('#location').val() || 'N/A',
          invoice: 'WS12345',
          inspection_id: 'WS12344'
        },
        inspection: inspections,
        photos,
        signature: signaturePad.toDataURL(),
        agreedAt: new Date().toLocaleString()
      };
    }

    async function getBase64(file) {
      return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onload = () => resolve(reader.result);
        reader.onerror = reject;
        reader.readAsDataURL(file);
      });
    }

    // ====== PDF Generation ======
    async function generatePDF(formData) {

      const {
        jsPDF
      } = window.jspdf;
      const pdf = new jsPDF({
        unit: 'pt',
        format: 'a4'
      });
      const pageWidth = pdf.internal.pageSize.getWidth();
      const pageHeight = pdf.internal.pageSize.getHeight();
      const margin = 40;
      let y = 40;

      // ====== Title with border & centered ======
      const title = 'INSPECTION REPORT';
      pdf.setFontSize(18);
      pdf.setFont('helvetica', 'bold');

      const textWidth = pdf.getTextWidth(title);
      const pad = 8;
      const boxWidth = textWidth + pad * 2;
      const boxHeight = 30;
      const boxX = (pageWidth - boxWidth) / 2;
      const boxY = y - 5;

      pdf.setLineWidth(1);
      pdf.rect(boxX, boxY, boxWidth, boxHeight); // border box
      pdf.text(title, boxX + pad, boxY + boxHeight - 10);

      y = boxY + boxHeight + 20;

      // ====== Subtitle or company ======
      pdf.setFontSize(12);
      pdf.setFont('helvetica', 'normal');
      pdf.text('WRAP STATION', margin, y);
      y += 40;

      pdf.setLineWidth(0.8);
      pdf.line(margin, y, pageWidth - margin, y);
      y += 20;

      // ====== Details section ======
      pdf.setFontSize(10);
      pdf.text(`Customer: ${formData.details.customer}`, margin, y);
      pdf.text(`Inspection #: ${formData.details.inspection_id}`, pageWidth / 2, y);
      y += 16;
      pdf.text(`Invoice: ${formData.details.invoice}`, margin, y);
      pdf.text(`Date: ${new Date().toLocaleDateString()}`, pageWidth / 2, y);
      y += 16;
      pdf.text(`Inspector: ${formData.details.inspector}`, margin, y);
      pdf.text(`Location: ${formData.details.location}`, pageWidth / 2, y);
      y += 20;

      pdf.line(margin, y, pageWidth - margin, y);
      y += 16;

      // ====== Table header ======
      pdf.setFontSize(10);
      pdf.text('Item', margin, y);
      pdf.text('License Plate', pageWidth / 2, y);
      pdf.text('Mileage (KM)', pageWidth - margin - 100, y);
      y += 16;
      pdf.line(margin, y, pageWidth - margin, y);
      y += 16;

      // ====== Table row example ======
      pdf.text(`${formData.details.model}`, margin, y);
      pdf.text(`${formData.details.license}`, pageWidth / 2, y);
      pdf.text(`${formData.details.mileage}`, pageWidth - margin - 100, y);
      y += 24;
      pdf.line(margin, y, pageWidth - margin, y);
      y += 14;

      // ====== Item Inspections section ======
      pdf.setFontSize(11);
      pdf.text('Item Inspections', margin, y);
      y += 14;
      pdf.line(margin, y, pageWidth - margin, y);
      y += 14;

      // ====== Table header for inspection ======
      pdf.setFontSize(10);
      pdf.text('Article', margin, y);
      pdf.text('Condition', pageWidth - margin - 275, y);
      pdf.text('Notes', pageWidth - margin - 100, y);
      y += 14;
      pdf.line(margin, y, pageWidth - margin, y);
      y += 14;

      // ====== G F P header aligned with rectangles ======
      const markX = pageWidth / 2 - 40;
      ['G', 'F', 'P'].forEach((mv, i) => {
        const x = markX + i * 40;
        pdf.text(mv, x + 2, y); // center text roughly in each column
      });
      y += 14;

      pdf.setFontSize(10);

      // ====== Inspection items ======
      formData.inspection.forEach((it, idx) => {
        if (y > 720) {
          pdf.addPage();
          y = margin;
        }

        pdf.text(`${idx + 1}. ${it.label}`, margin, y);

        // draw boxes aligned under G F P text
        ['G', 'F', 'P'].forEach((mv, i) => {
          const x = markX + i * 40;
          pdf.rect(x, y - 8, 8, 8);
          if (mv === it.value) {
            pdf.setFillColor(0, 0, 0);
            pdf.rect(x + 1, y - 7, 6, 6, 'F');
            pdf.setFillColor(255, 255, 255);
          }
        });

        pdf.text(it.notes || '', pageWidth - margin - 140, y);
        y += 20;
      });

      // ====== Remarks ======
      if (y + 100 > 820) {
        pdf.addPage();
        y = margin;
      }
      pdf.line(margin, y, pageWidth - margin, y);
      y += 20;
      pdf.setFontSize(9);
      pdf.text('Remarks:', margin, y);
      y += 14;
      pdf.text('G = GOOD | F = FAIR | P = POOR', margin, y);

      // ====== Footer on the last page ======
      pdf.setFontSize(9);
      pdf.text(
        'Detailed photograph presented on later pages',
        pageWidth / 2,
        pageHeight - 40, {
          align: 'center'
        }
      );

      // ====== Overview Photos Section ======
      pdf.setFontSize(12);
      pdf.text('Car Overview Photos', pageWidth / 2, y, {
        align: 'center'
      });
      y += 20;

      // array of overview photos
      const overviewPhotos = [{
          label: 'Front View',
          data: formData.photos.front
        },
        {
          label: 'Rear View',
          data: formData.photos.rear
        },
        {
          label: 'Left View',
          data: formData.photos.left
        },
        {
          label: 'Right View',
          data: formData.photos.right
        },
      ];

      const imgWidth = (pageWidth - margin * 2 - 20) / 2; // two per row
      const imgHeight = 140;
      let col = 0;

      for (const photo of overviewPhotos) {
        if (!photo.data) continue; // skip missing photos

        if (y + imgHeight + 40 > pageHeight - margin) {
          pdf.addPage();
          y = margin;
        }

        const x = margin + col * (imgWidth + 20);
        pdf.rect(x - 2, y - 2, imgWidth + 4, imgHeight + 4); // border
        try {
          pdf.addImage(photo.data, 'JPEG', x, y, imgWidth, imgHeight);
        } catch (err) {
          console.error('Invalid image data for', photo.label, err);
        }

        pdf.setFontSize(10);
        pdf.text(photo.label, x + imgWidth / 2, y + imgHeight + 14, {
          align: 'center'
        });

        // move column
        col++;
        if (col === 2) {
          col = 0;
          y += imgHeight + 40; // move to next row
        }
      }
      if (col !== 0) y += imgHeight + 40; // finish last row if incomplete

      // ====== Inspection Photos Section ======
      pdf.setFontSize(11);
      pdf.text('Inspection Photos', pageWidth / 2, y, {
        align: 'center'
      });
      y += 20;

      formData.inspection.forEach((it) => {
        if (!it.photo) return; // skip if no image
        if (y + 120 > pageHeight - margin) {
          pdf.addPage();
          y = margin;
        }

        pdf.setFontSize(10);
        pdf.text(String(it.label || ''), margin, y);
        y += 6;
        console.log(it.photo);
        console.log(it.label);

        // draw a border box for visual alignment
        const imgWidth = 150;
        const imgHeight = 100;
        const x = (pageWidth - imgWidth) / 2;

        pdf.rect(x - 2, y - 2, imgWidth + 4, imgHeight + 4);
        pdf.addImage(it.photo, 'JPEG', x, y, imgWidth, imgHeight);

        y += imgHeight + 20;
      });

      // Agreement page
      pdf.addPage();
      pdf.setFontSize(12);
      pdf.text('Agreement & Signature', margin, 40);
      pdf.setFontSize(10);
      const terms = [
        '1) Kondisi kendaraan dapat berubah setelah pembersihan.',
        '2) Status cat (repaint/original) merupakan tanggung jawab pemilik.',
        '3) Penambahan jarak tempuh (mileage) bisa terjadi.',
        '4) Kerusakan selama/atau setelah pengerjaan bukan tanggung jawab kami.',
        '5) Kerusakan akibat pembongkaran aksesori oleh pihak lain bukan tanggung jawab kami.',
        '6) Kehilangan barang pribadi bukan tanggung jawab pihak bengkel.',
        '7) Tindakan teknis tambahan akan diinformasikan dan perlu persetujuan sebelumnya.',
        '8) Kondisi/modifikasi khusus wajib diinformasikan oleh pemilik.',
        '9) Penurunan baterai EV akibat kondisi alami bukan tanggung jawab kami.',
        '10) Keterlambatan pekerjaan akan diinformasikan kepada pelanggan.',
      ];
      let ty = 78;
      terms.forEach(t => {
        pdf.text(t, margin, ty);
        ty += 14;
      });

      if (formData.signature) {
        const sigW = 200,
          sigH = 80;
        pdf.addImage(formData.signature, 'PNG', margin, 420, sigW, sigH);
        pdf.text('Customer Signature', margin, 420 + sigH + 16);
        pdf.text(`Signed at: ${formData.agreedAt}`, margin, 420 + sigH + 34);
      }

      return pdf;
    }

    // ====== Submit Handler ======
    $(document).on('click', '#submitBtn', async function() {

      const signaturePad = window.signaturePadInstance;
      if (!$('#agreeCheck').is(':checked')) {
        Swal.fire({
          icon: 'warning',
          title: 'Please agree',
          text: 'You must agree to the terms before submitting.'
        });
        return;
      }
      // if (signaturePad.isEmpty()) {
      //   Swal.fire({
      //     icon: 'warning',
      //     title: 'Missing signature',
      //     text: 'Please sign before submitting.'
      //   });
      //   return;
      // }

      const formData = await gatherFormData(signaturePad);

      // causing race condition
      // Swal.fire({
      //   title: 'Generating PDF...',
      //   html: 'Please wait while the report is created.',
      //   didOpen: () => Swal.showLoading(),
      //   allowOutsideClick: false,
      //   showConfirmButton: false
      // });

      try {
        const pdf = await generatePDF(formData);
        const blob = pdf.output('blob');
        const url = URL.createObjectURL(blob);

        Swal.fire({
          icon: 'success',
          title: 'Report generated',
          html: 'The inspection PDF is ready. Click Open to view.',
          showCancelButton: true,
          confirmButtonText: 'Open',
          cancelButtonText: 'Close',
          didOpen: () => Swal.hideLoading()
        });

        Swal.getConfirmButton().addEventListener('click', () => window.open(url, '_blank'));
        Swal.getCancelButton().addEventListener('click', () => setTimeout(() => URL.revokeObjectURL(url), 30000));

      } catch (err) {
        console.error(err);
        Swal.hideLoading();
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Failed to generate PDF: ' + err.message
        });
      }
    });

    // ====== Photo Uploads ======
    function initPhotoUploads() {
      $('.upload-zone').on('click', function() {
        activeZone = $(this).data('part');
        $('#photoInput').click();
      });

      $('#photoInput').on('change', function() {

        const file = this.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = e => {
          photos[activeZone] = e.target.result;
          $(`#zone-${activeZone}`).html(`<img src="${e.target.result}">`);
        };
        reader.readAsDataURL(file);
        $(this).val('');
      });
    }

    // ====== Init ======
    $(function() {
      buildInspectionUI();
      initPhotoUploads();
      window.signaturePadInstance = initSignature();
    });

  })(jQuery);

  $(function() {
    $('input[type="radio"]').change(function() {
      const container = $(this).closest('.mb-3');
      container.find('.extra-fields').removeClass('d-none').hide().slideDown(200);
    });

    let activeZone = null;

    // $('.upload-zone').on('click', function() {
    //   activeZone = $(this);
    //   $('#fileInput').click();
    // });

    $('#fileInput').on('change', function(e) {
      const file = e.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(evt) {
          activeZone.html('<img src="' + evt.target.result + '" alt="Uploaded">');
        };
        reader.readAsDataURL(file);
      }
    });

    $('#saveBtn').on('click', function() {
      const parts = {};
      $('.upload-zone').each(function() {
        const img = $(this).find('img').attr('src');
        parts[$(this).data('part')] = img || null;
      });
      console.log(parts);
      alert('Images captured in console log.');
    });
  });
</script>


</html>