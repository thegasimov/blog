@extends('layouts.app')

@section('content')
    <main class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-user me-2"></i> {{ $costumer->full_name }}
                            <div class="card-actions float-end">
                                <div class="d-inline-block dropdown show">
                                    <a href="#" data-bs-toggle="dropdown" data-bs-display="static">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical align-middle">
                                            <circle cx="12" cy="12" r="1"></circle>
                                            <circle cx="12" cy="5" r="1"></circle>
                                            <circle cx="12" cy="19" r="1"></circle>
                                        </svg>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="{{ route('costumers.edit', $costumer->id) }}">
                                            <i class="fas fa-edit me-1"></i> Dəyiş
                                        </a>
                                        <form action="{{ route('costumers.destroy', $costumer->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item" onclick="return confirm('Bu müştərini silmək istədiyinizə əminsiniz? Əgər bu müştəri silinərsə ona aid bütün məlumatlar silinəcək. GERİ QAYTARMAQ MÜMKÜN DEYİL!')">
                                                <i class="fas fa-trash-alt me-1"></i> Sil
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th style="width: 200px;"><i class="fas fa-id-badge me-2"></i>Tam ad</th>
                                    <td>{{ $costumer->full_name }}</td>
                                </tr>
                                <tr>
                                    <th><i class="fas fa-car me-2"></i>Maşın</th>
                                    <td>
                                        @if($costumer->rentalCar)
                                        <a href="{{ route('cars.show',$costumer->rentalCar->id) }}">
                                        {{ $costumer->rentalCar->model->BrandOfModel->name }}
                                        {{ $costumer->rentalCar->model->name }}
                                        {{ trans('cars.carBody.'.$costumer->rentalCar->carBody) }}
                                        {{ $costumer->rentalCar->year }}
                                       {{ $costumer->rentalCar->color->name }} <span class="btn btn-outline-primary">{{ $costumer->rentalCar->license }}</span></a>
                                        @else
                                            <span class="btn btn-warning w-100">Bu müştərinin icarəyə götürdüyü aktiv maşın yoxdur.</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th><i class="fas fa-calendar-day me-2"></i>Götürdüyü gün</th>
                                    <td>{{ date('d-m-Y',strtotime($costumer->rental_day)) }}</td>
                                </tr>
                                <tr>
                                    <th><i class="fas fa-calendar-check me-2"></i>Qaytaracağı gün</th>
                                    <td>{{ date('d-m-Y',strtotime($costumer->returned_day)) }}</td>
                                </tr>
                                <tr>
                                    <th><i class="fas fa-money-bill-wave me-2"></i>Ödəniş məbləği</th>
                                    <td>{{ $costumer->amount  }}</td>
                                </tr>
                                <tr>
                                    <th><i class="fas fa-phone me-2"></i>Əlaqə</th>
                                    <td>{{ $costumer->contact  }}</td>
                                </tr>
                                <tr>
                                    <th><i class="fas fa-envelope me-2"></i>Email</th>
                                    <td>{{ $costumer->email  }}</td>
                                </tr>

                                <tr>
                                    <th><i class="fas fa-timeline me-2"></i>Status</th>
                                    <td>{!! $costumer->status === 'pending' ? '<span class="btn btn-pill btn-primary">Gözləmədə</span>' : '<span class="btn btn-pill btn-success">Təsdiqlənib</span>' !!} </td>
                                </tr>

                                <tr>
                                    <th><i class="fas fa-images me-2"></i>Sürücülük Vəsiqəsi Şəkilləri</th>
                                    <td>
                                        <div class="row">
                                            @php
                                                $drivingLicense = $costumer->driving_license;
                                                $images = is_string($drivingLicense) ? json_decode($drivingLicense, true)['images'] : $drivingLicense['images'] ?? [];
                                            @endphp
                                            @if(!empty($images))
                                                @foreach($images as $image)
                                                    <div class="col-md-3 mb-2">
                                                        <img src="{{ asset('storage/'.$image) }}" class="img-fluid">
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
