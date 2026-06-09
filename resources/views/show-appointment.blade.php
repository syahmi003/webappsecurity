@extends('master.layout')
@section('content')



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="mb-0">Appointment Details</h2>
                    <div>
                        <a href="{{ route('appointments.index') }}" class="btn btn-secondary">Back</a>
                        <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-primary">Edit</a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="appointment-details">
                        <div class="row mb-3">
                            <div class="col-md-3 font-weight-bold">Title:</div>
                            <div class="col-md-9">{{ $appointment->title }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3 font-weight-bold">Date:</div>
                            <div class="col-md-9">{{ \Carbon\Carbon::parse($appointment->date)->format('F d, Y') }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3 font-weight-bold">Time:</div>
                            <div class="col-md-9">{{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3 font-weight-bold">Status:</div>
                            <div class="col-md-9">
                                <span class="badge badge-{{ $appointment->status === 'completed' ? 'success' : 'primary' }}">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3 font-weight-bold">Description:</div>
                            <div class="col-md-9">{{ $appointment->description ?? 'No description provided' }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3 font-weight-bold">Created:</div>
                            <div class="col-md-9">{{ $appointment->created_at->format('F d, Y h:i A') }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3 font-weight-bold">Last Updated:</div>
                            <div class="col-md-9">{{ $appointment->updated_at->format('F d, Y h:i A') }}</div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this appointment?')">
                                Delete Appointment
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .appointment-details .row {
        border-bottom: 1px solid #eee;
        padding: 10px 0;
    }
    .appointment-details .row:last-child {
        border-bottom: none;
    }
    .font-weight-bold {
        font-weight: bold;
    }
    .badge {
        padding: 8px 12px;
        font-size: 0.9em;
    }
</style>
@endsection
