@extends('layouts.app')

@section('content')
<div style="margin: 0px 50px 0px 50px;">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header fw-bold">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#create" class="btn btn-success"> <i class="fa fa-plus fa-lg"></i> Create a new QR Code</a>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                            @if(count($qr) >0)
                            @foreach($qr as $qc)
                            
                                <div class="col-md-6">
                                    <div class="card bg-light">
                                    <div style="display: inline-block;">
                                            <span class="fw-bold">Record ID:</span> <span>{{$qc->id}}</span>
                                        </div>
                                        <div style="display: inline-block;">
                                            <span class="fw-bold">User ID:</span> <span>{{$qc->user_id}}</span> - <span class="fw-bold">Name:</span> <span>{{Auth()->User()->name}}</span>
                                        </div>
                                        <div style="display: inline-block;">
                                            <span class="fw-bold">Size:</span> <span>{{$qc->size}} pixels</span>
                                        </div>
                                        <div style="display: inline-block;">
                                            <!-- ADD LOGO TO CENTRE ->merge('/public/images/nhs-wales-logo.png') -->
                                            <span  class="fw-bold">Foreground Colour (RGB):</span>
                                            <span>
                                                <?php $col = explode(", ", $qc->fcolor); echo $col[0].', '.$col[1].', '.$col[2]; ?>
                                            </span>
                                        </div>
                                        <div style="display: inline-block;">
                                            <span class="fw-bold">Background Colour (RGB):</span>
                                            <span>
                                                <?php $bcol = explode(", ", $qc->bcolor); echo $bcol[0].', '.$bcol[1].', '.$bcol[2]; ?>
                                            </span>
                                        </div>
                                        <div style="display: inline-block;">
                                            <span class="fw-bold">QR CODE dynamic URL:</span> <span>{{$qc->message}}</span>
                                            <br>
                                            <span class="fw-bold">Re-direct URL:</span> <span>{{$qc->rurl}}</span>
                                            <br><br>
                                            <div class="fw-bold">(Click the QR Code image to download)</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 d-flex justify-content-center">
                                    <div>
                                        <a href="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size($qc->size)->color($col[0], $col[1], $col[2])->backgroundColor($bcol[0], $bcol[1], $bcol[2])->generate($qc->message)) !!}" download="qrcode_{{$qc->id}}.png" title="Click to download"><img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size($qc->size)->color($col[0], $col[1], $col[2])->backgroundColor($bcol[0], $bcol[1], $bcol[2])->generate($qc->message)) !!} " height="{{$qc->size}}" width="{{$qc->size}}" class="mt-2" style="max-width: 100%;height: auto;"></a>
                                    </div>
                                </div>
                                <div class="col-md-12"><br></div>
                                <div class="card-footer bg-light d-flex justify-content-evenly" style="border: solid 1px #ddd;">
                                    <!-- <span><a href="#" data-bs-toggle="modal" data-bs-target="#edit" onclick="editQR(`{{$qc->id}}`, `{{$qc->message}}`, `{{$qc->size}}`, `{{$qc->fcolor}}`, `{{$qc->bcolor}}`, `{{$qc->rurl}}`)" class="btn btn-primary"> <i class="fa fa-edit fa-lg"></i> Edit </a></span> -->
                                    <span><a href="#" data-bs-toggle="modal" data-bs-target="#edit" onclick="editQR(`{{$qc->id}}`, `{{$qc->size}}`, `{{$qc->fcolor}}`, `{{$qc->bcolor}}`, `{{$qc->rurl}}`)" class="btn btn-primary"> <i class="fa fa-edit fa-lg"></i> Edit </a></span>
                                    <span><a href="#" data-bs-toggle="modal" data-bs-target="#delete" onclick="deleteQR(`{{$qc->id}}`)" class="btn btn-danger"> <i class="fa fa-trash fa-lg"></i> Delete </a></span>
                                </div>
                                <div class="col-md-12"><hr></div>
                            
                            @endforeach
                            @else 
                                <div class="card">
                                    <p>You don't have any QR codes generated yet. Click the button above to get started.</p>
                                </div>   
                            @endif
                    </div>






                </div>
            </div>
        </div>
    </div>
</div>





<!-- ADD MODALS HERE --> 

<div class="modal fade" tabindex="-1" role="dialog" id="create">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header bg-success">
            <h5 class="modal-title text-white">Create a New QR Code</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-black bg-light">

            <h4 style="font-weight: 700;">Complete required fields</h4>
            <form action="{{ route('create.qrcode') }}" method="post" id="form_contents">
                {{ csrf_field() }}
                <!-- <label>Text / URL / Other:</label>
                <input type="text" name="message" class="form-control" placeholder="Max 255 Characters" maxlength="255" required/> -->
                <label>QR Code Size in Pixels:</label>
                <select name="size" class="form-select">
                    <option value="50"> - 50 - </option>
                    <option value="100"> - 100 - </option>
                    <option value="150"> - 150 - </option>
                    <option value="200"> - 200 - </option>
                    <option value="250" selected> - 250 - </option>
                    <option value="300"> - 300 - </option>
                    <option value="350"> - 350 - </option>
                    <option value="400"> - 400 - </option>
                    <option value="450"> - 450 - </option>
                    <option value="500"> - 500 - </option>
                    <option value="750"> - 750 - </option>
                    <option value="1000"> - 1000 - </option>
                </select>
                <label>Foreground Color:</label>
                <input type="color" name="color" class="form-control" />    
                <label>Background Color:</label>
                <input type="color" name="bcolor" class="form-control" value="#ffffff" /> 
                <label>Re-direct URL:</label>
                <input type="text" name="rurl" class="form-control" placeholder="Max 255 Characters - must include the protocol (https://)" maxlength="255" /> 
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success">
                 <i class="fa fa-save fa-lg"></i> &nbsp; Generate and Save
            </button>
        </div>
        </form>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- EDIT --> 
<div class="modal fade" tabindex="-1" role="dialog" id="edit">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header bg-primary">
            <h5 class="modal-title text-white">Edit QR Code</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-black bg-light">

            <h4 style="font-weight: 700;">Ajust the required fields</h4>
            <form action="{{ route('edit.qrcode') }}" method="post" id="form_contents">
                {{ csrf_field() }}
                <!-- <label>Text / URL / Other:</label>
                <input type="text" name="message" id="message" class="form-control" placeholder="Max 255 Characters" maxlength="255" required/> -->
                <label>QR Code Size in Pixels:</label>
                <select name="size" class="form-select">
                    <option id="size" selected></option>
                    <option value="50"> - 50 - </option>
                    <option value="100"> - 100 - </option>
                    <option value="150"> - 150 - </option>
                    <option value="200"> - 200 - </option>
                    <option value="250"> - 250 - </option>
                    <option value="300"> - 300 - </option>
                    <option value="350"> - 350 - </option>
                    <option value="400"> - 400 - </option>
                    <option value="450"> - 450 - </option>
                    <option value="500"> - 500 - </option>
                    <option value="750"> - 750 - </option>
                    <option value="1000"> - 1000 - </option>
                </select>
                <label>Foreground Color:</label>
                <input type="color" name="color" id="fcolor" class="form-control" />    
                <label>Background Color:</label>
                <input type="color" name="bcolor" id="bcolor" class="form-control" value="#ffffff" /> 
                <label>Re-direct URL:</label>
                <input type="text" name="rurl" id="rurl" class="form-control" placeholder="Max 255 Characters - must include the protocol (https://)" maxlength="255" /> 
                <input type="hidden" name="rid" id="rid" />
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">
                 <i class="fa fa-save fa-lg"></i> &nbsp; Update and Save
            </button>
        </div>
        <script>
            //function editQR(id, msg, sz, fcol, bcol, reurl){
            function editQR(id, sz, fcol, bcol, reurl){
                //Set Vars
                //let qr_id = id, qr_msg = msg, qr_sz = sz, qr_fcol = fcol, qr_bcol = bcol, qr_reurl = reurl;
                let qr_id = id, qr_sz = sz, qr_fcol = fcol, qr_bcol = bcol, qr_reurl = reurl;

                //Get element IDs
                qr_rid = document.getElementById('rid');
                //qr_message = document.getElementById('message');
                qr_size = document.getElementById('size');
                qr_fcolor = document.getElementById('fcolor');
                qr_bcolor = document.getElementById('bcolor');
                qr_rurl = document.getElementById('rurl');

                //Add values to form inputs using IDs
                qr_rid.value = qr_id;
                //qr_message.value = qr_msg;
                qr_size.value = qr_sz;
                qr_size.innerHTML = qr_sz;
                qr_rurl.value = qr_reurl;

                //Convert RGB colours to Hexadecimal codes
                function rgbToHex(val){
                    v = val.split(", ");
                    hex1 = parseInt(v[0]);
                    hex2 = parseInt(v[1]);
                    hex3 = parseInt(v[2]);
                    return '#' + (1 << 24 | hex1 << 16 | hex2 << 8 | hex3).toString(16).slice(1);
                }
                new_fcol = rgbToHex(qr_fcol);
                new_bcol = rgbToHex(qr_bcol);

                qr_fcolor.value = new_fcol;
                qr_bcolor.value = new_bcol;

                
            }


        </script>
        </form>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<!-- DELETE --> 
<div class="modal fade" tabindex="-1" role="dialog" id="delete">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header bg-danger">
            <h5 class="modal-title text-white">Permanently Delete a QR Code</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-black bg-light">

            <h4 style="font-weight: 700;">Are you sure you wish to delete this QR Code permanently?</h4>
            <form action="{{ route('delete.qrcode') }}" method="post" id="form_contents">
                {{ csrf_field() }}
                <input type="hidden" name="rid" id="ridd" />
        </div>
        <div class="modal-footer justify-content-evenly">
            <button type="submit" class="btn btn-danger">
                 <i class="fa fa-trash fa-lg"></i> &nbsp; Permanently Delete
            </button>
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">
                <i class="fa fa-times fa-lg"></i> &nbsp; Cancel
            </button>
        </div>
        <script>
            function deleteQR(idd){
                //Set Vars
                let qr_idd = idd;

                //Get element IDs
                qr_ridd = document.getElementById('ridd');

                //Add values to form inputs using IDs
                qr_ridd.value = qr_idd;
            }
        </script>
        </form>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $(".nav-link").removeClass("active");
        $('#home').addClass('active');
    });
</script>

@endsection
