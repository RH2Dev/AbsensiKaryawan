<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Absensi</title>

    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url(); ?>/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css"><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/custom.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/jquery/jquery.min.js"></script>

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url(); ?>/assets/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <div id="content-wrapper" class="d-flex flex-column">
            <form id="absen" action="<?= base_url(); ?>/insert" method="POST">
                <input id="latitude" type="hidden" name="latitude" value="<?= old('latitude'); ?>">
                <input id="longitude" type="hidden" name="longitude" value="<?= old('longitude'); ?>">
                <input class="data-photo" type="hidden" name="photo" value="<?= old('photo'); ?>">
                <div class="display-cover">
                    <video autoplay></video>
                    <canvas class="d-none"></canvas>

                    <div class="form-input">
                        <h3 class="title">ABSENSI KARYAWAN</h3>
                        <p class="error-message"><?= (session()->getFlashData('pesan') ? session()->getFlashdata('pesan'): ''); ?></p>
                        <input type="text" class="form-control" id="nik" name="nik" value="<?= old('nik'); ?>" placeholder="Masukkan NIK anda">
                        <button class="btn btn-primary" type="button" onclick="absen()"> Submit </button>
                    </div>

                    <img class="screenshot-image d-none" alt="" />

                    <div class="controls">
                        <button type="button" class="btn btn-outline-success screenshot d-none" title="ScreenShot" id="screenshot">
                            <i data-feather="image"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div> 
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo base_url(); ?>/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url(); ?>/assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="<?php echo base_url(); ?>/assets/js/camera2.js"></script>
    <script>
        function absen() {
            $('#screenshot').click();
        }
    </script>

</body>

</html>