@extends('layouts.app')

@section('title', 'Edit Category')

@section('contents')
<div class="container py-5">
  <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

    {{-- Gradient Header --}}
    <div class="card-header text-white" style="background: linear-gradient(90deg, #FF9800, #FF5722); padding: 1.5rem;">
      <h3 class="mb-0 fw-bold"><i class="fa fa-edit me-2"></i> Edit Category</h3>
    </div>

    {{-- Card Body --}}
    <div class="card-body bg-light" style="padding: 2rem;">
      <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Category Name --}}
        <div class="mb-4">
          <label for="category_name" class="form-label fw-semibold text-dark">Category Name</label>
          <input type="text" name="category_name" id="category_name" class="form-control form-control-lg shadow-sm" placeholder="Enter category name..." value="{{ $category->category_name }}" required>
        </div>

        {{-- Update Button --}}
        <div class="d-grid mt-4">
          <button type="submit" class="btn btn-warning btn-lg fw-bold shadow-sm">
            <i class="fa fa-save me-1"></i> Update Category
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
