<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Marlin Test</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:600,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

    </style>
</head>
<body>

<div class="container">
    <div class="row mt-5">
        <div class="col-md-6">
            <h3>Ongkos Kirim</h3>
            <form id="form-ongkir">
                <div class="form-group">
                    <label>Pilih Provinsi</label>
                    <select name="province" class="form-control" required>
                        <option>-- Pilih --</option>
                        @foreach($province as $k => $v)
                            <option value="{{ $v->province_id }}">{{ $v->province }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Pilih Kota</label>
                    <select name="city" class="form-control" required>
                    </select>
                </div>
                <div class="form-group">
                    <label>Pilih Ekspedisi</label>
                    {{--                    Available ekspedisi from rajaongkir starter api-docs--}}
                    <select name="ekspedisi" class="form-control">
                        <option value="jne">JNE</option>
                        <option value="pos">POS</option>
                        <option value="tiki">TIki</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Berat Barang (Gr)</label>
                    <input type="number" name="weight" class="form-control" required/>
                </div>
                <button type="submit" class="btn btn-primary">Cek Ongkir</button>
            </form>
        </div>
        <div class="col-md-6">
            <b>Ongkos Kirim</b>
            <ul></ul>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-6">
            <h3>Looping Marlin Booking</h3>
            <form method="GET" action="{{ url('loop') }}">
                <div class="form-group">
                    <label>Input Jumlah Looping</label>
                    <input type="number" name="loop" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

<script
    src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>

<script>
    var selected_city = {};
    $(document).ready(function () {
        $('[name="province"]').change(function () {
            var val = $(this).val();

            $('[name="city"]').html('<option>Please wait...</option>');

            $.getJSON('{{ url("city") }}', {province_id: val}, function (r) {
                selected_city = r;

                var option = '';
                $.each(selected_city, function (i, o) {
                    option += '<option value="' + o.city_id + '">' + o.city_name + '</option>';
                });

                $('[name="city"]').html(option);
            })
        });

        $('#form-ongkir').submit(function (e) {
            e.preventDefault();

            $.getJSON('{{ url("cost") }}', $(this).serializeArray(), function (r) {
                var list = '';

                $.each(r, function (i, k) {
                    $.each(k.costs, function (i, o) {
                        var cost = '';
                        $.each(o.cost, function (j, k) {
                            cost += `
                                        <p>
                                            ${k.value} (${k.etd}) days
                                        </p>
                                        `;
                        });

                        list += `
                            <li>
                                <b>${o.service}</b>
                                <br/>
                                <small>${o.description}</small>
                                ${cost}
                            </li>`;


                        $('ul').html(list);
                    });
                });
            });
        });
    });
</script>
</body>
</html>
