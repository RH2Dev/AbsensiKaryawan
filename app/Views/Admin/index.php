<?php echo $this->extend('Admin/layout/template'); ?>

<?php echo $this->section('content'); ?>
<?php $session = session()->get(); ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <div class="d-flex">
    <?php if ($session['adminStatus'] == 1) {?>
    <form class="mr-2" action="<?php echo current_url(); ?>" style="display: flex;">
        <input type="hidden" name="year" value="<?php echo $inputFilterYear ?>">

        <select class="form-select" id="kantor" name="kantor" style="width: 200px;">
            <option value="" selected disabled>Kantor</option>
            <?php foreach ($kantor_arr as $kantor) : ?>
            <option value="<?php echo $kantor['kantor_id'] ?>" <?php echo ($inputFilterKantor == $kantor['kantor_id'] ? 'selected' : ''); ?>><?php echo $kantor['kantor_name'] ?></option>
            <?php endforeach; ?>
        </select>
        <button class="btn btn-primary ml-1" type="submit">
            <i class="fas fa-search fa-sm"></i> Filter
        </button>
    </form>
    <?php } ?>
    <button id="printPdf"  class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Generate Report</button>
    </div>
</div>

<div id="printSection">
    <div class="mb-4 d-flex justify-content-between">
        <div class="card border-left-primary shadow h-100 py-2" style="width: 32%;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <?php if ($session['adminStatus'] == 1) {?>
                            <?php if (!empty($inputFilterKantor)) { ?>
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Jumlah Karyawan <?php echo $kantorName ?></div>
                            <?php } else { ?>
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Jumlah Karyawan Keseluruhan</div>
                            <?php } ?>
                        <?php } else { ?>
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Jumlah Karyawan <?php echo $kantorName ?></div>
                        <?php } ?>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalUser ?> Orang</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="card border-left-info shadow h-100 py-2" style="width: 32%;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <?php if ($session['adminStatus'] == 1) {?>
                            <?php if (!empty($inputFilterKantor)) { ?>
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Absensi Harian <?php echo $kantorName ?></div>
                            <?php } else { ?>
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Absensi Harian Keseluruhan</div>
                            <?php } ?>
                        <?php } else { ?>
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Absensi Harian <?php echo $kantorName ?></div>
                        <?php } ?>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo number_format((float)$absenPercent, 1, '.', ''); ?>%</div>
                            </div>
                            <div class="col">
                                <div class="progress progress-sm mr-2">
                                    <div class="progress-bar bg-info" role="progressbar"
                                        style="width: <?php echo $absenPercent ?>%" aria-valuenow="<?php echo $absenPercent ?>" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="card border-left-info shadow h-100 py-2" style="width: 32%;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <?php if ($session['adminStatus'] == 1) {?>
                            <?php if (!empty($inputFilterKantor)) { ?>
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Checkout Harian <?php echo $kantorName ?></div>
                            <?php } else { ?>
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Checkout Harian Keseluruhan</div>
                            <?php } ?>
                        <?php } else { ?>
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Checkout Harian <?php echo $kantorName ?></div>
                        <?php } ?>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo number_format((float)$checkoutPercent, 1, '.', ''); ?>%</div>
                            </div>
                            <div class="col">
                                <div class="progress progress-sm mr-2">
                                    <div class="progress-bar bg-info" role="progressbar"
                                        style="width: <?php echo $checkoutPercent ?>%" aria-valuenow="<?php echo $checkoutPercent ?>" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bar Chart -->
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between">
            <?php if ($session['adminStatus'] == 1) {?>
                <?php if (!empty($inputFilterKantor)) { ?>
                    <h4 class="h4 mb-0 text-primary">Statistik Absensi Tahunan <?php echo $kantorName; ?></h4>
                <?php } else { ?>
                    <h4 class="h4 mb-0 text-primary">Statistik Absensi Tahunan Keseluruhan</h4>
                <?php } ?>
            <?php } else { ?>
                <h4 class="h4 mb-0 text-primary">Statistik Absensi Tahunan <?php echo $kantorName; ?></h4>
            <?php } ?>
            <form action="<?php echo current_url(); ?>" style="display: flex;">
                <?php if ($session['adminStatus'] == 1) { ?>
                    <input type="hidden" name="kantor" id="kantor" value="<?php echo $inputFilterKantor ?>">
                <?php } ?>
                <select class="form-select ml-1" id="year" name="year" style="width: 100px;">
                    <option value="" selected disabled>Tahun</option>
                    <?php foreach ($absenYear as $year) : ?>
                    <option value="<?php echo $year['Year(absen_datetime)'] ?>" <?php echo ($year['Year(absen_datetime)'] == $inputFilterYear ? 'selected' : ''); ?>><?php echo $year['Year(absen_datetime)'] ?></option>
                    <?php endforeach; ?>
                </select>         
                <button class="btn btn-primary ml-1" type="submit">
                    <i class="fas fa-search fa-sm"></i> Filter
                </button>
            </form>
        </div>
        <div class="card-body">
            <div class="chart-bar">
                <canvas id="myBarChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Google Map -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row justify-content-between">
            <h6 class="m-1 font-weight-bold text-primary">Absensi Hari ini <?php echo $kantorName; ?></h6>
        </div>
        <div class="card-body">
            <div id="map" style="width: 100%; height: 500px;"> </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        
        <div class="card-header py-3 d-flex flex-row justify-content-between">
            
            <?php if ($session['adminStatus'] == 1) {?>
                <?php if (!empty($inputFilterKantor)) { ?>
                    <h6 class="m-1 font-weight-bold text-primary">Karyawan yang Belum Absen Hari Ini <?php echo $kantorName; ?></h6>
                <?php } else { ?>
                    <h6 class="m-1 font-weight-bold text-primary">Karyawan yang Belum Absen Hari Ini Keseluruhan</h6>
                <?php } ?>
            <?php } else { ?>
                <h6 class="m-1 font-weight-bold text-primary">Karyawan yang Belum Absen Hari Ini <?php echo $kantorName; ?></h6>
            <?php } ?>
            
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <?php if (!empty($user_arr)) { ?>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>Jenis Kelamin</th>
                        <th>Kantor</th>
                        <th>Aksi</th>
                    </tr>
                    <?php $i = 1; ?>
                    <?php foreach($user_arr as $user) : ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $user['user_name']; ?></td>
                        <td><?php echo $user['user_nik']; ?></td>
                        <td><?php echo $user['user_jenis_kelamin']; ?></td>
                        <td><?php echo $user['kantor_name']; ?></td>
                        <td>
                            <a href="<?php echo base_url(); ?>/Admin/User/<?php echo $user['user_nik']; ?>"><button type="button" class="btn btn-warning">Details</button></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php } else { ?>
                    <div class="alert alert-success" role="alert">
                        Semua Karyawan Sudah Absen Hari Ini
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>/assets/chart.js/Chart.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo getenv('API_GMAP'); ?>&callback=initMap&v=weekly" defer></script>
<script>

// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';
function number_format(number, decimals, dec_point, thousands_sep) {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + '').replace(',', '').replace(' ', '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}

// Bar Chart Example
var ctx = document.getElementById("myBarChart");
var myBarChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    datasets: [{
      label: "Absensi",
      backgroundColor: "#27d600",
      hoverBackgroundColor: "#1ea600",
      borderColor: "#27d600",
      data: [<?php echo $absenJan ?>, <?php echo $absenFeb ?>, <?php echo $absenMar ?>, <?php echo $absenApr ?>, <?php echo $absenMei ?>, <?php echo $absenJun ?>, <?php echo $absenJul ?>, <?php echo $absenAgu ?>, <?php echo $absenSep ?>, <?php echo $absenOkt ?>, <?php echo $absenNov ?>, <?php echo $absenDes ?>],
    },
    {
      label: "Belum Absen",
      backgroundColor: "#eb1700",
      hoverBackgroundColor: "#ab0b00",
      borderColor: "#eb1700",
      data: [<?php echo $offJan ?>, <?php echo $offFeb ?>, <?php echo $offMar ?>, <?php echo $offApr ?>, <?php echo $offMei ?>, <?php echo $offJun ?>, <?php echo $offJul ?>, <?php echo $offAgu ?>, <?php echo $offSep ?>, <?php echo $offOkt ?>, <?php echo $offNov ?>, <?php echo $offDes ?>],
    }
],
  },
  options: {
    maintainAspectRatio: false,
    layout: {
      padding: {
        left: 10,
        right: 25,
        top: 25,
        bottom: 0
      }
    },
    scales: {
      xAxes: [{
        time: {
          unit: 'month'
        },
        gridLines: {
          display: false,
          drawBorder: false
        },
        ticks: {
          maxTicksLimit: 6
        },
        maxBarThickness: 25,
      }],
      yAxes: [{
        ticks: {
          min: 0,
          maxTicksLimit: 5,
          padding: 10,
          // Include a dollar sign in the ticks
          callback: function(value, index, values) {
            return + number_format(value) + '%';
          }
        },
        gridLines: {
          color: "rgb(234, 236, 244)",
          zeroLineColor: "rgb(234, 236, 244)",
          drawBorder: false,
          borderDash: [2],
          zeroLineBorderDash: [2]
        }
      }],
    },
    legend: {
      display: false
    },
    tooltips: {
      titleMarginBottom: 10,
      titleFontColor: '#6e707e',
      titleFontSize: 14,
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
      callbacks: {
        label: function(tooltipItem, chart) {
          var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
          return datasetLabel + ': ' + number_format(tooltipItem.yLabel) + ' %';
        }
      }
    },
  }
});
</script>

<script>
    // Initialize and add the map
    function initMap() {
        const kantor = { lat: <?php echo $kantor_map['kantor_latitude'] ?>, lng: <?php echo $kantor_map['kantor_longitude'] ?> };
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 19,
            center: kantor,
        });
        // Draw Circle
        const cityCircle = new google.maps.Circle({
        strokeColor: "#FF0000",
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: "#FF0000",
        fillOpacity: 0.35,
        map,
        center: kantor,
        radius: <?php echo $kantor_map['kantor_radius'] ?>,
        });
        // The marker, positioned at absen
        <?php if (!empty($absen_arr)) { ?>
        <?php foreach($absen_arr as $absen) : ?>
        const absen<?php echo $absen['absen_id'] ?> = new google.maps.Marker({
            position: {lat: <?php echo $absen['absen_latitude'] ?>, lng: <?php echo $absen['absen_longitude'] ?>},
            map: map,
        });
        <?php endforeach ?>
        <?php } ?>
    }
    window.initMap = initMap;
</script>
<?php echo $this->endSection(); ?>