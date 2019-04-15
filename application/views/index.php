<!DOCTYPE html>
<html lang="en">
<head>
  <title>Deplaza</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <style>
    #operator-info-pulsa, #operator-info-data{
      position: absolute;
      top: 6px;
      right: 37px;
    }
    .hidden{
      display: none;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>Selamat datang di Deplaza</h2>
  <p>Anda bisa membeli pulsa, bayar listrik, hingga pesan tiket KAI disini </p>

  <!-- Button to Open the Modal -->
  <button type="button" class="btn btn-success" id="check-balance">Cek Saldo</button>

  <hr>

  <ul class="nav nav-pills nav-justified" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" href="#pulsa" role="tab" data-toggle="tab">Pulsa Telephon</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#paket-data" role="tab" data-toggle="tab">Paket Data</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#listrik" role="tab" data-toggle="tab">Pulsa Listrik</a>
    </li>
  </ul><br>
  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="pulsa">
      <div class="card">
        <div class="card-header">
          Isi Pulsa Saya
        </div>
        <div class="card-body">
          <form action="<?=base_url('home/topup_request/')?>" id="ppob-pulsa" method="post">
            <div class="row">
                <input type="hidden" name="order_type" id="order_type_pulsa" value="pulsa">
                <div class="col-md-4">
                  <div class="form-group">
                   <input type="text" class="form-control" id="nomor-pulsa" name="nomor" placeholder="Masukkan nomor HP Anda">
                   <span id="operator-info-pulsa"></span>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <select id="nominal-pulsa" class="form-control" name="nominal">
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-primary" value="Beli">
                  </div>
                </div>
            </div>
          </form>
        </div>
        <div class="card-footer">

        </div>
      </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="paket-data">
      <div class="card">
        <div class="card-header">
          Isi Paket Data Saya
        </div>
        <div class="card-body">
          <form action="<?=base_url('home/topup_request/')?>" id="ppob-data" method="post">
            <div class="row">
                <input type="hidden" name="order_type" id="order_type_data" value="data">
                <div class="col-md-4">
                  <div class="form-group">
                   <input type="text" class="form-control" id="nomor-data" name="nomor" placeholder="Masukkan nomor ID Pelanggan">
                   <span id="operator-info-data"></span>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <select id="nominal-data" class="form-control" name="nominal">
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-primary" value="Beli">
                  </div>
                </div>
            </div>
          </form>
        </div>
        <div class="card-footer">

        </div>
      </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="listrik">
      <div class="card">
        <div class="card-header">
          Isi Listrik Saya
        </div>
        <div class="card-body">
          <form action="<?=base_url('home/topup_request/')?>" id="ppob-listrik" method="post">
            <div class="row">
                <input type="hidden" name="order_type" id="order_type_listrik" value="pln">
                <div class="col-md-4">
                  <div class="form-group">
                   <input type="text" class="form-control" id="nomor-listrik" name="nomor" placeholder="Masukkan nomor HP Anda">
                   <span id="operator-info"></span>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <select id="nominal-listrik" class="form-control" name="nominal">
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-primary" value="Beli">
                  </div>
                </div>
            </div>
          </form>
        </div>
        <div class="card-footer">

        </div>
      </div>
    </div>
  </div>

</div>

<script type="text/javascript">
  $(document).ready(function () {

    // nomor pulsa
    $('#nomor-pulsa').on('input',function(e){
      var nomor = $('#nomor-pulsa').val();

      if(nomor.length == 4){
        var prefix = nomor.substring(0, 4);
        get_operator_pulsa(prefix);
      }
    });

    // nomor paket data
    $('#nomor-data').on('input',function(e){
      var nomor = $('#nomor-data').val();

      if(nomor.length == 4){
        var prefix = nomor.substring(0, 4);
        get_operator_data(prefix);
      }
    });

    // nomor paket data
    $('#nomor-listrik').on('input',function(e){
      var nomor = $('#nomor-listrik').val();

      if(nomor.length == 1){
        get_nominal_listrik('pln');
      }
    });

    // get operator pulsa
    function get_operator_pulsa(prefix){
      $.ajax({
          url: '<?=base_url('home/get_operator/')?>' + prefix,
          type: 'POST',
          success: function(data){
            var operator = data;
            $('#operator-info-pulsa').html(data);
            console.log(data);
            get_nominal_pulsa(operator);
          }
      });
    }

    // get operator data
    function get_operator_data(prefix){
      $.ajax({
          url: '<?=base_url('home/get_operator/')?>' + prefix,
          type: 'POST',
          success: function(data){
            var operator = data;
            $('#operator-info-data').html(data);
            console.log(data);
            get_nominal_data(operator);
          }
      });
    }

    //pulsa
    function get_nominal_pulsa(operator){
      var type = $('#order_type_pulsa').val();
      $.ajax({
          url: '<?=base_url('home/get_nominal/')?>' + type + "/" + operator,
          type: 'POST',
          dataType: 'JSON',
          success: function(data){
            console.log(data);
            $.each(data, function(key, value) {
              $.each(value, function(key, value) {
                var nominal = formatRupiah(value.pulsa_nominal);
                var price = formatRupiah(value.pulsa_price);
                $('#nominal-pulsa')
                  .append($("<option></option>")
                             .attr("value",value.pulsa_code)
                             .html(nominal + " (Rp. " + price + ") "));
              });
            });
          }
      });
    }

    //data
    function get_nominal_data(operator){
      var type = $('#order_type_data').val();
      $.ajax({
          url: '<?=base_url('home/get_nominal/')?>' + type + "/" + operator,
          type: 'POST',
          dataType: 'JSON',
          success: function(data){
            console.log(data);
            $.each(data, function(key, value) {
              $.each(value, function(key, value) {
                var nominal = formatRupiah(value.pulsa_nominal);
                var price = formatRupiah(value.pulsa_price);
                $('#nominal-data')
                  .append($("<option></option>")
                             .attr("value",value.pulsa_code)
                             .html(nominal + " (Rp. " + price + ") "));
              });
            });
          }
      });
    }

    //listrik
    function get_nominal_listrik(operator){
      var type = $('#order_type_listrik').val();
      $.ajax({
          url: '<?=base_url('home/get_nominal/')?>' + type + "/" + operator,
          type: 'POST',
          dataType: 'JSON',
          success: function(data){
            console.log(data);
            $.each(data, function(key, value) {
              $.each(value, function(key, value) {
                var nominal = formatRupiah(value.pulsa_nominal);
                var price = formatRupiah(value.pulsa_price);
                $('#nominal-listrik')
                  .append($("<option></option>")
                             .attr("value",value.pulsa_code)
                             .html(nominal + " (Rp. " + price + ") "));
              });
            });
          }
      });
    }

    //ppob-pulsa
    $("#ppob-pulsa").submit(function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);
        var url = form.attr('action');

        $.ajax({
               type: "POST",
               url: url,
               data: form.serialize(), // serializes the form's elements.
               dataType: "JSON",
               success: function(data)
               {
                   console.log(data); // show response from the php script.
                   $.each(data, function(key, value) {
                      alert("status transaksi anda adalah " + value.message);
                   });
               }
      });

    });

    //ppob-data
    $("#ppob-data").submit(function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);
        var url = form.attr('action');

        $.ajax({
               type: "POST",
               url: url,
               data: form.serialize(), // serializes the form's elements.
               dataType: "JSON",
               success: function(data)
               {
                   console.log(data); // show response from the php script.
                   $.each(data, function(key, value) {
                      alert("status transaksi anda adalah " + value.message);
                   });
               }
      });

    });

    //ppob-listrik
    $("#ppob-listrik").submit(function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);
        var url = form.attr('action');

        $.ajax({
               type: "POST",
               url: url,
               data: form.serialize(), // serializes the form's elements.
               dataType: "JSON",
               success: function(data)
               {
                   console.log(data); // show response from the php script.
                   $.each(data, function(key, value) {
                      alert("status transaksi anda adalah " + value.message);
                   });
               }
      });

    });

    /* Fungsi formatRupiah */
    function formatRupiah(num) {
    		return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")
    }


    $('#check-balance').click(function(){
      $.ajax({
          url: '<?=base_url('home/check_balance/')?>',
          type: 'POST',
          dataType: 'JSON',
          success: function(data){
            $.each(data, function(key, value) {
              console.log(value.balance);
              alert('Saldo Anda adalah Rp.' + formatRupiah(value.balance));
            });
          }
      });
    });

  });
</script>

</body>
</html>
