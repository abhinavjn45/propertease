<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg main-navbar" aria-label="Primary navigation">
    <div class="container-fluid px-3 px-md-4">
        <span class="navbar-brand navbar-brand-text d-lg-none" onclick="window.location.href='<?= get_site_option('site_url'); ?>'"> Back to Home </span>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo get_site_option('site_url'); ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo get_site_option('site_url'); ?>about/">About Society</a>
                </li>
                <?php 
                    if (isset($_SESSION['member_email']) || isset($_SESSION['office_member_unique_id'])) {
                        echo "
                            <li class='nav-item'>
                                <a class='nav-link' href='" . get_site_option('site_url') . "agbms/'>Annual General Body Meeting</a>
                            </li>
                        ";
                    }
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo get_site_option('site_url'); ?>notices/">Notices &amp; Circulars</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo get_site_option('site_url'); ?>gallery/">Gallery</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo get_site_option('site_url'); ?>contact/">Contact Us</a>
                </li>
            </ul>
            <div class="d-flex flex-wrap gap-2">
                <?php 
                    if (isset($_SESSION['member_email'])) {
                        echo "
                            <a href='" . get_site_option('site_url') . "user-auth/my-account/' class='btn btn-sm btn-warning fw-semibold'><i class='fas fa-user'></i> My Account</a>
                            <a href='" . get_site_option('site_url') . "user-auth/logout/' class='btn btn-sm btn-light fw-semibold'><i class='fas fa-sign-out-alt'></i> Logout</a>
                        ";
                    } elseif (isset($_SESSION['office_member_unique_id'])) {
                        echo "
                            <a href='" . get_site_option('dashboard_url') . "' class='btn btn-sm btn-warning fw-semibold'><i class='fas fa-dashboard'></i> Office Dashboard</a>
                            <a href='" . get_site_option('dashboard_url') . "user-auth/logout/' class='btn btn-sm btn-light fw-semibold'><i class='fas fa-sign-out-alt'></i> Logout</a>
                        ";
                    } else {
                ?>
                <button class="btn btn-sm btn-warning fw-semibold" type="button" data-bs-toggle="modal" data-bs-target="#loginModal">
                    Resident Login
                </button>
                <button class="btn btn-sm btn-light fw-semibold" type="button" data-bs-toggle="modal" data-bs-target="#officeLoginModal">
                    Office Login
                </button>
                <?php } ?>
            </div>
        </div>
    </div>
</nav>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <!-- Modal Header -->
            <div class="modal-header bg-gradient border-0 py-4 flex-column align-items-center text-center">
                <button type="button" class="btn-close btn-close-white align-self-end" data-bs-dismiss="modal" aria-label="Close"></button>
                <!-- <div class="mb-3">
                    <div class="login-logo-wrapper">
                        <i class="fas fa-home fa-3x text-white"></i>
                    </div>
                </div> -->
                <div class="login-header-text">
                    <h5 class="modal-title fw-bold" id="loginModalLabel">Resident Login</h5>
                    <p class="small mb-0 mt-2">Access your society portal</p>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-4">
                <div class="alert alert-warning alert-dismissible fade show" id="residentLoginMsg" role="alert" style="display: none;">
                </div>
                <!-- Login Form -->
                <form id="loginForm" action="" method="post">
                    <?= csrf_input_field() ?>
                    <!-- Email Field -->
                    <div class="mb-3">
                        <!-- <label for="loginEmail" class="form-label fw-semibold">Email Address</label> -->
                        <input type="email" class="form-control form-control-lg" id="loginEmail" name="loginEmail" placeholder="Enter your email" required>
                        <small class="text-muted d-block mt-1">Use your registered email address</small>
                    </div>

                    <!-- Password Field -->
                    <div class="mb-3">
                        <div class="input-group">
                            <input type="password" class="form-control form-control-lg" id="loginPassword" name="loginPassword" placeholder="Enter your password" required>
                            <button class="btn btn-outline-secondary toggle-password-btn" type="button" id="togglePassword" tabindex="-1" aria-label="Toggle password visibility" onclick="togglePasswordVisibility(event); return false;">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="row align-items-center mb-4">
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="r_rememberMe">
                                <label class="form-check-label" for="r_rememberMe">
                                    Remember me
                                </label>
                            </div>
                        </div>
                        <div class="col-auto">
                            <a href="javascript:void(0);" class="text-decoration-none fw-semibold small" onclick="switchModal('loginModal', 'residentForgotPasswordStep1Modal')">Forgot Password?</a>
                        </div>
                    </div>

                    <!-- Login Button -->
                    <!-- <button type="submit" value="Login" class="btn btn-lg btn-warning w-100 fw-bold mb-3" name="resident_login" id="resident_login"> -->
                    <button type="submit" class="btn btn-lg btn-warning w-100 fw-bold mb-3" name="resident_login" id="resident_login">
                        Login
                    </button>

                    <!-- Divider -->
                    <!-- <div class="text-center mb-3">
                        <small class="text-muted">or</small>
                    </div> -->

                    <!-- Demo Login Button -->
                    <!-- <button type="button" class="btn btn-lg btn-outline-primary w-100 fw-bold" id="demoLoginBtn">
                        <i class="fas fa-play-circle me-2"></i>Demo Login
                    </button> -->
                </form>

                <!-- Signup Link -->
                <!-- <div class="text-center mt-4 pt-3 border-top">
                    <p class="mb-0">
                        Don't have an account?
                        <a href="#" class="fw-semibold text-decoration-none">Register here</a>
                    </p>
                </div> -->
            </div>

            <!-- Modal Footer -->
            <!-- <div class="modal-footer bg-light border-top py-3">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <small class="text-muted ms-auto"><i class="fas fa-shield-alt me-1"></i>Secure Login</small>
            </div> -->
        </div>
    </div>
</div>

<!-- Resident Forgot Password Modals -->
<!-- Resident Step 1 -->
<div class="modal fade" id="residentForgotPasswordStep1Modal" tabindex="-1" aria-labelledby="residentForgotPasswordStep1ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <!-- Modal Header -->
            <div class="modal-header bg-gradient border-0 py-4 flex-column align-items-center text-center">
                <button type="button" class="btn-close btn-close-white align-self-end" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="login-header-text">
                    <h5 class="modal-title fw-bold" id="residentForgotPasswordStep1ModalLabel">Reset Password</h5>
                    <p class="small mb-0 mt-2">Enter your details to reset password</p>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-4">
                <div class="alert alert-warning alert-dismissible fade show" id="residentResetPasswordEmailMsg" role="alert" style="display: none;">
                </div>
                <?= csrf_input_field() ?>
                <!-- Reset Password Form -->
                <form id="residentResetPasswordEmailForm" action="" method="post">
                    <?= csrf_input_field() ?>
                    <!-- Email Field -->
                    <div class="mb-3">
                        <input type="email" class="form-control form-control-lg" id="residentResetEmail" name="residentResetEmail" placeholder="Enter your registered email" required>
                        <small class="text-muted d-block mt-1">We'll send an OTP to this email</small>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-lg btn-warning w-100 fw-bold mb-3" name="resident_reset_password_send_otp" id="resident_reset_password_send_otp">
                        Send OTP
                    </button>

                    <!-- Back to Login Link -->
                    <div class="text-center">
                        <a href="javascript:void(0);" class="text-decoration-none fw-semibold small" data-bs-target="#loginModal" data-bs-toggle="modal" data-bs-dismiss="modal">Back to Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Resident Step 2 -->
<div class="modal fade" id="residentForgotPasswordStep2Modal" tabindex="-1" aria-labelledby="residentForgotPasswordStep2ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <!-- Modal Header -->
            <div class="modal-header bg-gradient border-0 py-4 flex-column align-items-center text-center">
                <button type="button" class="btn-close btn-close-white align-self-end" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="login-header-text">
                    <h5 class="modal-title fw-bold" id="residentForgotPasswordStep2ModalLabel">Reset Password</h5>
                    <p class="small mb-0 mt-2">Enter OTP sent to your Registered Email</p>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-4">
                <!-- Email Display -->
                <div class="mb-4 p-3 bg-light rounded">
                    <small class="text-muted d-block">An OTP has been sent to:</small>
                    <span class="fw-bold" id="displayResidentEmail"></span>
                </div>

                <!-- Reset Password Form -->
                <form id="residentResetPasswordOTPForm" action="" method="post">
                    <?= csrf_input_field() ?>

                    <!-- Hidden Email Field -->
                    <input type="hidden" id="residentResetEmailHidden" name="residentResetEmail">

                    <!-- OTP Field -->
                    <div class="mb-3">
                        <input type="text" class="form-control form-control-lg" id="residentOTP" name="residentOTP" placeholder="Enter OTP" required>
                        <small class="text-muted d-block mt-1">Check your email for the OTP</small>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-lg btn-warning w-100 fw-bold mb-3" name="resident_reset_password_validate_otp" id="resident_reset_password_validate_otp">
                        Validate OTP
                    </button>

                    <!-- Resend OTP Button -->
                    <button type="button" class="btn btn-lg btn-outline-secondary w-100 fw-bold mb-3" id="resendOTPBtn">
                        <i class="fas fa-redo me-2"></i>Resend OTP
                    </button>

                    <!-- Back to Login Link -->
                    <div class="text-center">
                        <a href="javascript:void(0);" class="text-decoration-none fw-semibold small" data-bs-target="#loginModal" data-bs-toggle="modal" data-bs-dismiss="modal">Back to Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Resident Step 3 -->
<div class="modal fade" id="residentForgotPasswordStep3Modal" tabindex="-1" aria-labelledby="residentForgotPasswordStep3ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <!-- Modal Header -->
            <div class="modal-header bg-gradient border-0 py-4 flex-column align-items-center text-center">
                <button type="button" class="btn-close btn-close-white align-self-end" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="login-header-text">
                    <h5 class="modal-title fw-bold" id="residentForgotPasswordStep3ModalLabel">Reset Password</h5>
                    <p class="small mb-0 mt-2">Create Your New Password</p>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-4">
                <div class="alert alert-warning alert-dismissible fade show" id="residentResetNewPasswordMsg" role="alert" style="display: none;">
                </div>
                <!-- Reset Password Form -->
                <form id="residentResetNewPasswordForm" action="" method="post">
                    <?= csrf_input_field() ?>

                    <!-- Hidden Email Field -->
                    <input type="hidden" id="residentResetEmailHidden3" name="residentResetEmail">

                    <!-- New Password Field -->
                    <div class="mb-3">
                        <div class="input-group">
                            <input type="password" class="form-control form-control-lg" id="residentNewPassword" name="residentNewPassword" placeholder="Enter new password" required>
                            <button class="btn btn-outline-secondary toggle-password-btn" type="button" tabindex="-1" aria-label="Toggle password visibility" onclick="togglePasswordVisibility(event); return false;">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <small class="text-muted d-block mt-1">Minimum 8 characters with uppercase, lowercase, numbers & symbols</small>
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="mb-4">
                        <div class="input-group">
                            <input type="password" class="form-control form-control-lg" id="residentConfirmPassword" name="residentConfirmPassword" placeholder="Confirm new password" required>
                            <button class="btn btn-outline-secondary toggle-password-btn" type="button" tabindex="-1" aria-label="Toggle password visibility" onclick="togglePasswordVisibility(event); return false;">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-lg btn-warning w-100 fw-bold mb-3" name="resident_reset_password_submit" id="resident_reset_password_submit">
                        Reset Password
                    </button>

                    <!-- Back to Login Link -->
                    <div class="text-center">
                        <a href="javascript:void(0);" class="text-decoration-none fw-semibold small" data-bs-target="#loginModal" data-bs-toggle="modal" data-bs-dismiss="modal">Back to Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Office Login Modal -->
<div class="modal fade" id="officeLoginModal" tabindex="-1" aria-labelledby="officeLoginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <!-- Modal Header -->
            <div class="modal-header bg-gradient border-0 py-4 flex-column align-items-center text-center">
                <button type="button" class="btn-close btn-close-white align-self-end" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="login-header-text">
                    <h5 class="modal-title fw-bold" id="officeLoginModalLabel">Office Login</h5>
                    <p class="small mb-0 mt-2">Access your society portal</p>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-4">
                <?php 
                    if (isset($o_msg)) {
                        echo "
                            <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                <i class='fas fa-exclamation-triangle me-2'></i>
                                " . htmlspecialchars($o_msg) . "
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>
                        ";
                    }
                ?>
                <!-- Login Form -->
                <form id="officeLoginForm" action="" method="post">
                    <?= csrf_input_field() ?>
                    <!-- Email Field -->
                    <div class="mb-3">
                        <input type="email" class="form-control form-control-lg" id="officeLoginEmail" name="officeLoginEmail" placeholder="Enter your email" required>
                        <small class="text-muted d-block mt-1">Use your registered email address</small>
                    </div>

                    <!-- Password Field -->
                    <div class="mb-3">
                        <!-- <label for="officeLoginPassword" class="form-label fw-semibold">Password</label> -->
                        <div class="input-group">
                            <input type="password" class="form-control form-control-lg" id="officeLoginPassword" name="officeLoginPassword" placeholder="Enter your password" required>
                            <button class="btn btn-outline-secondary toggle-password-btn" type="button" id="toggleOfficePassword" tabindex="-1" aria-label="Toggle password visibility" onclick="togglePasswordVisibility(event); return false;">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="row align-items-center mb-4">
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="o_rememberMe">
                                <label class="form-check-label" for="o_rememberMe">
                                    Remember me
                                </label>
                            </div>
                        </div>
                        <div class="col-auto">
                            <a href="javascript:void(0);" class="text-decoration-none fw-semibold small" onclick="switchModal('officeLoginModal', 'officeForgotPasswordModal')">Forgot Password?</a>
                        </div>
                    </div>

                    <!-- Login Button -->
                    <input type="submit" value="Login" class="btn btn-lg btn-warning w-100 fw-bold mb-3" name="office_login" id="office_login">
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const residentLoginForm = document.getElementById('loginForm');
    if (residentLoginForm) {
        residentLoginForm.onsubmit = function(e) {
            e.preventDefault();

            const msgDiv = document.getElementById('residentLoginMsg');
            msgDiv.style.display = 'none';

            const btn = document.getElementById('resident_login');
            btn.disabled = true;
            btn.textContent = 'Logging in...';

            const residentEmail = document.getElementById('loginEmail').value.trim();
            const residentPassword = document.getElementById('loginPassword').value.trim();
            const csrfToken = document.querySelector('input[name="csrf_token"]').value;

            if (!residentEmail || !residentPassword || !csrfToken) {
                msgDiv.style.display = 'block';
                msgDiv.innerHTML = "<i class='fas fa-exclamation-triangle me-2'></i> Please provide both email and password.<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
                btn.disabled = false; btn.textContent = 'Login';
                return;
            }

            const formData = new FormData();
            formData.append('loginEmail', residentEmail);
            formData.append('loginPassword', residentPassword);
            formData.append('csrf_token', csrfToken);

            fetch('admin/assets/includes/functions/ajax-handlers/user-auth/resident_login.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Update CSRF token in all forms
                    if (data.csrf_token) {
                        document.querySelectorAll('input[name="csrf_token"]').forEach(field => {
                            field.value = data.csrf_token;
                        });
                    }
                    
                    // Redirect to member dashboard
                    window.location.href = data.redirect_url || '<?= get_site_option('site_url'); ?>user-auth/my-account/';
                } else {
                    msgDiv.style.display = 'block';
                    msgDiv.innerHTML = "<i class='fas fa-exclamation-triangle me-2'></i> " + (data.error || 'Login failed. Please try again.') + "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
                }
            })
            .catch(err => {
                msgDiv.style.display = 'block';
                msgDiv.innerHTML = "<i class='fas fa-exclamation-triangle me-2'></i> An error occurred. Please try again.<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
            })
            .finally(() => {
                btn.disabled = false;
                btn.textContent = 'Login';
            });
        }
    }
</script>

<script>
    // Helper function to switch between modals properly
    function switchModal(fromModalId, toModalId) {
        // Blur the currently focused element to prevent aria-hidden issues
        document.activeElement?.blur();
        
        // Small delay to allow focus to clear
        setTimeout(() => {
            const fromModal = bootstrap.Modal.getInstance(document.getElementById(fromModalId));
            if (fromModal) {
                fromModal.hide();
            }
            const toModal = new bootstrap.Modal(document.getElementById(toModalId));
            toModal.show();
        }, 50);
    }

    // Global handler to blur focused elements when any modal is hidden
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('hide.bs.modal', function(e) {
            document.activeElement?.blur();
        });
    });

    // Resident Password Reset - Step 1: Send OTP
    const residentResetPasswordEmailForm = document.getElementById('residentResetPasswordEmailForm');
    if (residentResetPasswordEmailForm) {
        residentResetPasswordEmailForm.onsubmit = function(e) {
            e.preventDefault();

            const msgDiv = document.getElementById('residentResetPasswordEmailMsg');
            msgDiv.style.display = 'none';

            const btn = document.getElementById('resident_reset_password_send_otp');
            btn.disabled = true;
            btn.textContent = 'Sending OTP...';

            const residentEmail = document.getElementById('residentResetEmail').value.trim();
            const csrfToken = document.querySelector('input[name="csrf_token"]').value;

            if (!residentEmail || !csrfToken) {
                msgDiv.style.display = 'block';
                msgDiv.innerHTML = "<i class='fas fa-exclamation-triangle me-2'></i> Please provide email.<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
                btn.disabled = false; btn.textContent = 'Send OTP';
                return;
            }

            const formData = new FormData();
            formData.append('residentResetPasswordEmail', residentEmail);
            formData.append('csrf_token', csrfToken);

            console.log('Sending request to:', 'admin/assets/includes/functions/ajax-handlers/user-auth/forgot-password/send_otp.php');
            console.log('Email:', residentEmail);

            fetch('admin/assets/includes/functions/ajax-handlers/user-auth/forgot-password/send_otp.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Update CSRF token in all forms
                    if (data.csrf_token) {
                        document.querySelectorAll('input[name="csrf_token"]').forEach(field => {
                            field.value = data.csrf_token;
                        });
                    }
                    
                    // Store email for step 2
                    document.getElementById('residentResetEmailHidden').value = residentEmail;
                    
                    // Display email in step 2
                    document.getElementById('displayResidentEmail').textContent = residentEmail;

                    // Close step 1 modal
                    const step1Modal = bootstrap.Modal.getInstance(document.getElementById('residentForgotPasswordStep1Modal'));
                    if (step1Modal) step1Modal.hide();

                    // Open step 2 modal
                    const step2Modal = new bootstrap.Modal(document.getElementById('residentForgotPasswordStep2Modal'));
                    step2Modal.show();

                    const step2MsgDiv = document.getElementById('residentResetPasswordOTPMsg');
                    step2MsgDiv.style.display = 'block';
                    step2MsgDiv.innerHTML = "<i class='fas fa-exclamation-triangle me-2'></i> An OTP has been sent to " + residentEmail + ".<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
                } else {
                    msgDiv.style.display = 'block';
                    msgDiv.innerHTML = "<i class='fas fa-exclamation-triangle me-2'></i> " + (data.error || 'Failed. Please try again.') + "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
                }
            })
            .catch(err => {
                msgDiv.style.display = 'block';
                msgDiv.innerHTML = "<i class='fas fa-exclamation-triangle me-2'></i> An error occurred. Please try again.<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
            })
            .finally(() => {
                btn.disabled = false;
                btn.textContent = 'Send OTP';
            });
        }
    }


    // Resident Password Reset - Step 2: Validate OTP
    const residentResetPasswordOTPForm = document.getElementById('residentResetPasswordOTPForm');
    if (residentResetPasswordOTPForm) {
        residentResetPasswordOTPForm.onsubmit = function(e) {
            e.preventDefault();

            const msgDiv = document.getElementById('residentResetPasswordOTPMsg');
            const btn = document.getElementById('resident_reset_password_validate_otp');
            btn.disabled = true;
            btn.textContent = 'Validating...';

            const residentEmail = document.getElementById('residentResetEmailHidden').value.trim();
            const residentOTP = document.getElementById('residentOTP').value.trim();
            const csrfToken = document.querySelector('input[name="csrf_token"]').value;

            if (!residentOTP || !csrfToken) {
                msgDiv.style.display = 'block';
                msgDiv.innerHTML = "<i class='fas fa-exclamation-triangle me-2'></i> Please provide OTP.<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
                btn.disabled = false; btn.textContent = 'Validate OTP';
                return;
            }

            const formData = new FormData();
            formData.append('residentResetPasswordEmail', residentEmail);
            formData.append('residentOTP', residentOTP);
            formData.append('csrf_token', csrfToken);

            fetch('admin/assets/includes/functions/ajax-handlers/user-auth/forgot-password/validate_otp.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Update CSRF token in all forms
                    if (data.csrf_token) {
                        document.querySelectorAll('input[name="csrf_token"]').forEach(field => {
                            field.value = data.csrf_token;
                        });
                    }
                    
                    // Store email for step 3
                    document.getElementById('residentResetEmailHidden3').value = residentEmail;

                    // Close step 2 modal
                    const step2Modal = bootstrap.Modal.getInstance(document.getElementById('residentForgotPasswordStep2Modal'));
                    if (step2Modal) step2Modal.hide();

                    // Open step 3 modal
                    const step3Modal = new bootstrap.Modal(document.getElementById('residentForgotPasswordStep3Modal'));
                    step3Modal.show();
                } else {
                    msgDiv.style.display = 'block';
                    msgDiv.innerHTML = "<i class='fas fa-exclamation-triangle me-2'></i> " + (data.error || 'Failed. Please try again.') + "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
                }
            })
            .catch(err => {
                msgDiv.style.display = 'block';
                msgDiv.innerHTML = "<i class='fas fa-exclamation-triangle me-2'></i> An error occurred. Please try again.<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
            })
            .finally(() => {
                btn.disabled = false;
                btn.textContent = 'Validate OTP';
            });
        }
    }

    // Resident Password Reset - Step 3: Reset Password
    const residentResetNewPasswordForm = document.getElementById('residentResetNewPasswordForm');
    if (residentResetNewPasswordForm) {
        residentResetNewPasswordForm.onsubmit = function(e) {
            e.preventDefault();

            const msgDiv = document.getElementById('residentResetNewPasswordMsg');
            msgDiv.style.display = 'none';

            const btn = document.getElementById('resident_reset_password_submit');
            btn.disabled = true;
            btn.textContent = 'Resetting...';

            const residentEmail = document.getElementById('residentResetEmailHidden3').value.trim();
            const newPassword = document.getElementById('residentNewPassword').value.trim();
            const confirmPassword = document.getElementById('residentConfirmPassword').value.trim();
            const csrfToken = document.querySelector('input[name="csrf_token"]').value;

            // Validate passwords
            if (!newPassword || !confirmPassword) {
                msgDiv.style.display = 'block';
                msgDiv.innerHTML = "<i class='fas fa-exclamation-triangle me-2'></i> Please enter and confirm your password.<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
                btn.disabled = false; btn.textContent = 'Reset Password';
                return;
            }

            if (newPassword !== confirmPassword) {
                msgDiv.style.display = 'block';
                msgDiv.innerHTML = "<i class='fas fa-exclamation-triangle me-2'></i> Passwords do not match.<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
                btn.disabled = false; btn.textContent = 'Reset Password';
                return;
            }

            if (newPassword.length < 8) {
                msgDiv.style.display = 'block';
                msgDiv.innerHTML = "<i class='fas fa-exclamation-triangle me-2'></i> Password must be at least 8 characters long.<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
                btn.disabled = false; btn.textContent = 'Reset Password';
                return;
            }

            const formData = new FormData();
            formData.append('residentResetPasswordEmail', residentEmail);
            formData.append('residentNewPassword', newPassword);
            formData.append('csrf_token', csrfToken);

            fetch('admin/assets/includes/functions/ajax-handlers/user-auth/forgot-password/reset_password.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Update CSRF token in all forms
                    if (data.csrf_token) {
                        document.querySelectorAll('input[name="csrf_token"]').forEach(field => {
                            field.value = data.csrf_token;
                        });
                    }
                    
                    msgDiv.style.display = 'block';
                    msgDiv.className = 'alert alert-success alert-dismissible fade show';
                    msgDiv.innerHTML = "<i class='fas fa-check-circle me-2'></i> Password reset successfully! Please login with your new password.";
                    
                    setTimeout(() => {
                        const step3Modal = bootstrap.Modal.getInstance(document.getElementById('residentForgotPasswordStep3Modal'));
                        if (step3Modal) step3Modal.hide();
                        
                        // Show login modal
                        const loginModal = new bootstrap.Modal(document.getElementById('residentLoginModal'));
                        loginModal.show();
                    }, 2000);
                } else {
                    msgDiv.style.display = 'block';
                    msgDiv.className = 'alert alert-warning alert-dismissible fade show';
                    msgDiv.innerHTML = "<i class='fas fa-exclamation-triangle me-2'></i> " + (data.error || 'Failed to reset password. Please try again.') + "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
                }
            })
            .catch(err => {
                msgDiv.style.display = 'block';
                msgDiv.className = 'alert alert-warning alert-dismissible fade show';
                msgDiv.innerHTML = "<i class='fas fa-exclamation-triangle me-2'></i> An error occurred. Please try again.<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
            })
            .finally(() => {
                btn.disabled = false;
                btn.textContent = 'Reset Password';
            });
        }
    }

    // Resend OTP Button with 30-second cooldown
    const resendOTPBtn = document.getElementById('resendOTPBtn');
    let resendCooldown = 0;
    
    if (resendOTPBtn) {
        resendOTPBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Check if still in cooldown
            if (resendCooldown > 0) {
                return;
            }
            
            const email = document.getElementById('residentResetEmailHidden').value;
            const csrfToken = document.querySelector('input[name="csrf_token"]').value;
            const msgDiv = document.getElementById('residentResetPasswordOTPMsg');
            
            if (!email || !csrfToken) {
                msgDiv.style.display = 'block';
                msgDiv.className = 'alert alert-warning alert-dismissible fade show';
                msgDiv.innerHTML = "<i class='fas fa-exclamation-triangle me-2'></i> Email is required.<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
                return;
            }
            
            resendOTPBtn.disabled = true;
            const originalText = resendOTPBtn.innerHTML;
            resendOTPBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sending...';
            
            const formData = new FormData();
            formData.append('residentResetPasswordEmail', email);
            formData.append('csrf_token', csrfToken);
            
            fetch('admin/assets/includes/functions/ajax-handlers/user-auth/forgot-password/send_otp.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Update CSRF token
                    if (data.csrf_token) {
                        document.querySelectorAll('input[name="csrf_token"]').forEach(field => {
                            field.value = data.csrf_token;
                        });
                    }
                    
                    msgDiv.style.display = 'block';
                    msgDiv.className = 'alert alert-success alert-dismissible fade show';
                    msgDiv.innerHTML = "<i class='fas fa-check-circle me-2'></i> OTP resent successfully! Check your email.";
                    
                    // Start 30-second cooldown
                    resendCooldown = 30;
                    const cooldownInterval = setInterval(() => {
                        resendCooldown--;
                        resendOTPBtn.innerHTML = `<i class="fas fa-redo me-2"></i>Resend OTP (${resendCooldown}s)`;
                        
                        if (resendCooldown <= 0) {
                            clearInterval(cooldownInterval);
                            resendOTPBtn.disabled = false;
                            resendOTPBtn.innerHTML = originalText;
                        }
                    }, 1000);
                } else {
                    msgDiv.style.display = 'block';
                    msgDiv.className = 'alert alert-warning alert-dismissible fade show';
                    msgDiv.innerHTML = "<i class='fas fa-exclamation-triangle me-2'></i> " + (data.error || 'Failed to resend OTP. Please try again.') + "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
                    resendOTPBtn.disabled = false;
                    resendOTPBtn.innerHTML = originalText;
                }
            })
            .catch(err => {
                msgDiv.style.display = 'block';
                msgDiv.className = 'alert alert-warning alert-dismissible fade show';
                msgDiv.innerHTML = "<i class='fas fa-exclamation-triangle me-2'></i> An error occurred. Please try again.<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
                resendOTPBtn.disabled = false;
                resendOTPBtn.innerHTML = originalText;
            });
        });
    }
</script>
