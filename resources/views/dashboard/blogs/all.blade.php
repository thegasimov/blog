@extends('layouts.app')

@section('content')
    <main class="content">
        <div class="container-fluid">
            <div class="header d-flex justify-content-between align-items-center">
                <h1 class="header-title">
                    <i class="fas fa-blog me-2"></i> Bütün Bloqlar
                </h1>
                <a href="{{ route('blogs.create') }}" class="btn btn-success">
                    <i class="fas fa-plus-circle me-2"></i> Yeni Bloq Əlavə Et
                </a>
            </div>

            <div class="row">
                <div class="col-12 d-flex">
                    <div class="card flex-fill w-100">
                        <div class="col-12 mb-3">
                            <form action="" class="form-horizontal p-3 border rounded bg-light">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="q" placeholder="Axtar">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search me-1"></i> Axtar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="table-responsive">
                            <table id="listTable" class="table table-striped" style="width:100%">
                                <thead>
                                <tr>
                                    <th><i class="fas fa-heading me-1"></i> Başlıq</th>
                                    <th><i class="fas fa-image me-1"></i> Ön Şəkil</th>
                                    <th><i class="fas fa-list me-1"></i> Kateqoriya</th>
                                    <th><i class="fas fa-clock me-1"></i> Status</th>
                                    <th><i class="fas fa-language me-1"></i> Dillər</th>
                                    <th class="text-end"><i class="fas fa-cogs me-1"></i> Əməliyyat</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($blogs as $blog)
                                    <tr>
                                        <td>{{ $blog->contentsAZ->name ?? 'Başlıq yoxdur' }}</td>
                                        <td>
                                            @if($blog->featured_image)
                                                <img src="{{ asset('storage/'.$blog->featured_image) }}" width="150" alt="Ön Şəkil"/>
                                            @else
                                                <i class="fas fa-image fa-2x text-muted"></i>
                                            @endif
                                        </td>
                                        <td>{{ $blog->category->name ?? 'Kateqoriya yoxdur' }}</td>
                                        <td>{{ $blog->status === 'draft' ? 'Qaralama' :  date('d.m.Y', strtotime($blog->published_at)) }}</td>
                                        <td>
                                            {!! $blog->contentsAZ ? '<span class="badge bg-success">AZ</span> ' : '' !!}
                                            {!! $blog->contentsEN ? '<span class="badge bg-info">EN</span> ' : '' !!}
                                            {!! $blog->contentsRU ? '<span class="badge bg-danger">RU</span>' : '' !!}
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('blogs.show', $blog->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i> Gör
                                            </a>
                                            <a href="{{ route('blogs.edit', $blog->id) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i> Dəyiş
                                            </a>
                                            <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bu bloqu silmək istədiyinizə əminsiniz? Bu əməliyyat GERİ QAYTARILMAYACAQ!')">
                                                    <i class="fas fa-trash"></i> Sil
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            @if(isset($_GET['q']))
                                                <a href="{{ route('blogs.index') }}">Bütün bloqları göstər</a>
                                            @else
                                                Göstəriləcək məlumat yoxdur.
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{ $blogs->appends(request()->input())->links('vendor.pagination.default') }}
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
