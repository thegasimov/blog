@extends('layouts.app')

@section('content')
    <main class="content">
        <div class="container-fluid">
            <div class="header">
                <h1 class="header-title">
                    <i class="fas fa-plus-circle me-2"></i> Yeni müştəri əlavə Et
                </h1>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('costumers.store') }}" method="POST" enctype="multipart/form-data" id="createForm">
                                @csrf
                                @if($errors->any())
                                    <div class="mb-3">
                                        @foreach($errors->all() as $error)
                                            <div class="alert alert-danger">
                                                - {{ $error }}
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <label for="driving_license" class="form-label">Sürücülük vəsiqəsi *</label>
                                    <input type="file" class="form-control @error('driving_license') is-invalid @enderror" id="driving_license" name="images[]" accept="image/*" multiple required>
                                    @error('driving_license')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div id="multiple_images_preview" class="mt-2 d-flex flex-wrap sortable"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="full_name" class="form-label">Tam Ad *</label>
                                    <input type="text" value="{{ old('full_name') }}" placeholder="Ad, Soyad, Ata adı" class="form-control @error('full_name') is-invalid @enderror" id="full_name" name="full_name" required>
                                    @error('full_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="car_id" class="form-label">Maşın *</label>
                                    <select class="form-control @error('car_id') is-invalid @enderror" id="car_id" name="car_id" required>
                                        @foreach($cars as $car)
                                            <option value="{{ $car->id }}">{{ $car->model->BrandOfModel->name . ' ' . $car->model->name .' '. trans('cars.carBody.'.$car->carBody) }} {{ $car->year }} {{ $car->color->name }} | {{ $car->license }}</option>
                                        @endforeach
                                    </select>
                                    @error('car_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="rental_day" class="form-label">İcarəyə götürdüyü gün *</label>
                                    <input type="date" value="{{ old('rental_day',date('Y-m-d')) }}" class="form-control @error('rental_day') is-invalid @enderror" id="rental_day" name="rental_day" required>
                                    @error('rental_day')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="returned_day" class="form-label">Qaytarma günü *</label>
                                    <input type="date" value="{{ old('returned_day') }}" class="form-control @error('returned_day') is-invalid @enderror" id="returned_day" name="returned_day" required>
                                    @error('returned_day')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="amount" class="form-label">Məbləğ *</label>
                                    <input type="number" placeholder="Ödəniş məbləği" step="0.01" value="{{ old('amount') }}" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" required>
                                    @error('amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="contact" class="form-label">Telefon: *</label>
                                    <input type="text" value="{{ old('contact') }}" placeholder="Əlaqə nömrəsi" class="form-control @error('contact') is-invalid @enderror" id="contact" name="contact" required>
                                    @error('contact')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" placeholder="E-mail ünvanı" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Status *</label>
                                    <select class="form-control" name="status">
                                        <option value="confirmed" @selected(old('status') === 'confirmed')>Aktiv</option>
                                        <option value="pending" @selected(old('status') === 'pending')>Gözləmədə</option>
                                    </select>

                                    @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-success">Yarat</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('js')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script>
        $(document).ready(function () {
            // Multiple images preview
            $('#driving_license').on('change', function (event) {
                var files = event.target.files;
                $('#multiple_images_preview').html('');
                for (var i = 0; i < files.length; i++) {
                    var file = files[i];
                    if (file) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            var imageHtml = '<div class="p-2 position-relative"><img src="' + e.target.result + '" class="img-fluid sortable-image" style="max-width: 100px; height: auto;"><button type="button" class="btn btn-danger btn-sm position-absolute top-0 start-0" onclick="removeImage(this)">X</button></div>';
                            $('#multiple_images_preview').append(imageHtml);
                        }
                        reader.readAsDataURL(file);
                    }
                }
            });

            // Function to remove an image
            window.removeImage = function(button) {
                $(button).closest('div').remove();
                updateInputFiles();
            };

            // Function to update the input files
            function updateInputFiles() {
                var input = document.getElementById('driving_license');
                var files = input.files;
                var dataTransfer = new DataTransfer();
                $('#multiple_images_preview img').each(function(index, img) {
                    var fileIndex = $(img).data('file-index');
                    dataTransfer.items.add(files[fileIndex]);
                });
                input.files = dataTransfer.files;
            }
        });
    </script>
@endpush
