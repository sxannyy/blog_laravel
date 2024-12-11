@extends('layout')

@section('title', "Form")

@section('content')

@if (session('message'))
<div class="success-message">
    {{ session('message') }}
</div>
@endif

<form method="post" action="/users" class="user-form">
    @csrf

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control">
        @error('name')
        <div class="error-message">{{$message}}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="lastname">LastName</label>
        <input type="text" id="lastname" name="lastname" value="{{ old('lastname') }}" class="form-control">
        @error('lastname')
        <div class="error-message">{{$message}}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="age">Age</label>
        <input type="text" id="age" name="age" value="{{ old('age') }}" class="form-control">
        @error('age')
        <div class="error-message">{{$message}}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="city">City</label>
        <select name="city" id="city" class="form-control">
            <option value="Irkutsk">Irkutsk</option>
            <option value="Angarsk">Angarsk</option>
            <option value="Bratsk">Bratsk</option>
        </select>
        @error('city')
        <div class="error-message">{{$message}}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="text" id="email" name="email" value="{{ old('email') }}" class="form-control">
        @error('email')
        <div class="error-message">{{$message}}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Role</label>
        <div class="role-checkboxes">
            @foreach ($roles as $role)
            <label>
                <input type="checkbox" name="roles[]" value="{{ $role->id }}"> {{ $role->name }}
            </label>
            @endforeach
        </div>
    </div>

    <button type="submit" name="button" class="btn-submit">Отправить</button>
</form>

@endsection