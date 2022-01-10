<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Video Converter</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <style>
        body {background-image: url({{asset('images/background-image.jpg')}}); background-repeat: no-repeat; background-size: cover}
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2>Video Converter</h2>
                    </div>
                    <div class="card-body">
                        @if(session('gThumbnail'))
                            <a href="{{session('gThumbnail')}}"><button class="btn btn-success col-12 mb-3">Download Thumbnail</button></a>
                        @endif
                        @if(session('cRes'))
                                <a href="{{session('cRes')}}"><button class="btn btn-success col-12 mb-3">Download Resolution</button></a>
                        @endif
                        @if(session('cFormat'))
                                <a href="{{session('cFormat')}}"><button class="btn btn-success col-12 mb-3">Download Format</button></a>
                        @endif
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Converter Resolution</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Converter Format</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Get Thumbnail</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <!-- Converter Resolution -->
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                <form action="{{route('upload')}}" method="post" enctype="multipart/form-data" class="form-control">
                                    @csrf
                                    <input type="hidden" name="type" id="type" value="cRes">
                                    <div class="form-group mt-1">
                                        <label for="video">Select File: </label>
                                        <input type="file" name="video" id="video" accept="video/*" class="input-group@error('video') is-invalid@enderror">
                                        @error('video')
                                        <span class="text-danger">
                                            {{$message}}
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="res">New Converter Resolution Size: </label>
                                        <input type="text" name="res_size" id="res_size" required class="input-group-sm" required>
                                    </div>

                                    <button type="submit" class="btn btn-warning col-12 mt-2">Upload & Process</button>
                                </form>
                            </div>

                            <!-- Converter Format -->
                            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                <form action="{{route('upload')}}" method="post" enctype="multipart/form-data" class="form-control">
                                    @csrf
                                    <input type="hidden" name="type" id="type" value="cFormat">
                                    <div class="form-group mt-1">
                                        <label for="video">Select File: </label>
                                        <input type="file" name="video" id="video" accept="video/*" class="input-group@error('video') is-invalid@enderror">
                                        @error('video')
                                        <span class="text-danger">
                                            {{$message}}
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group mt-2">
                                        Formation: <span class="text-danger">mp3, mp4, avi, wmv</span>
                                        <br/>
                                        <label for="res">New Converter Format Type: </label>
                                        <input type="text" name="format_type" id="format_type" required class="input-group-sm mt-1" required>

                                    </div>

                                    <button type="submit" class="btn btn-outline-success col-12 mt-2">Upload & Process</button>
                                </form>
                            </div>

                            <!-- Get Thumbnail -->
                            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                                <form action="{{route('upload')}}" method="post" enctype="multipart/form-data" class="form-control">
                                    @csrf
                                    <input type="hidden" name="type" id="type" value="gThumbnail">
                                    <div class="form-group mt-1">
                                        <label for="video">Select File: </label>
                                        <input type="file" name="video" id="video" accept="video/*" class="input-group@error('video') is-invalid@enderror">
                                        @error('video')
                                        <span class="text-danger">
                                            {{$message}}
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="res">New Thumbnail Second: </label>
                                        <input type="number" name="thumbnail_second" id="thumbnail_second" required class="input-group-sm" required>

                                    </div>

                                    <button type="submit" class="btn btn-outline-info col-12 mt-2">Upload & Process</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="{{asset('js/app.js')}}"></script>
</body>
</html>
