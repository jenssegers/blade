{{-- you must get 'Default' --}}
{{ $undefined ?? 'Default' }}<br>

{{-- it must strip out this XSS sample --}}
{{ '<script type="text/javascript">alert("Hacked!");</script>' }}<br>

{{-- this must be bold --}}
Hello, {!! $name !!}.<br>

{{-- using include directive --}}
@include('variables', ['name' => $name]) <br>

{{-- using unless, reversing 'true' --}}
@unless ($authenticated)
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
                        <tr id="{{ $loop->index }}">
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
