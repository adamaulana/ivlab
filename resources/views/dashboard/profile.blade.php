@section('title-page')
    Profil BUMDes
@endsection
@section('css')
    <style>
        .modal-dialog{
            max-width:75%;
        }

        #map-area{
            min-height:400px;
            background-color::#fafafa;
        }

        @media only screen and (max-width:720px){
            .modal-dialog{
                max-width:100%;
            }         
        }
    </style>
@endsection
@extends('dashboard_template/index')
@section('content')
<div class="container-fluid">            
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">                    
                    @foreach($bumdes as $data)
                    <table class="table">
                        <tr>
                            <td><strong>Nama Bumdes</strong></td>
                            <td class="colon"><strong>:</strong></td>
                            <td class="nunito">{{$data->nama_bumdes}}</td>
                        </tr>
                        <tr>
                            <td><strong>Kelurahan / Desa</strong></td>
                            <td class="colon"><strong>:</strong></td>
                            <td class="nunito">{{$data->desa}}</td>
                        </tr>                        
                        <tr>
                            <td><strong>Kecamatan</strong></td>
                            <td class="colon"><strong>:</strong></td>
                            <td class="nunito">{{$data->kecamatan == NULL ? '-' : $data->nama_kecamatan}}</td>
                        </tr>                      
                        <tr>
                            <td><strong>Kabupaten / Kota</strong></td>
                            <td class="colon"><strong>:</strong></td>
                            <td class="nunito">{{$data->kabupaten == NULL ? '-' : $data->nama_kabupaten}}</td>
                        </tr>
                        <tr>
                            <td><strong>Provinsi</strong></td>
                            <td class="colon"><strong>:</strong></td>
                            <td class="nunito">{{$data->provinsi == NULL ? '-' : $data->nama_provinsi}}</td>
                        </tr>                                                
                        <tr>
                            <td><strong>Status</strong></td>
                            <td class="colon"><strong>:</strong></td>
                            <td class="nunito"><span class="badge bg-success"> Aktif</span></td>
                        </tr>                      

                        <tr>
                            <td><strong>Email</strong></td>
                            <td class="colon"><strong>:</strong></td>
                            <td class="nunito">{{$data->email}}</td>
                        </tr>                      

                        <tr>
                            <td><strong>Lokasi</strong></td>
                            <td class="colon"><strong>:</strong></td>
                            <td class="nunito">-</td>
                        </tr>                 
                        <tr>
                            <td colspan="3"></td>
                        </tr>     

                    </table>
                    <button data-bs-toggle="modal" data-bs-target="#modalEditBio" class="btn btn-warning"><i class="mdi mdi-pencil"></i>Perbarui Profil</button>
                    @endforeach

                    
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    @foreach($bumdes as $data)
                        @if($data->pp != NULL)
                            <center><img src="{{asset('profil_bumdes/'.$data->pp)}}" alt="" style="width:80%"></center>
                            <br>
                        @else
                            <img src="{{asset('assets/images/noimage.png')}}" alt="" class="w-100">
                        @endif
                    @endforeach
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditFoto"><i class="mdi mdi--lead-pencil"></i>Edit Foto</button>
                </div>
            </div>
            
        </div>
    </div>
</div>


<!-- modal edit bio -->
<!-- Modal -->
<div class="modal fade" id="modalEditBio" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Edit Profil BUMDes</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{url('/updateBumdes')}}" method="post">
      {{csrf_field()}}
      <div class="modal-body">
        <div class="row p-3">
            @foreach($bumdes as $data)
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input required="required" type="email" name="email" value="{{$data->email}}" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                </div>
                <div class="mb-3">
                    <label for="nama_bumdes" class="form-label">Nama BUMDes</label>
                    <input required="required" type="text" name="nama_bumdes" value="{{$data->nama_bumdes}}" class="form-control" id="nama_bumder" placeholder="Sambisirah Makmur">
                </div>
                <div class="mb-3">
                    <label class="form-label">Desa</label>
                    <input required="required" type="text" name="desa"  class="form-control"  value="{{$data->desa}}">
                </div>                
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="provinsi" class="form-label">Provinsi</label>
                    <select required="required" name="provinsi" id="provinsi" class="form-control">
                        @foreach($prov as $provinsi)
                        <option value="{{$provinsi->id}}">{{$provinsi->nama}}</option>
                        @endforeach
                    </select>
                </div>       
                <div class="mb-3">
                    <label for="kabupaten" class="form-label">Kabupaten</label>
                    <select required="required" name="kabupaten" id="kabupaten" class="form-control">
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                    </select>
                </div>       
                <div class="mb-3">
                    <label for="kecamatan" class="form-label">Kecamatan</label>
                    <select name="kecamatan" required="required" id="kecamatan" class="form-control">
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                    </select>
                </div>                                
            </div>

            <!-- <div class="col-md-12">
                <label for="password" class="form-label">Lokasi ( Masukkan Lokasi Anda )</label>
                <input required type="text" class="form-control" id="pac-input">
                <input type="text" name="lat" id="lat">
                <input type="text" name="long" id="long">
                <div class="map-area row" id="map-area" ></div>
            </div> -->
            @endforeach
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan Data</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Addd Foto-->
<div class="modal fade" id="modalEditFoto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Edit Profil BUMDes</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{url('/updateFotoBumdes')}}" method="post" enctype="multipart/form-data">
      {{csrf_field()}}
      <div class="modal-body">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">            
            @foreach($bumdes as $data)
            @if($data->pp == NULL)
            <center><img src="{{asset('assets/images/noimage.png')}}" style="width:80%" alt="" id="img-prev"></center>
            @else
            <center><img src="{{asset('profil_bumdes/'.$data->pp)}}" style="width:80%" alt="" id="img-prev"></center>
            @endif
            @endforeach
            <br>
            <label for="fotoproduk">Foto Profil</label>
            <input required="required" type="file" name="foto_profil" id="fotoproduk" class="form-control">
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan Data</button>
      </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('js')
<script src="{{asset('assets/js/custom.js')}}"></script>
<script>        
        $(function(){
            
            $("#fotoproduk").change(function(){
                readURL(this,'#img-prev');
            });

            $("#provinsi").change(function(){
                var id = $(this).val();
                $.get('https://desa-pintar.id/ivlab/public/api/getKabupaten/'+id, function(data,status){
                    $("#kabupaten").html('<option value="" selected>--Pilih Kabupaten--</option>');                    
                    // generate option dari json
                    for (var i=0; i < data.length; i++) {
                        $("#kabupaten").append("<option value='"+data[i].id+"'>"+data[i].nama+"</option>");
                    }
                });
            });

            $("#kabupaten").change(function(){
                var id = $(this).val();
                $.get('https://desa-pintar.id/ivlab/public/api/getKecamatan/'+id, function(data,status){
                    $("#kecamatan").html('<option value="" selected>--Pilih Kecamatan--</option>');                    
                    // generate option dari json
                    for (var i=0; i < data.length; i++) {
                        $("#kecamatan").append("<option value='"+data[i].id+"'>"+data[i].nama+"</option>");
                    }
                });
            });



        });
</script>
    <script>  
    function initMap(){
            var map = new google.maps.Map(document.getElementById('map-area'), {
                zoom: 10,
                center: new google.maps.LatLng(-7.791981, 110.36948959999995),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            var bounds = new google.maps.LatLngBounds();
            var infowindow = new google.maps.InfoWindow();
            var marker, i;


            var card = document.getElementById('pac-card');
            var input = document.getElementById('pac-input');
            var types = document.getElementById('type-selector');
            var strictBounds = document.getElementById('strict-bounds-selector');

            var autocomplete = new google.maps.places.Autocomplete(input);

            // Bind the map's bounds (viewport) property to the autocomplete object,
            // so that the autocomplete requests use the current map bounds for the
            // bounds option in the request.
            autocomplete.bindTo('bounds', map);



            autocomplete.addListener('place_changed', function() {

                var infowindow = new google.maps.InfoWindow();
                var infowindowContent = document.getElementById('infowindow-content');
                infowindow.setContent(infowindowContent);
                var marker = new google.maps.Marker({        
                    map: map,
                    anchorPoint: new google.maps.Point(0, -29)
                });

                

                marker.setVisible(true);
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                // User entered the name of a Place that was not suggested and
                // pressed the Enter key, or the Place Details request failed.
                window.alert("No details available for input: '" + place.name + "'");
                return;
                }

                mylat = place.geometry.location.lat();
                mylong = place.geometry.location.lng();
                $("#lat").val(mylat);
                $("#long").val(mylong);

                // If the place has a geometry, then present it on a map.
                if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
                } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);  // Why 17? Because it looks good.
                }
                marker.setPosition(place.geometry.location);
                marker.setVisible(true);


                var address = '';
                if (place.address_components) {
                address = [
                    (place.address_components[0] && place.address_components[0].short_name || ''),
                    (place.address_components[1] && place.address_components[1].short_name || ''),
                    (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
                }

                infowindowContent.children['place-icon'].src = place.icon;
                infowindowContent.children['place-name'].textContent = place.name;
                infowindowContent.children['place-address'].textContent = address;
                infowindow.open(map, marker);
            });




    }
    </script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBe-qaQX8HId_x223Rd74bNlpTVyg6k3AY&libraries=places&callback=initMap"
  async defer></script>    
@endsection