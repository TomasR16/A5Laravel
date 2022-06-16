<!-- Verleging van layouts/app.blade/php -->
@extends('layouts.app')
<!-- Begin van inhoud -->
@section('content')

<div class="col-sm-12">

    @if(session()->get('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
    @endif
</div>

<div>
    <a style="margin: 19px;" href="{{ route('companies.create')}}" class="btn btn-primary">Bedrijf toevoegen</a>
</div>

<!-- Begin Search -->
<div class="row">
    {!! Form::open(['method'=>'GET','url'=>'/companies/','class'=>'navbar-form navbar-left','role'=>'search']) !!}
    <div class="input-group custom-search-form">
        <input type="text" class="form-control" name="keyword" placeholder="Zoek...">
        <span class="input-group-btn">
            <button class="btn btn-default-sm" type="submit">
                <i class="fa fa-search"><span class="glyphicon glyphicon-search" />
            </button>
        </span>
    </div>
    {!! Form::close() !!}
</div>
<!-- END Search -->

<div class="row">
    <div class="col-sm-12">
        <h1 class="display-3">Bedrijven</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Naam</td>
                    <td colspan=2>Actions</td>
                </tr>
            </thead>
            <tbody>
                @foreach($companies as $company)
                <tr>
                    <td>{{$company->id}}</td>
                    <td>{{$company->name}}</td>
                    <td>
                        <a href="{{ route('companies.edit',$company->id)}}" class="btn btn-primary">Aanpassen</a>
                    </td>
                    <td>
                        <form action="{{ route('companies.destroy', $company->id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">Verwijderen</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection