<x-guest-layout>
    <form action="{{ route('password.store') }}" method="POST">
    @csrf

    <div class="input-group">
        <input placeholder="Email" id="email" type="email" class="form-control"
               name="email" value="{{ old('email') }}" required>
        <span class="input-group-addon"><i class="fa fa-fw fa-envelope"></i></span>
    </div>

    <br/>

    <div class="input-group">
        <input placeholder="Password baru" id="password" type="password"
               class="form-control" name="password" required>
        <span class="input-group-addon"><i class="fa fa-fw fa-lock"></i></span>
    </div>

    <br/>

    <div class="input-group">
        <input placeholder="Konfirmasi password" id="password-confirm" type="password"
               name="password_confirmation" class="form-control" required>
        <span class="input-group-addon"><i class="fa fa-fw fa-lock"></i></span>
    </div>

    <br/>

    <div class="row">
        <div class="col-xs-8">
            Gunakan <a href="{{ url('/login') }}">akun lain</a>.
        </div>
        <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">
                RESET
            </button>
        </div>
    </div>
</form>
</x-guest-layout>
