<!-- 🌟 Footer -->
<footer class="sticky-footer bg-white border-top shadow-sm" style="background: linear-gradient(to right, #f8f9fc, #e3f2fd);">
  <div class="container py-3">
    <div class="text-center small text-muted fw-semibold" style="animation: fadeIn 0.6s ease-in-out;">
      <span>
        <i class="fas fa-calendar-alt me-1 text-primary"></i>
        <strong>© July 2020 – {{ date('d M Y, h:i:s A') }}</strong>
        <span class="text-dark">DLRS SOCDS Project</span>
      </span>
    </div>
  </div>
</footer>

<style>
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
  }
</style>
