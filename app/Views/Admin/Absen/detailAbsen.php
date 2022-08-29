<?php echo $this->extend('Admin/layout/template'); ?>

<?php echo $this->section('content'); ?>

<?php $session = session()->get(); ?>
<?php foreach($absen_arr as $absen) : ?>
    
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Absensi</h1>
    <button id="printPdf"  class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Generate PDF</button>
</div>
<div id="printSection">
    <div class="d-flex justify-content-between mb-3">
        <div class="card bg-dark text-white shadow" style="width: 49%;">
            <div class="card-body">
                <img src="<?php echo base_url(); ?>/img/<?php echo $absen['absen_photo']; ?>" alt="" width="100%">
            </div>
        </div>
        <div class="card bg-dark text-white shadow" style="width: 49%;">
            <div class="card-body">
                <img src="<?php echo base_url(); ?>/img/<?php echo $absen['absen_photo_checkout']; ?>" alt="" width="100%">
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between mb-3">
        <div class="card bg-dark text-white shadow" style="width: 24.5%;">
            <div class="card-body">
                Nama Karyawan
                <div class="text-white-50 small"><?php echo $absen['user_name']; ?></div>
            </div>
        </div>
        <div class="card bg-dark text-white shadow" style="width: 24.5%;">
            <div class="card-body">
                NIK Karyawan
                <div class="text-white-50 small"><?php echo $absen['absen_nik']; ?></div>
            </div>
        </div>
        <div class="card bg-dark text-white shadow" style="width: 24.5%;">
            <div class="card-body">
                Jabatan
                <div class="text-white-50 small"><?php echo $absen['jabatan_nama']; ?></div>
            </div>
        </div>
        <div class="card bg-dark text-white shadow" style="width: 24.5%;">
            <div class="card-body">
                Jenis Kelamin
                <div class="text-white-50 small"><?php echo $absen['user_jenis_kelamin']; ?></div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between mb-3">
        <div class="card bg-dark text-white shadow"  style="width: 24.5%;">
            <div class="card-body">
                Tanggal Absensi
                <div class="text-white-50 small"><?php echo $absen['absen_datetime']; ?></div>
            </div>
        </div>
        <div class="card bg-dark text-white shadow"  style="width: 24.5%;">
            <div class="card-body">
                Lokasi
                <div class="text-white-50 small"><?php echo $absen['absen_latitude']; ?> <?php echo $absen['absen_longitude']; ?></div>
            </div>
        </div>
        <div class="card bg-dark text-white shadow"  style="width: 24.5%;">
            <div class="card-body">
                Tanggal Checkout
                <div class="text-white-50 small"><?php echo $absen['absen_checkout_datetime']; ?></div>
            </div>
        </div>
        <div class="card bg-dark text-white shadow"  style="width: 24.5%;">
            <div class="card-body">
                Lokasi
                <div class="text-white-50 small"><?php echo $absen['absen_latitude_checkout']; ?> <?php echo $absen['absen_longitude_checkout']; ?></div>
            </div>
        </div>
    </div>
    <?php
        $lat = $absen['absen_latitude'];
        $long = $absen['absen_longitude'];
        $latCheckout = $absen['absen_latitude_checkout'];
        $longCheckout = $absen['absen_longitude_checkout'];
        $latKantor = $absen['kantor_latitude'];
        $lngKantor = $absen['kantor_longitude'];
    ?>

    <?php endforeach; ?>

    <h2 style="text-align: center;">Lokasi Absen</h2>
    <div id="map" style="width: 100%; height: 449px;">
    </div>
</div>
<script
      src="https://maps.googleapis.com/maps/api/js?key=<?php echo getenv('API_GMAP'); ?>&callback=initMap&v=weekly"
      defer
    ></script>
<script>
    // Initialize and add the map
    function initMap() {
    // The location of Uluru
    const kantor = { lat: <?php echo $latKantor ?>, lng: <?php echo $lngKantor ?>};
    const absen = { lat: <?php echo $lat ?>, lng: <?php echo $long ?> };
    const checkout = { lat: '<?php echo $latCheckout ?>', lng: '<?php echo $longCheckout ?>' };
    // The map, centered at absen
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 19,
        center: kantor,
    });
    // The marker, positioned at absen
    const marker = new google.maps.Marker({
        position: absen,
        map: map,
    });
    
    const markerCheckout = new google.maps.Marker({
        position: checkout,
        map: map,
    });

    const cityCircle = new google.maps.Circle({
      strokeColor: "#FF0000",
      strokeOpacity: 0.8,
      strokeWeight: 2,
      fillColor: "#FF0000",
      fillOpacity: 0.35,
      map,
      center: kantor,
      radius: 50,
    });
    }

    window.initMap = initMap;
</script>

<?php echo $this->endSection(); ?>