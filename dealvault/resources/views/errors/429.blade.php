@extends('layouts.app')

@section('title', 'Too Many Requests — Valtwise')

@section('content')
<div style="min-height:60vh;display:flex;align-items:center;justify-content:center;text-align:center;padding:40px 20px">
    <div>
        <div style="font-size:64px;margin-bottom:16px">⏳</div>
        <h1 style="font-size:28px;font-weight:700;color:var(--dark);margin-bottom:12px">Too Many Requests</h1>
        <p style="color:#71717a;font-size:15px;max-width:400px;margin:0 auto 24px">
            You've submitted too many messages. Please wait a few minutes before trying again.
        </p>
        <a href="{{ route('contact') }}" class="btn btn-green">Back to Contact</a>
    </div>
</div>
@endsection
