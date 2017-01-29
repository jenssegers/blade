@extends('main.layout')

@section('title')
Test Title
@endsection

@section('content')
{{-- you must get 'Default' --}}
{{ isset($name) ? $name : 'Default' }}<br>
{{ $name or 'Still Default' }}<br>

{{-- it must strip out this XSS sample --}}
{{ '<script type="text/javascript">alert("Hacked!");</script>' }}<br>

{{-- this must be bold --}}
<?php $name = '<strong>John Doe</strong>' ?>
Hello, {!! $name !!}.<br>

{{-- using include directive --}}
@include('variables', ['name' => $name]) <br>

{{-- @each('variables', $users, 'name') <br> --}}

<?php
$dateObj = new DateTime('2017-01-01 23:59:59');
?>

{{-- using object with() --}}
<?php echo with($dateObj)->format('m/d/Y H:i:s'); ?> <br>

{{-- using custom directive --}}
@datetime($dateObj) <br>

{{-- using unless, reversing 'true' --}}
@unless ($auth_check = false)
    You are not signed in.
@endunless

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <table class="table table-bordered">
                @if (count($users) > 0)
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                    </tr>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user['id'] }}</td>
                        <td>{{ $user['name'] }}</td>
                        <td>{{ $user['email'] }}</td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3">No users found!</td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection
