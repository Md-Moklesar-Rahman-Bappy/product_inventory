@php
  $now = now();
  $expired = $end && $end->isPast();

  if (!$start || !$end) {
      echo '<span class="text-muted">—</span>';
      return;
  }

  if ($expired) {
      $badgeClass = 'bg-danger text-white';
      $badgeText = 'Expired';
      $tooltip = 'Expired on ' . $end->format('d M Y');
  } else {
      $totalMinutes = $now->diffInMinutes($end);
      $totalDays = floor($totalMinutes / (60 * 24));
      $remainingHours = floor(($totalMinutes % (60 * 24)) / 60);

      $badgeText = "{$totalDays} days {$remainingHours} hours";
      $tooltip = 'Ends on ' . $end->format('d M Y');

      $badgeClass = match(true) {
          $totalDays <= 7  => 'bg-danger text-white pulse',
          $totalDays <= 30 => 'bg-warning text-dark',
          default          => 'bg-success text-white',
      };
  }
@endphp

<span class="badge {{ $badgeClass }}" data-bs-toggle="tooltip" title="{{ $tooltip }}">
  {{ $badgeText }}
</span>
