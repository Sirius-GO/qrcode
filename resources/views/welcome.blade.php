@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-sm-12">
         <?php
            $message = "HEIW QR Code Generator Web Application";

            ?>

            <!-- {!! QrCode::color(21, 32, 166)->size(300)->generate($message); !!} --> 


            <!-- Order important format->size->color->generate -->
            <!-- {!! QrCode::format('png')->size(300)->color(21, 32, 166)->generate($message, '../public/images/qrcode.png'); !!} -->

            <!-- <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate('https://bookiwrote.co.uk')) !!} "> -->
                <div class="container">
                    <h3>Click <a href="/home"> <i class="fa fa-home fa-lg"></i></a> to begin </h3>

                    <p>Create downloadable QR Code PNG image files swiftly, and conveniently. For use in print, publications, presentations, web pages and applications, and more. Each QR code has unlimited destinations.
                        <br>
                        <ul class="list-group"><span class="fw-bold">Dynamically generate QR codes:</span><br>
                            <li class="list-group-item">choose size in pixels from 50 to 1000</li>
                            <li class="list-group-item">any foreground colour</li>
                            <li class="list-group-item">any background colour</li>
                            <li class="list-group-item">add a URL to redirect to (update any time)</li>
                            <li class="list-group-item">conveniently stored in a database for fast retrieval</li>
                            <li class="list-group-item">download in a single click for use</li>
                            <li class="list-group-item">create, edit or delete QR codes on your account</li>
                        </ul>
                    </p>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $(".nav-link").removeClass("active");
        $('#info').addClass('active');
    });
</script>

@endsection