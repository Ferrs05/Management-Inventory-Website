@extends('layouts.admin', ['heading' => 'Tambah Barang'])

@section('content')
<div class="admin-panel p-4">
    <form method="POST" action="{{ route('admin.items.store') }}" enctype="multipart/form-data">
        @include('admin.items._form')
    </form>
</div>
@endsection
