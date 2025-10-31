<style>
  body {
    background-color: #f8f9fa;
    padding: 20px;
  }

  .agreement-box {
    height: 200px;
    overflow-y: scroll;
    background-color: #fff;
    border: 1px solid #ddd;
    padding: 15px;
    border-radius: 6px;
  }

  canvas {
    border: 2px solid #ccc;
    border-radius: 4px;
    background-color: #fff;
    width: 300px;
    height: 150px;
    cursor: crosshair;
  }
</style>

<div class="container">
  <h4 class="mb-3">Syarat dan Ketentuan - Serah Terima Kendaraan</h4>

  <div class="agreement-box mb-3">
    <ol>
      <li>Kondisi kendaraan dapat berubah setelah pembersihan. Tim akan menginformasikan jika ada perubahan.</li>
      <li>Status cat kendaraan (repaint/original) tidak dapat dipastikan, risiko ditanggung pemilik.</li>
      <li>Penambahan jarak tempuh (mileage) bisa terjadi, dan bukan tanggung jawab pihak bengkel.</li>
      <li>Kerusakan/malfungsi mesin selama atau setelah pengerjaan bukan tanggung jawab kami.</li>
      <li>Kerusakan akibat pembongkaran aksesori oleh pihak lain bukan tanggung jawab kami.</li>
      <li>Kehilangan barang pribadi bukan tanggung jawab pihak bengkel.</li>
      <li>Tindakan teknis tambahan akan diinformasikan dan perlu persetujuan sebelumnya.</li>
      <li>Kondisi/modifikasi khusus wajib diinformasikan oleh pemilik.</li>
      <li>Penurunan baterai EV akibat kondisi alami bukan tanggung jawab kami.</li>
      <li>Keterlambatan pekerjaan akan diinformasikan kepada pelanggan.</li>
    </ol>
  </div>

  <div class="form-check mb-4">
    <input class="form-check-input" type="checkbox" checked id="agreeCheck">
    <label class="form-check-label fw-semibold" for="agreeCheck">
      Saya telah membaca dan menyetujui Syarat dan Ketentuan di atas.
    </label>
  </div>

  <h5 class="mb-2">Signature</h5>
  <canvas id="signature-pad"></canvas>
  <div class="mt-2">
    <button id="clear-signature" class="btn btn-warning btn-sm me-2">Clear</button>
  </div>

  <div class="mt-4">
    <button id="submitBtn" class="btn btn-success">Submit</button>
  </div>
</div>