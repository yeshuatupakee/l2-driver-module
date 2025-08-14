@extends('layouts.app')

@section('content')
    <div class="page-header-container mb-4">
      <div class="d-flex justify-content-between align-items-center page-header">
        <div class="d-flex align-items-center">
          <div class="dashboard-logo me-3">
            <img src="{{ asset('img/jetlouge_logo.png') }}" alt="Jetlouge Travels" class="logo-img">
          </div>
          <div>
            <h2 class="fw-bold mb-1">Driver Dashboard</h2>
            <p class="text-muted mb-0">Welcome back, John!</p>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection