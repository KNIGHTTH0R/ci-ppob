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
    #operator-info{
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
      <a class="nav-link active" href="#pulsa" role="tab" data-toggle="tab">Pulsa</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#paket-data" role="tab" data-toggle="tab">Paket Data</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#listrik" role="tab" data-toggle="tab">Listrik PLN</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#references" role="tab" data-toggle="tab">Lain2</a>
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
          <form action="<?=base_url('home/topup_request/')?>" id="ppob" method="post">
            <div class="row">
                <input type="hidden" name="order_type" id="order_type" value="pulsa">
                <div class="col-md-4">
                  <div class="form-group">
                   <input type="text" class="form-control" id="nomor" name="nomor" placeholder="Masukkan nomor HP Anda">
                   <span id="operator-info"></span>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <select id="nominal" class="form-control" name="nominal">
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
    <!-- <div role="tabpanel" class="tab-pane" id="paket-data">
      <div class="card">
        <div class="card-header">
          Isi Paket Data Saya
        </div>
        <div class="card-body">
          <form action="<?=base_url('home/topup_request/')?>" id="ppob" method="post">
            <div class="row">
                <input type="hidden" name="order_type" id="order_type" value="data">
                <div class="col-md-4">
                  <div class="form-group">
                   <input type="text" class="form-control" id="nomor" name="nomor" placeholder="Masukkan nomor HP Anda">
                   <span id="operator-info"></span>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <select id="nominal" class="form-control" name="nominal">
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
    </div> -->
    <!-- <div role="tabpanel" class="tab-pane" id="listrik">
      <div class="card">
        <div class="card-header">
          Isi Listrik Saya
        </div>
        <div class="card-body">
          <form action="<?=base_url('home/topup_request/')?>" id="ppob" method="post">
            <div class="row">
                <input type="hidden" name="order_type" id="order_type" value="pln">
                <div class="col-md-4">
                  <div class="form-group">
                   <input type="text" class="form-control" id="nomor" name="nomor" placeholder="Masukkan nomor HP Anda">
                   <span id="operator-info"></span>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <select id="nominal" class="form-control" name="nominal">
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
    </div> -->
  </div>

</div>

<script type="text/javascript">
  $(document).ready(function () {

    $('#nomor').on('input',function(e){
      var nomor = $('#nomor').val();

      if(nomor.length == 4){
        var prefix = nomor.substring(0, 4);
        get_operator(prefix);
      }
    });

    function get_operator(prefix){
      $.ajax({
          url: '<?=base_url('home/get_operator/')?>' + prefix,
          type: 'POST',
          success: function(data){
            var operator = data;
            $('#operator-info').html(data);
            console.log(data);
            get_nominal(operator);
          }
      });
    }

    function get_nominal(operator){
      var type = $('#order_type').val();
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
                $('#nominal')
                  .append($("<option></option>")
                             .attr("value",value.pulsa_code)
                             .html(nominal + " (Rp. " + price + ") "));
              });
            });
          }
      });
    }

    // this is the id of the form
    $("#ppob").submit(function(e) {
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
