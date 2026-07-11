@extends('layouts.orbit')

@section('title', 'Book Appointment')

@section('content')
<section class="section py-5">
    <div class="container">

        <h2 class="fw-bold mb-4">
            Book Appointment
        </h2>

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body">

                <form action="{{ route('member.appointment.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">

                    {{-- Doctor --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Doctor
                        </label>

                        <input type="text"
                            class="form-control"
                            value="{{ $doctor->name }}"
                            readonly>
                    </div>

                    {{-- Service --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Service
                        </label>

                        <select class="form-select" name="service_id">
                            <option value="">-- Select Service --</option>

                            @foreach($services as $service)
                            <option value="{{ $service->id }}">
                                {{ $service->service_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Appointment Date
                        </label>

                        <input type="date"
                            class="form-control"
                            name="appointment_date"
                            min="{{ date('Y-m-d') }}"
                            required>
                    </div>
                    {{-- Schedule --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Schedule
                        </label>

                        <select class="form-select" name="schedule_id">
                            <option value="">-- Select Schedule --</option>

                            @foreach($schedules as $schedule)
                            <option value="{{ $schedule->id }}">
                                {{ $schedule->day_of_week }}
                                ({{ $schedule->time_range }})
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Complaint --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Complaint
                        </label>

                        <textarea
                            class="form-control"
                            name="member_complaint"
                            rows="4"
                            placeholder="Describe your complaint..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-calendar-check me-1"></i>
                        Book Appointment
                    </button>

                </form>

            </div>
        </div>

    </div>
</section>
@endsection