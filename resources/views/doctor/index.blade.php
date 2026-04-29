@extends('layouts.adminlte4')
@section('title', 'Doctors')
@section('sidebar-doctors', 'active')

@section('content')
<div class="container">
  <h2>Doctors</h2>

  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Specialization</th>
        <th>Experience</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($doctors as $d)
      <tr>
        <td>{{ $d->id }}</td>
        <td>{{ $d->user->name }}</td>
        <td>{{ $d->specialization->name }}</td>
        <td>{{ $d->experience_years }} years</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection