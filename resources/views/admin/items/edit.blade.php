@extends('layouts.admin', ['heading' => 'Edit Item', 'breadcrumb' => 'Edit Item'])

@section('content')
<div class="admin-panel p-4">
    <form method="POST" action="{{ route('admin.items.update', $item) }}" enctype="multipart/form-data">
        @include('admin.items._form', ['method' => 'PATCH'])
    </form>
</div>
@endsection
