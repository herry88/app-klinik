<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Purchase Order</title>
    <style>
        .title-header {
            font-size:25px;
            font-weight: bold;
            text-align: right
        }
        .title-referensi{
            float: right;
            font-size:15px
        }
        .info{
            padding-top:150px;
            font-size:15px
        }
        .table-responsive{
            padding-top: 40px;
            font-size:15px
        }
        .table-barang{
            width: 100%;
            border: 1px solid #ffffff;
            text-align: center
        }
        .table-barang tr th{
            background-color:  #03537a;
            color: #ffffff;
            height: 30px;
        }
        .table-barang tr td{
            height: 35px;
            background-color:   #f1f2f2 
        }
        .detail-harga{
            width: 100%;
            padding-top: 50px;
            font-size:15px
        }
        .syarat-dan-ketentuan{
            width: 100%;
            padding-top: 150px;
            font-size:15px
        }
    </style>
</head>
<body  style="font-family: 'sans-serif;">
    
    <div class="container">
        <div class="title-header">
            Purchase Order
        </div>
        <div class="title-referensi">
            <table style="width: 100%">
                <tr>
                    <td style="width: 50%">
                        <img src="image/{{ $setting->logo }}" alt="" style="width:100%">
                    </td>
                    <td  style="width: 50%">
                        <table  style="width: 100%">
                            <tr align="right">
                                <td style="width: 40%:"><strong>Referensi</strong></td>
                                <td style="width: 60%:">{{ $purchase_order->kode }}</td>
                            </tr>
                            <tr align="right">
                                <td style="width: 70%:"><strong>Tanggal</strong></td>
                                <td style="width: 30%:">{{ $purchase_order->tanggal }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>

        <div class="info">
            <table style="width: 100%">
                <tr>
                    <td style="width: 45%:">
                        Info Perusahaan
                        <hr>
                        <strong>{{ $setting->nama_instansi }}</strong>

                        <div style="padding-top: 30px">
                            <span>{{ $setting->nomor_telpon }}</span><br>
                            <span>{{ $setting->alamat }}</span>
                        </div>
                    </td>
                    <td style="width:10%"></td>
                    <td style="width: 45%:">
                        Info Supplier
                        <hr>
                        <strong>{{ $purchase_order->supplier->nama_supplier }}</strong>

                        <div  style="padding-top: 30px">
                            <span>{{ $purchase_order->supplier->nomor_telpon }}</span><br>
                            <span>{{ $purchase_order->supplier->alamat }}</span>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="table-responsive">
            <table cellspacing="1" cellpadding="10" class="table-barang">
                <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Barang</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                </tr>
                <?php $total = 0; ?>
                @foreach($purchase_order_detail as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row->barang->kode }}</td>
                    <td>{{ $row->barang->nama_barang }}</td>
                    <td>{{ $row->qty }}</td>
                    <td>@currency($row->barang->harga)</td>
                </tr>
                <?php $total +=  $row->barang->harga * $row->qty?>
                @endforeach
            </table>
        </div>

        <div class="detail-harga">
            <table style="width: 100%">
                <tr align="right">
                    <td style="width: 70%:"><strong>Subtotal</strong></td>
                    <td style="width: 30%:">@currency($total)</td>
                </tr>
            </table>
        </div>

        <div class="syarat-dan-ketentuan">
            <table style="width: 100%">
                {{-- <tr>
                    <td style="width: 100%:">Syarat dan ketentuan</td>
                </tr> --}}
                <tr>
                    <td style="width: 50%:"><hr></td>
                    <td style="width: 50%:" align="right">{{ date('d-m-Y') }}</td>
                </tr>
            </table>
        </div>
    </div>

</body>
</html>