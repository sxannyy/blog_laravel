@extends('layout')

@section('title', "Form")

@section('content')

@if (session('message'))
<div style="color: green;">
    {{ session('message') }}
</div>
@endif

<form method="POST" action="/users/{{ $user->id }}">
    @csrf
    <div>
        <label>Name</label>
        <input type="text" name="name" value="{{ $user->name }}">
        @error('name')
        <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>
    <br>
    <div>
        <label>LastName</label>
        <input type="text" name="lastname" value="{{ $user->lastname }}">
        @error('lastname')
        <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>
    <br>
    <div>
        <label>Age</label>
        <input type="text" name="age" value="{{ $user->age }}">
        @error('age')
        <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>
    <br>
    <div>
        <label>City</label>
        <select name="city">
            <option value="Irkutsk" @if($user->city === 'Irkutsk') selected @endif>Irkutsk</option>
            <option value="Angarsk" @if($user->city === 'Angarsk') selected @endif>Angarsk</option>
            <option value="Bratsk" @if($user->city === 'Bratsk') selected @endif>Bratsk</option>
        </select>
        @error('city')
        <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>
    <br>
    <div>
        <label>Email</label>
        <input type="text" name="email" value="{{ $user->email }}">
        @error('email')
        <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>
    <br>
    <div>
        <label>Role</label>
            @foreach ($roles as $role)
            <input type='checkbox' name='roles[]' value="{{ $role->id }}" @if ($user->role_id === $role->id) checked @endif>{{ $role->name }}
            @endforeach
    </div>
    <br>
    <button type="submit" name="button">Обновить</button>
</form>

@endsection