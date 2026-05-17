@extends('layouts.app')

@section('title', 'Détail Log')

@section('content')
<div class="container-fluid">
    <x-breadcrumbs :items="[
        '📋 Logs' => route('logs.index'),
        'Détail' => route('logs.show', $log)
    ]" />

    <h2 class="mb-4">📋 Log #{{ $log->id }}</h2>

    <div class="card mb-4">
        <div class="card-header"><strong>Informations</strong></div>
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Date</dt>
                <dd class="col-sm-9">{{ $log->created_at->format('d/m/Y H:i:s') }}</dd>

                <dt class="col-sm-3">Type</dt>
                <dd class="col-sm-9"><span class="badge bg-secondary">{{ $log->log_name }}</span></dd>

                <dt class="col-sm-3">Action</dt>
                <dd class="col-sm-9"><code>{{ $log->description }}</code></dd>

                <dt class="col-sm-3">Utilisateur</dt>
                <dd class="col-sm-9">
                    @if($log->causer)
                        {{ $log->causer->name }} (ID {{ $log->causer->id }})
                    @else
                        <span class="text-muted">—</span>
                    @endif
                </dd>

                <dt class="col-sm-3">Modèle concerné</dt>
                <dd class="col-sm-9">
                    @if($log->subject_type)
                        {{ class_basename($log->subject_type) }} #{{ $log->subject_id }}
                    @else
                        <span class="text-muted">—</span>
                    @endif
                </dd>
            </dl>
        </div>
    </div>

    @if($log->properties && $log->properties->isNotEmpty())
    <div class="card">
        <div class="card-header"><strong>Données</strong></div>
        <div class="card-body">
            @if($log->properties->has('old') || $log->properties->has('attributes'))
            <div class="row">
                @if($log->properties->has('old'))
                <div class="col-md-6">
                    <h6 class="text-danger">Avant</h6>
                    <table class="table table-sm table-bordered">
                        @foreach($log->properties['old'] as $key => $value)
                        <tr>
                            <th class="text-muted" style="width:40%">{{ $key }}</th>
                            <td>{{ is_array($value) ? json_encode($value) : $value }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                @endif
                @if($log->properties->has('attributes'))
                <div class="col-md-6">
                    <h6 class="text-success">Après</h6>
                    <table class="table table-sm table-bordered">
                        @foreach($log->properties['attributes'] as $key => $value)
                        <tr>
                            <th class="text-muted" style="width:40%">{{ $key }}</th>
                            <td>{{ is_array($value) ? json_encode($value) : $value }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                @endif
            </div>
            @else
            <pre class="mb-0">{{ json_encode($log->properties->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
            @endif
        </div>
    </div>
    @endif

    <div class="mt-3">
        <a href="{{ route('logs.index') }}" class="btn btn-secondary">← Retour aux logs</a>
    </div>
</div>
@endsection
