@extends('layouts.adminlte4')
@section('content')
<!-- fill with your page bar like previous week HERE !-->
<!-- end page bar !-->
<!-- END PAGE HEADER-->
<form method="POST" action="{{route('services.store')}}">
    <div class="container">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" aria-describedby="name" placeholder="Enter Service Name">
            <!-- <small id="name" class="form-text text-muted">Please write down Service Name here.</small>--><br> 
            <label for="category">Category</label>
            <select class="form-select" id="category_id" name="category_id" aria-describedby="name" required="">
                <option value="" selected="" disabled="">Choose a category...</option>
                @foreach ($categories as $category)
                <option value="{{$category->id}}">{{$category->category_name}}</option>
                @endforeach
            </select>
            <!-- <small id="name" class="form-text text-muted">Please select Service Category here.</small>--><br> 
            <label for="description">Description</label>
            <input type="text" class="form-control" id="description" name="description" aria-describedby="name" placeholder="Enter Description">
            <!-- <small id="name" class="form-text text-muted">Please write down Service Description here.</small>--><br>
            <label for="availability">Availability</label>
            <input type="text" class="form-control" id="availability" name="availability" aria-describedby="name" placeholder="Enter Availability">
            <!-- <small id="name" class="form-text text-muted">Please write down Service Availability here.</small>--><br>
            <label for="price">Price</label>
            <input type="number" class="form-control" id="price" name="price" aria-describedby="name" placeholder="Enter Price">
            <!-- <small id="name" class="form-text text-muted">Please write down Service Price here.</small>--><br><br> 
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
@endsection