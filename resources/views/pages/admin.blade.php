@extends('layouts.app')
@section('title', 'Contact us')
@section('content')
@can('contact.admin')
<a href="">Contact admin</a>
<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Officia atque dolores impedit voluptatum quis illo veniam doloribus deserunt similique eius, repellat corporis eaque, aliquid illum ex molestias vitae laborum saepe?</p>
@endcan
@endsection
