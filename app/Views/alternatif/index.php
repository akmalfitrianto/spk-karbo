<?= $this->extend('template/content'); ?>
<?= $this->section('content'); ?>

<div class="section">
  <div class="row">
    <div class="col-md-12">

      <h1 class="text-gray-900">Data Karbohidrat</h1>

      <div class="row mt-4">
        <div class="col-md-12">
          <div class="card shadow">
            <div class="card-header">
              <button class="btn btn-primary btn-tambah" data-toggle="modal" data-target="#modalBoxTambah" data-backdrop="static" data-keyboard="false">
                <i class="fas fa fa-plus"></i> Tambah</button>
              <button class="btn btn-danger btn-hapus"><i class="fas fa fa-trash-alt"></i> Hapus</button>
              <button class="btn btn-success btn-ubah"><i class="fas fa fa-edit"></i> Ubah</button>
            </div>
            <div class="card-body">
              <table class="table table-bordered table-striped table-alternatif" id="dataTable">
                <thead>
                  <th><input type="checkbox" id="checkboxes"></th>
                  <th>No.</th>
                  <th>Kode</th>
                  <th>Nama Karbohidrat</th>
                  <th>Indeks Glikemik</th>
                  <th>Serat</th>
                  <th>Karbohidrat</th>
                  <th>Harga</th>
                  <th>Ketersediaan</th>
                </thead>
                <tbody id="list-alternatif">
                    <!-- diisi lewat AJAX -->
                </tbody>
              </table>
            </div>
          </div>

        </div>
      </div>

      <!-- Modal Tambah -->
      <div class="modal fade" id="modalBoxTambah" tabindex="-1" role="dialog" aria-labelledby="modalBoxTambahTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header badge-primary">
              <h5 class="modal-title">Tambah Data Karbohidrat</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="formTambah" class="formSubmit" action="<?= base_url('alternatif/create'); ?>" method="POST">
              <div class="modal-body">
                <?= csrf_field(); ?>
                <div class="form-group">
                  <label for="kode">Kode</label>
                  <input type="text" name="kode" id="kode" class="form-control">
                  <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                  <label for="nama_karbohidrat">Nama Karbohidrat</label>
                  <input type="text" name="nama_karbohidrat" id="nama_karbohidrat" class="form-control">
                  <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                  <label for="indeks_glikemik">Indeks Glikemik</label>
                  <input type="text" name="indeks_glikemik" id="indeks_glikemik" class="form-control">
                  <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                  <label for="serat">Serat</label>
                  <input type="text" name="serat" id="serat" class="form-control">
                  <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                  <label for="karbohidrat">Karbohidrat</label>
                  <input type="text" name="karbohidrat" id="karbohidrat" class="form-control">
                  <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                  <label for="harga">Harga</label>
                  <input type="text" name="harga" id="harga" class="form-control">
                  <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                  <label for="ketersediaan">Ketersediaan</label>
                  <select name="ketersediaan" id="ketersediaan" class="form-control">
                    <option value="">-- Pilih --</option>
                    <option value="1">Sangat Sulit</option>
                    <option value="2">Sulit</option>
                    <option value="3">Cukup</option>
                    <option value="4">Mudah</option>
                    <option value="5">Sangat Mudah</option>
                  </select>
                  <div class="invalid-feedback"></div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-simpan"><i class="fas fa fa-save"></i> Simpan</button>
              </div>
            </form>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('custom-js') ?>
<script>
  $(document).ready(function () {
    const formTambah = $('#formTambah');
    formTambah.submit(function (e) {
      e.preventDefault();
      requestSaveData(formTambah, '#modalBoxTambah');
      removeClasses('#formTambah');
    });

    loadDataAlternatif();

    const formUbah = $('#formUbah');
    formUbah.submit(function (e) {
      e.preventDefault();
      requestSaveData(formUbah, '#modalBoxUbah');
      removeClasses('#formUbah');
    });

    $('.btn-hapus').on('click', function () {
      requestDeleteData('/alternatif/delete');
    });

    $('.btn-ubah').on('click', function () {
      requestGetDataById('/alternatif/getDataById');
    });

    $(document).on('click', '.btn-detail', function () {
      const id = $(this).data('id');
      requestGetDataById('/alternatif/getDataById', '', id);
    });

    function loadDataAlternatif() {
  $.ajax({
    url: '/alternatif/list',
    method: 'GET',
    dataType: 'json',
    success: function(data) {
      let html = '';
      $.each(data, function(index, row) {
        html += `
          <tr>
            <td><input type="checkbox" name="id[]" class="checkbox" value="${row.id_alternatif}"></td>
            <td>${index + 1}</td>
            <td>${row.kode}</td>
            <td>${row.nama_karbohidrat}</td>
            <td>${row.indeks_glikemik}</td>
            <td>${row.serat}</td>
            <td>${row.karbohidrat}</td>
            <td>${Number(row.harga).toLocaleString('id-ID')}</td>
            <td>${getKetersediaan(row.ketersediaan)}</td>
          </tr>
        `;
      });

      $('.table-alternatif tbody').html(html);
    }
  });
}

function getKetersediaan(nilai) {
  const map = {
    1: 'Sangat Sulit',
    2: 'Sulit',
    3: 'Cukup',
    4: 'Mudah',
    5: 'Sangat Mudah'
  };
  return map[nilai] || '-';
}

  });
</script>
<?= $this->endSection(); ?>