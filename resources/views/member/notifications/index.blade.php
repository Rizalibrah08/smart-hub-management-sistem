@extends('member.layouts.app')
@section('title', 'Notifikasi')
@section('content')
<div class="page-header">
    <h1>Notifikasi</h1>
</div>
<div class="card">
    @forelse($notifications as $n)
    <div style="display:flex;gap:12px;align-items:flex-start;padding:14px 0;border-bottom:1px solid #f0f0f0">
        <div style="width:10px;height:10px;border-radius:50%;background:{{ $n->read_at ? '#ddd' : '#27ae60' }};flex-shrink:0;margin-top:5px"></div>
        <div style="flex:1">
            <div style="font-weight:{{ $n->read_at ? '400' : '700' }};font-size:.9rem">{{ $n->title }}</div>
            <div style="font-size:.83rem;color:#666;margin-top:3px">{{ $n->message }}</div>
            <div style="font-size:.75rem;color:#aaa;margin-top:4px">{{ $n->created_at->diffForHumans() }}</div>
        </div>
        @if(!$n->read_at)
        <form method="POST" action="{{ route('member.notifications.read', $n) }}">
            @csrf @method('PUT')
            <button type="submit" class="btn btn-secondary btn-sm">Tandai Dibaca</button>
        </form>
        @else
        <span style="font-size:.75rem;color:#aaa">Dibaca</span>
        @endif
    </div>
    @empty
    <div style="text-align:center;color:#999;padding:32px">Tidak ada notifikasi.</div>
    @endforelse
    <div style="margin-top:16px">{{ $notifications->links() }}</div>
</div>
@endsection
