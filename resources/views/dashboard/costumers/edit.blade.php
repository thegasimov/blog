@extends('layouts.app')

@section('content')
    <main class="content">
        <div class="container-fluid">
            <div class="header">
                <h1 class="header-title">
                    <i class="fas fa-edit me-2"></i> Müştərini Dəyiş
                </h1>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('costumers.update', $costumer->id) }}" method="POST"
                                  enctype="multipart/form-data" id="editForm">
                                @csrf
                                @method('PUT')
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
                                    <label for="images" class="form-label">Sürücülük vəsiqəsinin şəkilləri *</label>
                                    <input type="file" class="form-control @error('images') is-invalid @enderror" id="images" name="images[]" accept="image/*" multiple>
                                    @error('images')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div id="multiple_images_preview" class="mt-2 d-flex flex-wrap sortable"></div>
                                    <div class="row" id="existing-images">
                                        @php
                                            $drivingLicense = $costumer->driving_license;
                                            $images = is_string($drivingLicense) ? json_decode($drivingLicense, true)['images'] : $drivingLicense['images'] ?? [];
                                        @endphp
                                        @if(!empty($images))
                                            @foreach($images as $image)
                                                <div class="col-md-3 mb-2 image-container">
                                                    <input type="hidden" value="{{ $image }}" name="existing_images[]" />
                                                    <img src="{{ asset('storage/'.$image) }}" class="img-fluid">
                                                    <button type="button" class="btn btn-danger btn-sm mt-2 remove-image-button">Sil</button>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="full_name" class="form-label">Tam Ad *</label>
                                    <input type="text" value="{{ old('full_name',$costumer->full_name) }}" placeholder="Ad, Soyad, Ata adı" class="form-control @error('full_name') is-invalid @enderror" id="full_name" name="full_name" required>
                                    @error('full_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="car_id" class="form-label">Maşın</label>
                                    @if($costumer->car_id)
                                        <select class="form-control @error('car_id') is-invalid @enderror" id="car_id" name="car_id" required>
                                            <option value="{{ $costumer->car_id }}">{{ $costumer->rentalCar->model->BrandOfModel->name }}
                                                {{ $costumer->rentalCar->model->name }}
                                                {{ trans('cars.carBody.'.$costumer->rentalCar->carBody) }}
                                                {{ $costumer->rentalCar->year }}
                                                {{ $costumer->rentalCar->color->name }} | {{ $costumer->rentalCar->license }}</option>
                                            @foreach($cars as $car)
                                                <option value="{{ $car->id }}">{{ $car->model->BrandOfModel->name . ' ' . $car->model->name .' '. trans('cars.carBody.'.$car->carBody) }} {{ $car->year }} {{ $car->color->name }} | {{ $car->license }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <span class="btn btn-warning w-100">Bu müştərinin icarəyə götürdüyü aktiv maşın yoxdur.</span>
                                        <select class="form-control @error('car_id') is-invalid @enderror" id="car_id" name="car_id">
                                            <option value="" selected>Maşın əlavə et</option>
                                            @foreach($cars as $car)
                                                <option value="{{ $car->id }}">{{ $car->model->BrandOfModel->name . ' ' . $car->model->name .' '. trans('cars.carBody.'.$car->carBody) }} {{ $car->year }} {{ $car->color->name }} | {{ $car->license }}</option>
                                            @endforeach
                                        </select>
                                    @endif

                                    @error('car_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="rental_day" class="form-label">İcarəyə götürdüyü gün *</label>
                                    <input type="date" value="{{ old('rental_day',$costumer->rental_day) }}" class="form-control @error('rental_day') is-invalid @enderror" id="rental_day" name="rental_day" required>
                                    @error('rental_day')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="returned_day" class="form-label">Qaytarma günü *</label>
                                    <input type="date" value="{{ old('returned_day',$costumer->returned_day) }}" class="form-control @error('returned_day') is-invalid @enderror" id="returned_day" name="returned_day" required>
                                    @error('returned_day')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="amount" class="form-label">Məbləğ *</label>
                                    <input type="number" placeholder="Ödəniş məbləği" step="0.01" value="{{ old('amount',$costumer->amount) }}" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" required>
                                    @error('amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="contact" class="form-label">Telefon: *</label>
                                    <input type="text" value="{{ old('contact',$costumer->contact) }}" placeholder="Əlaqə nömrəsi" class="form-control @error('contact') is-invalid @enderror" id="contact" name="contact" required>
                                    @error('contact')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" placeholder="E-mail ünvanı" value="{{ old('email',$costumer->email) }}" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Status *</label>
                                    <select class="form-control" name="status">
                                        <option value="pending" @selected($costumer->status === 'pending')>Gözləmədə</option>
                                        <option value="confirmed" @selected($costumer->status === 'confirmed')>Təsdiqləmək</option>
                                    </select>

                                    @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn w-100 btn-success">Yenilə</button>


                            </form>
                            @if($costumer->status === 'pending')
                                <form action="{{ route('costumers.destroy', $costumer->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="delete_type" value="soft">
                                    @if($costumer->rentalCar)<input type="hidden" name="carId" value="{{ $costumer->rentalCar->id }}" /> @endif
                                    <button type="submit" class="btn btn-danger mt-5 w-100" onclick="return confirm('Bu sifarişi ləğv etmək istədiyinizə əminsiniz? Əgər ləğv edilərsə seçim etdiyi maşın yenidən icarəyə çıxacaq.')">
                                        <i class="fas fa-trash"></i> Ləğv et
                                    </button>
                                </form>

                            @else
                                <form method="post" action="{{ route('changeStatusToForRent') }}">
                                    @csrf
                                    <input type="hidden" name="carId" value="{{ $costumer->car_id }}" />
                                    <input type="hidden" name="costumer_id" value="{{ $costumer->id}}" />
                                    <input type="hidden" name="rent_start_day" value="{{ $costumer->rental_day }}" />
                                    <input type="hidden" name="rent_end_day" value="{{ $costumer->returned_day }}" />
                                    <button type="submit" class="btn btn-primary w-100 mt-5 " onclick="return confirm('Sadəcə icarələdiyi maşını geri qaytardığı halda əməliyyatı aparın. Bu əməliyyat maşını yenidən icarəyə hazır vəziyyətə gətirəcək')">Maşını qaytardı olaraq işarələ</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('js')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#images').on('change', function (event) {
                var files = event.target.files;
                $('#multiple_images_preview').html('');
                for (var i = 0; i < files.length; i++) {
                    var file = files[i];
                    if (file) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $('#multiple_images_preview').append('<div class="p-2 position-relative"><img src="' + e.target.result + '" class="img-fluid sortable-image" style="max-width: 100px; height: auto;"><button type="button" class="btn btn-danger btn-sm position-absolute top-0 start-0" onclick="removeImageWhenUpdate(this)">X</button></div>');
                        }
                        reader.readAsDataURL(file);
                    }
                }
            });


        });

        function removeImageWhenUpdate(button) {
            $(button).closest('div').remove();
        }


        $(document).ready(function () {
            $('.remove-image-button').on('click', function () {
                $(this).closest('.image-container').remove();
            });
        });

    </script>
@endpush
