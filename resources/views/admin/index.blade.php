
@extends('layout.lyt_admin')

@section('title', 'Administrador') <!--title page-->

@section('content')
    <h1>Hello Admin!</h1>
    <br>
    <table class="table table-bordered" id="ingredientes-table">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
            </tr>
        </thead>
    </table>
    <br>
    <table class="table table-bordered" id="platillos-table">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
            </tr>
        </thead>
    </table>
    <br>
    <table class="table table-bordered" id="clasificaciones-table">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Visible</th>
            </tr>
        </thead>
    </table>
@endsection

@push('scripts')
<script>
    // datatable #1
    $(function() {
        $('#ingredientes-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('datatable.ingredientes') !!}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'nombre', name: 'nombre' }
            ]
        });
    });
    // datatable #2
    $(function() {
        $('#platillos-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('datatable.platillos') !!}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'nombre', name: 'nombre' }
            ]
        });
    });
    // datatable #2
    $(function() {
        $('#clasificaciones-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('datatable.clasificaciones') !!}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'nombre', name: 'nombre' },
                { data: 'tipo', name: 'tipo' },
                { data: 'visible', name: 'visible' }
            ]
        });
    });
</script>
@endpush