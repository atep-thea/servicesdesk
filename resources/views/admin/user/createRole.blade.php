@section('user-link')class="active" @stop
@extends('layout.adminlte.app')

@section('htmlheader_title')
Peran
@endsection

@section('contentheader_title')
Peran
@endsection

@section('additional_styles')
@endsection

@section('additional_scripts')

@endsection

@section('main-content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Tambah Peran</h3>
                </div>

                <div class="box-body">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nama Peran</label>
                            <input class="form-control" type="text" name="name" value="{{ old('name') }}" required>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <label>Akses</label>
                        <table class="table table-hover table-stripped">
                            <thead>
                                <tr>
                                    <td></td>
                                    <td>Jenis</td>
                                    <td>Deskripsi</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="permission">
                                    </td>
                                    <td>Dashboard</td>
                                    <td>Melihat lihat</td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="permission">
                                    </td>
                                    <td>Dashboard</td>
                                    <td>Melihat lihat</td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="permission">
                                    </td>
                                    <td>Dashboard</td>
                                    <td>Melihat lihat</td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="permission">
                                    </td>
                                    <td>Dashboard</td>
                                    <td>Melihat lihat</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="box-footer with-border">
                    <button type="submit" name="button" class="btn btn-primary pull-right">Tambah</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
