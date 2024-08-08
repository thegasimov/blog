@extends('layouts.app')
@section('content')
    <main class="content">
        <div class="container-fluid">
            <div class="header d-flex justify-content-between align-items-center">
                <h1 class="header-title">
                    <i class="fas fa-user me-2"></i> Bütün müştərilər
                </h1>
                <a href="{{ route('costumers.create') }}" class="btn btn-success">
                    <i class="fas fa-plus-circle"></i> Yeni müştəri əlavə et
                </a>
            </div>

            <div class="row">
                <div class="col-12 d-flex">
                    <div class="card flex-fill w-100">
                        <div class="col-12">
                            <form action="" class="form-horizontal p-3 border rounded bg-light">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="q" placeholder="Axtar">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary">Axtar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if(isset($_GET['q']))
                            <a href="{{ route('costumers.index') }}" class="btn btn-success mb-3">Bütün müştəriləri göstər</a>
                        @endif
                        <table id="listTable" class="table table-striped" style="width:100%">
                            <thead>
                            <tr>
                                <th><i class="fas fa-user me-1"></i> Ad, Soyad, Ata</th>
                                <th><i class="fas fa-car me-1"></i> Maşın</th>
                                <th><i class="fas fa-calendar-alt me-1"></i> Götürdüyü gün</th>
                                <th><i class="fas fa-calendar-alt me-1"></i> Qaytaracağı gün</th>
                                <th><i class="fas fa-money-bill-wave me-1"></i> Ödədiyi məbləğ</th>
                                <th><i class="fas fa-phone me-1"></i> Əlaqə</th>
                                <th><i class="fas fa-timeline me-1"></i> Status</th>
                                <th class="text-end"><i class="fas fa-cogs me-1"></i> Əməliyyat</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($costumers as $costumer)
                                <tr>
                                    <td>{{ $costumer->full_name }}</td>
                                    <td>
                                        @if($costumer->rentalCar)
                                            {{ $costumer->rentalCar->model->BrandOfModel->name }}
                                            {{ $costumer->rentalCar->model->name }}
                                            <span class="btn btn-pill btn-dark">{{ $costumer->rentalCar->license }}</span>
                                        @else
                                            <span class="btn btn-pill btn-warning">Aktiv yoxdur</span>
                                        @endif

                                    </td>
                                    <td>{{ date('d-m-Y', strtotime($costumer->rental_day)) }}</td>
                                    <td>{{ date('d-m-Y', strtotime($costumer->returned_day)) }}</td>
                                    <td>{{ $costumer->amount }} AZN</td>
                                    <td>{{ $costumer->contact }}<br/>{{ $costumer->email }}</td>
                                    <td>{!! $costumer->status === 'pending' ? '<span class="btn btn-pill btn-primary">Gözləmədə</span>' : '<span class="btn btn-pill btn-success">Təsdiqlənib</span>' !!} </td>

                                    <td class="text-end">
                                        <a href="{{ route('costumers.show', $costumer->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i> Gör
                                        </a>
                                        <a href="{{ route('costumers.edit', $costumer->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Dəyiş
                                        </a>
                                        <form action="{{ route('costumers.destroy', $costumer->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="delete_type" value="hard">
                                            @if($costumer->rentalCar)<input type="hidden" name="carId" value="{{ $costumer->rentalCar->id }}" />@endif
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bu müştərini silmək istədiyinizə əminsiniz? Əgər bu müştəri silinərsə GERİ QAYTARMAQ MÜMKÜN DEYİL!')">
                                                <i class="fas fa-trash"></i> Sil
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">
                                        @if(isset($_GET['q']))
                                            <a href="{{ route('costumers.index') }}">Bütün müştəriləri göstər</a>
                                        @else
                                            Göstəriləcək məlumat yoxdur.
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
