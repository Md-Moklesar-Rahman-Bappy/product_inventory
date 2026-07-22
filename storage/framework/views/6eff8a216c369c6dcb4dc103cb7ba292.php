<?php
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
?>

<span class="badge <?php echo e($badgeClass); ?>" data-bs-toggle="tooltip" title="<?php echo e($tooltip); ?>">
  <?php echo e($badgeText); ?>

</span>
<?php /**PATH D:\Xammp\htdocs\bug-fixes v3\product_inventory\resources\views\components\warranty-countdown.blade.php ENDPATH**/ ?>