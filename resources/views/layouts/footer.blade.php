<!-- 🌟 Footer -->
<footer class="sticky-footer bg-white border-top shadow-sm" style="background: linear-gradient(to right, #f8f9fc, #e3f2fd);">
  <div class="container py-3">
    <div class="text-center small text-muted fw-semibold" style="animation: fadeIn 0.6s ease-in-out;">
      <span>
        <i class="fas fa-calendar-alt me-1 text-primary"></i>
        <strong id="datetime"></strong>
        <span class="text-dark">DLRS SOCDS Project</span>
      </span>
    </div>
  </div>
</footer>

<script>
  function updateDateTime() {
    const now = new Date();
    const options = { day: 'numeric', month: 'short', year: 'numeric' };
    const dateStr = now.toLocaleDateString('en-GB', options).replace(/\//g, ' ');
    
    let hours = now.getHours();
    const minutes = now.getMinutes().toString().padStart(2, '0');
    const seconds = now.getSeconds().toString().padStart(2, '0');
    const ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12 || 12;
    const timeStr = `${hours}:${minutes}:${seconds} ${ampm} GMT+6`;
    
    document.getElementById('datetime').textContent = `${dateStr}, ${timeStr}`;
  }
  
  updateDateTime();
  setInterval(updateDateTime, 1000);
</script>

<style>
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
  }
</style>
