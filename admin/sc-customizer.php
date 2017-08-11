<div class="wrap">
  <h1><?php echo esc_html(get_admin_page_title())?></h1>
  <?php settings_errors(); ?>
  <form method="post" action="options.php">
    <table class="form-table">
      <?php 
        settings_fields( 'scec_settings_group' ); // This will output the nonce, action, and option_page fields for a settings page.
        do_settings_sections( 'sce_customizer' ); // This prints out the actual sections containing the settings fields for the page in parameter 
        ?>
      <?php submit_button(); ?>
    </table>
  </form>
</div>
