@extends('layouts.admin')
@push('title', get_phrase('Manage Project'))
@push('meta')@endpush
@push('css')@endpush

@section('content')
    <!-- Start Admin area -->
    <div class="row">
        <div class="col-12">
            @if ($layout == 'grid')
                @include('projects.grid')
            @else
                @include('projects.list')
            @endif
        </div>
    </div>
    <!-- End Admin area -->
@endsection
