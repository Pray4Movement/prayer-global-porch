<!-- Modal -->
<div class="modal fade" id="notification-modal" tabindex="-1" role="dialog" aria-labelledby="notification-modal-label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="notification-modal-label"><?php echo esc_html__( 'Allow Notifications', 'prayer-global-porch' ) ?></h5>
      </div>
      <div class="modal-body ">
        <p><?php echo esc_html__( 'Allow notifications to stay updated on your prayer streaks, milestones and more.', 'prayer-global-porch' ) ?></p>
        <p><?php echo esc_html__( 'You can change this later in your settings.', 'prayer-global-porch' ) ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary-outline" data-bs-dismiss="modal"><?php echo esc_html__( 'Not now', 'prayer-global-porch' ); ?></button>
        <button type="button" class="btn btn-primary" id="allow-notifications"><?php echo esc_html__( 'Allow', 'prayer-global-porch' ); ?></button>
      </div>
    </div>
  </div>
</div>