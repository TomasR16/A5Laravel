<!-- Extends de app.blade.php  -->
@extends('layouts.app')

@section('content')
<div class="col-sm-12">
    <!-- Laat bericht zien uit ContactController -->
    @if(session()->get('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
    @endif
</div>

<div>
    <!-- Als user op link klikt laat contacts create pagina zien -->
    <a style="margin: 19px;" href="{{ route('contacts.create')}}" class="btn btn-primary">Contact toevoegen</a>
</div>

<!-- Begin Search -->
<div class="row">
    {!! Form::open(['method'=>'GET','url'=>'/contacts/','class'=>'navbar-form navbar-left','role'=>'search']) !!}
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
        <h1 class="display-3">Contacten</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <td>Id</td>
                    <td>Naam</td>
                    <td>Bedrijf</td>
                    <td>Email</td>
                    <td>Functie</td>
                    <td>Woonplaats</td>
                    <td>Land</td>
                    <td colspan=2>Acties</td>
                </tr>
            </thead>
            <tbody>
                <!-- Laat alle contacten zien uit database -->
                @foreach($contacts as $contact)
                <tr>
                    <!-- Show contact information -->
                    <td>{{$contact->id}}</td>
                    <td>{{$contact->first_name}} {{$contact->last_name}}</td>
                    <td>{{$contact->company->name}}</td>
                    <td>{{$contact->email}}</td>
                    <td>{{$contact->job_title}}</td>
                    <td>{{$contact->city}}</td>
                    <td>{{$contact->country}}</td>
                    @auth
                    <td>
                        <!-- Als op link klikt ga naar contacts edit page geef contact->id mee als argument -->
                        <a href="{{ route('contacts.edit',$contact->id)}}" class="btn btn-primary">Aanpassen</a>
                    </td>
                    <td>
                        <!-- Als op delete klik roep contacts.destroy aan en geef contact->id mee als parameter -->
                        <form action="{{ route('contacts.destroy', $contact->id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">Verwijderen</button>
                        </form>
                    </td>
                    @endauth
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- <div> -->
    </div>
</div>
@endsection