<header>
  <div class="nav">
    <a href="/" class="logo">Plant Project</a>
    <div class="">
      <?php if (!is_user_logged_in()) { ?>
        <h2>Sign In</h2>

        <?php
        echo_login_form('/', $session_messages);
        ?>
      <?php } ?>
      <?php if (is_user_logged_in()) { ?>
        <p>Hello, <?php echo $current_user['name'] ?></p>
        <button class="login-button-small"><a href="<?php echo logout_url(); ?>">
            <p class="login-label">Log Out</p>
          </a>
        </button>
      <?php } ?>
    </div>
  </div>
</header>
