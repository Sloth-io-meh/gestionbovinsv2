@extends('layouts.app')

@section('title', 'Journal d\'activité')

@section('content')

    <x-breadcrumbs :items="['📋 Logs' => route('logs.index')]" />

    <h2 class="mb-4">📋 Journal d'activité</h2>

    {{-- Filters --}}
    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-3">
            <select name="log_name" class="form-select">
                <option value="">Tous les types</option>
                @foreach($logNames as $name)
                <option value="{{ $name }}" @selected(request('log_name') === $name)>{{ $name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="causer" class="form-select">
                <option value="">Tous les utilisateurs</option>
                @foreach($users as $u)
                <option value="{{ $u->id }}" @selected(request('causer') == $u->id)>{{ $u->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <input type="text" name="description" class="form-control" placeholder="Rechercher action..." value="{{ request('description') }}">
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-secondary w-100">🔍 Filtrer</button>
        </div>
    </form>

    <div class="card shadow">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Action</th>
                        <th>Utilisateur</th>
                        <th>Modèle</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td class="text-nowrap">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <span class="badge rounded-pill
                                @if($log->log_name === 'auth') bg-primary
                                @elseif(in_array($log->description, ['deleted', 'forceDeleted'])) bg-danger
                                @elseif($log->description === 'created') bg-success
                                @elseif($log->description === 'updated') bg-warning text-dark
                                @else bg-secondary
                                @endif">
                                {{ $log->log_name }}
                            </span>
                        </td>
                        <td>{{ $log->description }}</td>
                        <td>{{ $log->causer?->name ?? '—' }}</td>
                        <td class="text-muted small">
                            @if($log->subject_type)
                                {{ class_basename($log->subject_type) }} #{{ $log->subject_id }}
                            @else
                                —
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('logs.show', $log) }}" class="btn btn-sm btn-outline-secondary">Détails</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Aucun log trouvé</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $logs->links('pagination::bootstrap-5') }}
    </div>
@endsection
