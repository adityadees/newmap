<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
  <meta charset="utf-8">
  <title></title>
  <style>
  #right-panel {
    font-family: 'Roboto','sans-serif';
    line-height: 30px;
    padding-left: 10px;
  }

  #right-panel select, #right-panel input {
    font-size: 15px;
  }

  #right-panel select {
    width: 100%;
  }

  #right-panel i {
    font-size: 12px;
  }
  html, body {
    height: 100%;
    margin: 0;
    padding: 0;
  }
  #map {
    height: 100%;
    float: left;
    width: 50%;
    height: 50%;
  }
  #right-panel {
    float: right;
    width: 34%;
    height: 100%;
  }
  .panel {
    height: 100%;
    overflow: auto;
  }
</style>
</head>
<body>
  <div id="map"></div>
  <div class="row">
    <div class="col-md-12">
      
      <a href="#" data-toggle="modal" class="btn btn-primary" data-target="#ModalAddKerja">
        Tambah Lokasi Kerja
      </a>
    </div>
  </div>
  <script>
    function initMap() {
      var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 4,
          center: {lat: -2.9549663, lng: 104.692924}  // Australia.
        });

      var directionsService = new google.maps.DirectionsService;
      var directionsDisplay = new google.maps.DirectionsRenderer({
        draggable: true,
        map: map,
        panel: document.getElementById('right-panel')
      });

      directionsDisplay.addListener('directions_changed', function() {
        computeTotalDistance(directionsDisplay.getDirections());
      });

      displayRoute('JNE Kantor Perwakilan Irigasi Palembang', 'Red Planet Hotel Palembang', directionsService,
        directionsDisplay);
    }

    function displayRoute(origin, destination, service, display) {
      service.route({
        origin: origin,
        destination: destination,
        waypoints: [{location: 'Taman Polda'},{location: 'MDP IT Superstore'}, {location: 'Halte Gudang Arsip Sumsel'}],
        travelMode: 'WALKING',
        avoidTolls: true
      }, function(response, status) {
        if (status === 'OK') {
          display.setDirections(response);
        } else {
          alert('Could not display directions due to: ' + status);
        }
      });
    }

    function computeTotalDistance(result) {
      var total = 0;
      var myroute = result.routes[0];
      for (var i = 0; i < myroute.legs.length; i++) {
        total += myroute.legs[i].distance.value;
      }
      total = total / 1000;
      document.getElementById('total').innerHTML = total + ' km';
    }
  </script>
  <script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAogXD-AHrsmnWinZIyhRORJ84bgLwDPpg&callback=initMap">
</script>
</body>
</html>
<div class="modal fade" id="ModalAddKerja" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <form action="<?php echo base_url(); ?>frontend/save_pekerjaan" method="POST" enctype="multipart/form-data">
      <div class="modal-content modal-lg">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Tambah Lokasi Kerja</h4>
        </div>
        <div class="modal-body">

          <div class="form-group">
            <strong for="input-label">Nama Tempat Kerja</strong>
            <input name="namakerja" type="text" class="form-control">
          </div>

          <div class="col-md-12">
            <div class="form-group">
              <strong for="input-label">Alamat</strong>
              <input type="text" class="inputAddress input-xxlarge form-control" value="palembang" name="inputAddress" autocomplete="off" placeholder="Type in your address">
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <strong for="input-label">Bidang Kerja</strong>
              <input name="bidang"  type="text" class="form-control">
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <strong for="input-label">Jabatan</strong>
              <input name="jabatan" type="text" class="form-control">
            </div>
          </div>

          <input type="hidden" name="user_kode" value="<?php echo $_SESSION['user_kode']; ?>">
          <input type="hidden" class="latitude form-control" value="latitude" name="latitude" readonly="readonly">
          <input type="hidden" class="longitude form-control" value="longitude" name="longitude" readonly="readonly">


          <div class="modal-footer">
            <div class="col-md-12">
              <button type="submit" class="btn btn-md btn-color pull-right">Simpan</button>
            </div>
          </div>

        </div>
      </form>
    </div> 
  </div> 
</div> 

<script src="<?php echo base_url() ?>assets/map/jquery-1.9.1.min.js"></script>
<script src="<?php echo base_url() ?>assets/map/jquery.addressPickerByGiro.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAogXD-AHrsmnWinZIyhRORJ84bgLwDPpg&sensor=false&language=id"></script>
<link href="<?php echo base_url() ?>assets/map/jquery.addressPickerByGiro.css" rel="stylesheet" media="screen">
<script>
  $('.inputAddress').addressPickerByGiro({
    distanceWidget: true,
    boundElements: {
      'latitude': '.latitude',
      'longitude': '.longitude',
      'formatted_address': '.formatted_address'
    }
  });
</script>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>