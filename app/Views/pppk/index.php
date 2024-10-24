<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.122.0">
    <title>Pricing example · Bootstrap v5.3</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Favicons -->
<meta name="theme-color" content="#712cf9">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        width: 100%;
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }

      .btn-bd-primary {
        --bd-violet-bg: #712cf9;
        --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

        --bs-btn-font-weight: 600;
        --bs-btn-color: var(--bs-white);
        --bs-btn-bg: var(--bd-violet-bg);
        --bs-btn-border-color: var(--bd-violet-bg);
        --bs-btn-hover-color: var(--bs-white);
        --bs-btn-hover-bg: #6528e0;
        --bs-btn-hover-border-color: #6528e0;
        --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
        --bs-btn-active-color: var(--bs-btn-hover-color);
        --bs-btn-active-bg: #5a23c8;
        --bs-btn-active-border-color: #5a23c8;
      }

      .bd-mode-toggle {
        z-index: 1500;
      }

      .bd-mode-toggle .dropdown-menu .active .bi {
        display: block !important;
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="pricing.css" rel="stylesheet">
  </head>
  <body>
    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
      <symbol id="check2" viewBox="0 0 16 16">
        <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
      </symbol>
      <symbol id="circle-half" viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"/>
      </symbol>
      <symbol id="moon-stars-fill" viewBox="0 0 16 16">
        <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z"/>
        <path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z"/>
      </symbol>
      <symbol id="sun-fill" viewBox="0 0 16 16">
        <path d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"/>
      </symbol>
    </svg>

    <div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
      <button class="btn btn-bd-primary py-2 dropdown-toggle d-flex align-items-center"
              id="bd-theme"
              type="button"
              aria-expanded="false"
              data-bs-toggle="dropdown"
              aria-label="Toggle theme (auto)">
        <svg class="bi my-1 theme-icon-active" width="1em" height="1em"><use href="#circle-half"></use></svg>
        <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
      </button>
      <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
        <li>
          <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
            <svg class="bi me-2 opacity-50" width="1em" height="1em"><use href="#sun-fill"></use></svg>
            Light
            <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
          </button>
        </li>
        <li>
          <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
            <svg class="bi me-2 opacity-50" width="1em" height="1em"><use href="#moon-stars-fill"></use></svg>
            Dark
            <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
          </button>
        </li>
        <li>
          <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto" aria-pressed="true">
            <svg class="bi me-2 opacity-50" width="1em" height="1em"><use href="#circle-half"></use></svg>
            Auto
            <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
          </button>
        </li>
      </ul>
    </div>

    
<svg xmlns="http://www.w3.org/2000/svg" class="d-none">
  <symbol id="check" viewBox="0 0 16 16">
    <title>Check</title>
    <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
  </symbol>
</svg>

<div class="container py-3">
  <header>
    <div class="d-flex flex-column flex-md-row align-items-center pb-3 mb-4 border-bottom">
      <a href="/" class="d-flex align-items-center link-body-emphasis text-decoration-none">
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="32" class="me-2" viewBox="0 0 118 94" role="img"><title>Bootstrap</title><path fill-rule="evenodd" clip-rule="evenodd" d="M24.509 0c-6.733 0-11.715 5.893-11.492 12.284.214 6.14-.064 14.092-2.066 20.577C8.943 39.365 5.547 43.485 0 44.014v5.972c5.547.529 8.943 4.649 10.951 11.153 2.002 6.485 2.28 14.437 2.066 20.577C12.794 88.106 17.776 94 24.51 94H93.5c6.733 0 11.714-5.893 11.491-12.284-.214-6.14.064-14.092 2.066-20.577 2.009-6.504 5.396-10.624 10.943-11.153v-5.972c-5.547-.529-8.934-4.649-10.943-11.153-2.002-6.484-2.28-14.437-2.066-20.577C105.214 5.894 100.233 0 93.5 0H24.508zM80 57.863C80 66.663 73.436 72 62.543 72H44a2 2 0 01-2-2V24a2 2 0 012-2h18.437c9.083 0 15.044 4.92 15.044 12.474 0 5.302-4.01 10.049-9.119 10.88v.277C75.317 46.394 80 51.21 80 57.863zM60.521 28.34H49.948v14.934h8.905c6.884 0 10.68-2.772 10.68-7.727 0-4.643-3.264-7.207-9.012-7.207zM49.948 49.2v16.458H60.91c7.167 0 10.964-2.876 10.964-8.281 0-5.406-3.903-8.178-11.425-8.178H49.948z" fill="currentColor"></path></svg>
        <span class="fs-4">Pricing example</span>
      </a>

      <nav class="d-inline-flex mt-2 mt-md-0 ms-md-auto">
        <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="#">Features</a>
        <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="<?= site_url('pppk/sotk')?>">SOTK</a>
        <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="#">Support</a>
        <a class="py-2 link-body-emphasis text-decoration-none" href="#">Pricing</a>
      </nav>
    </div>
  </header>

  <main>
    <div class="row text-center">
      <div class="col">
        <div class="card mb-4 rounded-3 shadow-sm">
          <div class="card-header py-3">
            <h4 class="my-0 fw-normal">Cek Formasi</h4>
          </div>
          <div class="card-body">
          <form>
    <div class="row gx-3 gy-2 align-items-center">
        <div class="col-sm-3">
            <label class="visually-hidden" for="specificSizeInputName">Jabatan</label>
            <select name="jabatan" class="form-select" id="jabatan">
                <option value="ff80808132b9d98c0132cd178bc8056e">Guru Ahli Pertama</option>
                <option value="6f6c8805d5284da79b9e12b0fae5f882">Operator Layanan Operasional</option>
                <option value="F426F8A44B17A8BDE050640AF2083B83">Penata Layanan Operasional</option>
                <option value="8ae482884fde72e4014fdf1f1abe3f3c">Pengadministrasi Perkantoran</option>
                <option value="f6180f848a8149d294b20145347d95d4">PENGELOLA UMUM OPERASIONAL</option>
                <option value="482AE39CE9A94E20E050640A2A02304F">PENGELOLA LAYANAN OPERASIONAL</option>
            </select>
        </div><!--end col-->
        <div class="col-sm-3">
            <label class="visually-hidden" for="penempatan">Penempatan</label>
            <input type="text" class="form-control" id="subjabatan" name="subjabatan" placeholder="subjabatan">
        </div><!--end col-->
        <div class="col-sm-3">
            <label class="visually-hidden" for="penempatan">Penempatan</label>
            <input type="text" class="form-control" id="penempatan" name="penempatan" placeholder="Penempatan">
        </div><!--end col-->
        <div class="col-auto">
            <button type="button" class="btn btn-primary" onclick="search()">Cek</button>
        </div><!--end col-->
    </div>
</form>
          </div>
        </div>

        <div class="card mb-4 rounded-3 shadow-sm">
          <div class="card-body">
          <form action="">
            <div class="row mb-3">
                <div class="col-lg-3">
                    <label for="nameInput" class="form-label">id</label>
                </div>
                <div class="col-lg-9">
                    <input type="text" class="form-control" id="id">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-lg-3">
                    <label for="websiteUrl" class="form-label">pendidikan</label>
                </div>
                <div class="col-lg-9">
                    <textarea name="pendidikan" id="pendidikan" class="form-control"></textarea>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-lg-3">
                    <label for="dateInput" class="form-label">usul_sotk_detail_id</label>
                </div>
                <div class="col-lg-9">
                    <input type="text" class="form-control" name="usul_sotk_detail_id" id="usul_sotk_detail_id">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-lg-3">
                    <label for="jenis_jabatan_id" class="form-label">jenis_jabatan_id</label>
                </div>
                <div class="col-lg-9">
                    <input type="text" class="form-control" id="jenis_jabatan_id" name="jenis_jabatan_id">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-lg-3">
                    <label for="jabatan_fungsional_id" class="form-label">jabatan_fungsional_id</label>
                </div>
                <div class="col-lg-9">
                    <input type="text" class="form-control" id="jabatan_fungsional_id" name="jabatan_fungsional_id">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-lg-3">
                    <label for="jenis_jabatan_umum_id" class="form-label">jenis_jabatan_umum_id</label>
                </div>
                <div class="col-lg-9">
                    <input type="text" class="form-control" id="jenis_jabatan_umum_id" name="jenis_jabatan_umum_id">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-lg-3">
                    <label for="angka_pppk_teknis" class="form-label">angka_pppk_teknis</label>
                </div>
                <div class="col-lg-9">
                    <input type="number" class="form-control" id="angka_pppk_teknis" name="angka_pppk_teknis">
                </div>
            </div>
            <div class="text-end">
                <span id="infochange"></span>
                <button type="button" class="btn btn-primary" onclick="changekuota()">Change Kuota</button>
            </div>
        </form>
          </div>
        </div>

        <div class="card mb-4 rounded-3 shadow-sm">
          <div class="card-body">
          <form action="">
            <div class="row mb-3">
                <div class="col-lg-3">
                    <label for="nameInput" class="form-label">id</label>
                </div>
                <div class="col-lg-9">
                    <input type="text" class="form-control" id="idhapus">
                </div>
            </div>
            <div class="text-end">
                <button type="button" class="btn btn-primary" onclick="deleterincian()">Delete</button>
            </div>
        </form>
          </div>
        </div>

        <div class="row mb-3">
                <div class="col-lg-3">
                    <label for="websiteUrl" class="form-label">pendidikan SMA</label>
                </div>
                <div class="col-lg-9">
                    <textarea name="xxx" id="xx" class="form-control" readonly>[{"idx":1,"id":null,"usul_sotk_id":"d9f13001-ad65-412e-a129-d744b40acba8","usul_sotk_detail_id":"xxx","instansi_id":"A5EB03E23BFBF6A0E040640A040252AD","pendidikan_id":"8ae4828947fbda2a01481ad629e5545f","nama_pendidikan":"SLTA/SMA SEDERAJAT","tingkat_pendidikan_id":"15","input_mode":false,"is_saved":false,"mappingPendidikan":null,"status_verifikasi_id":null,"alasan_tolak":null,"verifikator_id":null,"tgl_verval":null}]</textarea>
                </div>
            </div>
        <div class="row mb-3">
                <div class="col-lg-3">
                    <label for="websiteUrl" class="form-label">pendidikan S1 Semua Jurusan</label>
                </div>
                <div class="col-lg-9">
                    <textarea name="xxx" id="xx" class="form-control" readonly>[{"idx":1,"id":null,"usul_sotk_id":"d9f13001-ad65-412e-a129-d744b40acba8","usul_sotk_detail_id":"xxx","instansi_id":"A5EB03E23BFBF6A0E040640A040252AD","pendidikan_id":"f1d4d38aea44400eb2883c698ba2cb43","nama_pendidikan":"D-IV SEMUA JURUSAN","tingkat_pendidikan_id":"40","input_mode":false,"is_saved":false,"mappingPendidikan":null,"status_verifikasi_id":"02","alasan_tolak":null,"verifikator_id":"3d2b29a3-447c-46a5-9031-0c96f2bcfea5","tgl_verval":"2024-07-17"},{"idx":2,"id":null,"usul_sotk_id":"d9f13001-ad65-412e-a129-d744b40acba8","usul_sotk_detail_id":"xxx","instansi_id":"A5EB03E23BFBF6A0E040640A040252AD","pendidikan_id":"0E7FA32614D38672E060640AF1083075","nama_pendidikan":"S-1 SEMUA JURUSAN","tingkat_pendidikan_id":"40","input_mode":false,"is_saved":false,"mappingPendidikan":null,"status_verifikasi_id":"02","alasan_tolak":null,"verifikator_id":"3d2b29a3-447c-46a5-9031-0c96f2bcfea5","tgl_verval":"2024-07-17"}]</textarea>
                </div>
            </div>

        
      </div>
    </div>
  </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://unpkg.com/axios@1.6.7/dist/axios.min.js"></script>

<script>
$(document).ready(function() {
   // Stuff to do as soon as the DOM is ready
});

function search() {
    var jabatan = $('#jabatan').val();
    var penempatan = $('#penempatan').val();
    var subjabatan = $('#subjabatan').val();

    $('#body').html('Lagi nyari....');

    axios.get('<?= site_url()?>pppk/search/'+jabatan+'/'+penempatan+'/'+subjabatan)
  .then(function (response) {
    // handle success
    console.log(response.data);
    
    $('#id').val(response.data.id);
    $('#usul_sotk_detail_id').val(response.data.usul_sotk_detail_id);
    $('#jenis_jabatan_id').val(response.data.jenis_jabatan_id);
    $('#jabatan_fungsional_id').val(response.data.jabatan_fungsional_id);
    $('#jenis_jabatan_umum_id').val(response.data.jenis_jabatan_umum_id);
    $('#angka_pppk_teknis').val(response.data.alokasi_formasi);
    $('#pendidikan').val(JSON.stringify(response.data.pendidikan_id));
  })
  .finally(function () {
    
  });
}

function searchsotk() {
    var unor = $('#unor').val();
    var jabatan = $('#jabatan2').val();
    var subjabatan = $('#subjabatan2').val();

    $('#bodysotk').html('Lagi nyari....');

    axios.get('<?= site_url()?>pppk/searchsotk/'+unor+'/'+jabatan+'/'+subjabatan)
  .then(function (response) {
    // handle success
    console.log(response.data);
    $('#bodysotk').html(response.data.text);
  })
  .catch(function (error) {
    // handle error
    console.log(error);
  })
  .finally(function () {
    
  });
}

function changekuota() {
    $('#infochange').html('Proses....');
    axios.post('<?= site_url()?>pppk/changekuota', {
        id: $('#id').val(),
        pendidikan: $('#pendidikan').val(),
        usul_sotk_detail_id: $('#usul_sotk_detail_id').val(),
        jenis_jabatan_id: $('#jenis_jabatan_id').val(),
        jabatan_fungsional_id: $('#jabatan_fungsional_id').val(),
        jenis_jabatan_umum_id: $('#jenis_jabatan_umum_id').val(),
        angka_pppk_teknis: $('#angka_pppk_teknis').val(),
    })
    .then(function (response) {
        console.log(response);
        alert(response.data.respon_status.status);
        $('#id').val('');
        $('#angka_pppk_teknis').val('');
        $('#infochange').html('Selesai');
    })
    .catch(function (error) {
        console.log(error);
    });
}

function deleterincian() {
    axios.post('<?= site_url()?>pppk/deleterincian', {
        idhapus: $('#idhapus').val()
    })
    .then(function (response) {
        console.log(response);
        alert(response.data.respon_status.status);
    })
    .catch(function (error) {
        console.log(error);
    });
}
</script>
    </body>
</html>
