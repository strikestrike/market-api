@extends('adminlte::auth.login')

@section('auth_footer')
<p class="my-0">
    <a href="{{ route('privacyPolicy') }}" target="_blank">
        Privacy Policy
    </a>
</p>
@stop