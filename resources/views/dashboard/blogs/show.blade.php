@extends('layouts.app')

@section('content')
    <main class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                           <h1> <i class="fas fa-blog me-2"></i> {{ $blog->name }}</h1>
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
                                        <a class="dropdown-item" href="{{ route('blogs.edit', $blog->id) }}">
                                            <i class="fas fa-edit me-1"></i> Dəyiş
                                        </a>
                                        <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item" onclick="return confirm('Bu bloqu silmək istədiyinizə əminsiniz? Əgər bu bloq silinərsə ona aid bütün məlumatlar silinəcək. GERİ QAYTARMAQ MÜMKÜN DEYİL!')">
                                                <i class="fas fa-trash-alt me-1"></i> Sil
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                                {!! $blog->content !!}
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    Paylaşılıb: {{ date('d-m-Y',strtotime($blog->created_at)) }}
                                </div>
                                <div class="col-6">
                                    Yenilənib: {{ date('d-m-Y',strtotime($blog->updated_at)) }}
                                </div>
                            </div>
<hr>
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                <img src="{{ asset('storage/'.$blog->featured_image) }}" class="img-fluid">
                                            </div>
                                            @if(!empty($blog->images))
                                                @foreach($blog->images as $image)
                                                    <div class="col-md-3 mb-2">
                                                        <img src="{{ asset('storage/'.$image->image_file) }}" class="img-fluid">
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
