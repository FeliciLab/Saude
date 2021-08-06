<!-- $message as string | '' -->
<?php if (isset($message) & $message  != '') : ?>
  <div class="alert info">
    <?php echo $message ?>
  </div>
<?php endif; ?>