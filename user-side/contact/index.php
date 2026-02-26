<?php 
    session_start();
    require_once '../admin/assets/includes/config/config.php';

    require_once '../admin/assets/includes/functions/data_fetcher.php';
    require_once '../admin/assets/includes/functions/user_auth.php';
    require_once './admin/assets/includes/functions/utility_functions.php';
    require_once './admin/assets/includes/functions/send_emails.php';
?>
<!doctype html>
<html lang="en" style="height: 100%;">
    <head>
        <meta charset="UTF-8">
        <title>Contact Us - <?= htmlspecialchars(get_site_option('site_title')) ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
            integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">
        <link rel="stylesheet" href="../assets/css/global.css">
        <link rel="stylesheet" href="../assets/css/topbar.css">
        <link rel="stylesheet" href="../assets/css/header.css">
        <link rel="stylesheet" href="../assets/css/sections.css">
        <link rel="stylesheet" href="../assets/css/footer.css">
        <link rel="stylesheet" href="../assets/css/style_contact.css">
        <link rel="stylesheet" href="../assets/css/login-modal.css">
        <!-- Password Toggle Function (MUST be before components.js) -->
        <script src="../assets/js/toggle-password.js"></script>
    </head>
    <body>
        <div class="app-wrapper">
            <header>
                <?php 
                    require_once '../assets/elements/topbar.php';
                ?>

                <!-- Header -->
                <?php 
                    require_once '../assets/elements/header.php';
                ?>

                <!-- Navigation -->
                <?php 
                    require_once '../assets/elements/navbar.php';
                ?>
            </header>

            <!-- Hero Section -->
            <section class="hero-section" aria-labelledby="page-title">
                <div class="hero-inner">
                    <div class="hero-breadcrumb">
                        <a href="index.html">Home</a> / <span id="page-title">Contact</span>
                    </div>
                    <h2 class="hero-title" id="hero-heading">Get in Touch With Us</h2>
                    <!-- <p class="hero-subtitle" id="hero-subheading">Learn about our society's governance structure, history, facilities, and commitment to providing a safe, transparent, and community-focused living environment for all residents.</p> -->
                </div>
            </section>

            <!-- Main Content -->
            <main aria-label="Contact information">
                <div class="main-inner">
                    <!-- Emergency Banner -->
                    <div class="emergency-banner">
                        <div class="emergency-title"><i class="fas fa-exclamation-triangle"></i> Emergency Contact Numbers</div>
                        <div class="emergency-contacts">
                            <div class="emergency-contact"><i class="fas fa-shield-alt"></i> Police: <a href="tel:<?php echo get_office_details('police_number'); ?>"><?php echo get_office_details('police_number'); ?></a></div>
                            <div class="emergency-contact"><i class="fas fa-fire-extinguisher"></i> Fire: <a href="tel:<?php echo get_office_details('fire_number'); ?>"><?php echo get_office_details('fire_number'); ?></a></div>
                            <div class="emergency-contact"><i class="fas fa-ambulance"></i> Ambulance: <a href="tel:<?php echo get_office_details('ambulance_number_1'); ?>"><?php echo get_office_details('ambulance_number_1'); ?></a></div>
                            <div class="emergency-contact"><i class="fas fa-ambulance"></i> Ambulance: <a href="tel:<?php echo get_office_details('ambulance_number_2'); ?>"><?php echo get_office_details('ambulance_number_2'); ?></a></div>
                            <div class="emergency-contact"><i class="fas fa-hospital"></i> Society Security: <a href="tel:<?php echo get_office_details('society_security_number'); ?>"><?php echo get_office_details('society_security_number'); ?></a> (Intercom)</div>
                        </div>
                    </div>

                    <!-- Contact Form and Office Info Grid -->
                    <div class="contact-grid">
                        <!-- Contact Form -->
                        <div class="contact-card">
                            <!--<div class="card-header">-->
                            <!--    <div class="card-icon" aria-hidden="true"><i class="fas fa-envelope"></i></div>-->
                            <!--    <h3 class="card-title">Send Us a Message</h3>-->
                            <!--</div>-->
                            <!--<form id="contactQueryForm" action="" method="post">-->
                            <!--    <div class="form-group">-->
                            <!--        <label for="contact_fullName" class="form-label">-->
                            <!--            Full Name-->
                            <!--            <span class="required">*</span>-->
                            <!--        </label>-->
                            <!--        <input type="text" id="contact_fullName" name="contact_fullName" class="form-input" placeholder="Enter your full name" required>-->
                            <!--        <div class="form-error" id="contact_fullNameError">Please enter your name</div>-->
                            <!--    </div>-->
                            <!--    <div class="form-group">-->
                            <!--        <label for="contact_flatNumber" class="form-label">-->
                            <!--            Flat Number-->
                            <!--            <span class="required">*</span>-->
                            <!--        </label>-->
                            <!--        <input type="text" id="contact_flatNumber" name="contact_flatNumber" class="form-input" placeholder="e.g., A-101" required>-->
                            <!--        <div class="form-error" id="contact_flatNumberError">Please enter your flat number</div>-->
                            <!--    </div>-->
                            <!--    <div class="form-group">-->
                            <!--        <label for="contact_email" class="form-label">-->
                            <!--            Email Address-->
                            <!--            <span class="required">*</span>-->
                            <!--        </label>-->
                            <!--        <input type="email" id="contact_email" name="contact_email" class="form-input" placeholder="your.email@example.com" required>-->
                            <!--        <div class="form-error" id="contact_emailError">Please enter a valid email address</div>-->
                            <!--    </div>-->
                            <!--    <div class="form-group">-->
                            <!--        <label for="contact_phone" class="form-label">-->
                            <!--            Phone Number-->
                            <!--            <span class="required">*</span>-->
                            <!--        </label>-->
                            <!--        <input type="tel" id="contact_phone" name="contact_phone" class="form-input" placeholder="+91 98765 43210" required>-->
                            <!--        <div class="form-error" id="contact_phoneError">Please enter a valid phone number</div>-->
                            <!--    </div>-->
                            <!--    <div class="form-group">-->
                            <!--        <label for="contact_subject" class="form-label">-->
                            <!--            Subject-->
                            <!--            <span class="required">*</span>-->
                            <!--        </label>-->
                            <!--        <select id="contact_subject" name="contact_subject" class="form-select" required>-->
                            <!--            <option value="">Select a subject</option>-->
                            <!--            <option value="general">General Inquiry</option>-->
                            <!--            <option value="complaint">Complaint</option>-->
                            <!--            <option value="maintenance">Maintenance Issue</option>-->
                            <!--            <option value="payment">Payment Related</option>-->
                            <!--            <option value="suggestion">Suggestion</option>-->
                            <!--            <option value="other">Other</option>-->
                            <!--        </select>-->
                            <!--        <div class="form-error" id="subjectError">Please select a subject</div>-->
                            <!--    </div>-->
                            <!--    <div class="form-group">-->
                            <!--        <label for="contact_message" class="form-label">-->
                            <!--            Message-->
                            <!--            <span class="required">*</span>-->
                            <!--        </label>-->
                            <!--        <textarea id="contact_message" name="contact_message" class="form-textarea" placeholder="Type your message here..." required style="resize: none;"></textarea>-->
                            <!--        <div class="form-error" id="contact_messageError">Please enter your message</div>-->
                            <!--    </div>-->
                            <!--    <input type="submit" value="Coming Soon" class="btn-submit" name="send_contact_query" id="send_contact_query" disabled>-->
                            <!--</form>-->
                        </div>

                        <!-- Office Information -->
                        <div class="contact-card">
                            <div class="card-header">
                                <div class="card-icon" aria-hidden="true"><i class="fas fa-building"></i></div>
                                <h3 class="card-title">Office Information</h3>
                            </div>
                            <div class="info-item">
                                <div class="info-icon" aria-hidden="true"><i class="fas fa-map-marker-alt"></i></div>
                                <div class="info-content">
                                    <div class="info-label">Office Address</div>
                                    <div class="info-value" id="office-address">
                                        <?= get_office_address() ?>
                                    </div>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-icon" aria-hidden="true"><i class="fas fa-phone-alt"></i></div>
                                <div class="info-content">
                                    <div class="info-label">Phone Number</div>
                                    <div class="info-value"><a href="tel:<?=  get_office_details('office_phone_number') ?>" id="office-phone"><?=  get_office_details('office_phone_number') ?></a></div>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-icon" aria-hidden="true"><i class="fas fa-envelope"></i></div>
                                <div class="info-content">
                                    <div class="info-label">Email Address</div>
                                    <div class="info-value"><a href="mailto:<?=  get_office_details('office_email_address') ?>" id="office-email"><?=  get_office_details('office_email_address') ?></a></div>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-icon" aria-hidden="true"><i class="fas fa-clock"></i></div>
                                <div class="info-content">
                                    <div class="info-label">Office Hours</div>
                                    <div class="info-value"><?= get_office_hours() ?></div>
                                </div>
                            </div>
                            <!--<div class="info-item">-->
                            <!--    <div class="info-icon" aria-hidden="true"><i class="fas fa-globe"></i></div>-->
                            <!--    <div class="info-content">-->
                            <!--        <div class="info-label">Follow Us On</div>-->
                            <!--        <div class="info-value"><a href="https://facebook.com" target="_blank" rel="noopener noreferrer">Facebook</a> • <a href="https://twitter.com" target="_blank" rel="noopener noreferrer">Twitter</a> • <a href="https://instagram.com" target="_blank" rel="noopener noreferrer">Instagram</a></div>-->
                            <!--    </div>-->
                            <!--</div>-->
                        </div>
                    </div>

                    <!-- Map Section -->
                    <div class="map-container">
                        <div class="card-header">
                            <div class="card-icon" aria-hidden="true"><i class="fas fa-map"></i></div>
                            <h3 class="card-title">Find Us on Map</h3>
                        </div>
                        <?= get_maps_embed_code() ?>
                    </div>

                    <!-- Department Contacts -->
                    <div class="card-header">
                        <div class="card-icon" aria-hidden="true"><i class="fas fa-users"></i></div>
                        <h3 class="card-title">Department-wise Contacts</h3>
                    </div>
                    <div class="departments-grid">
                        <!-- Secretary -->
                        <div class="dept-card">
                            <div class="dept-header">
                                <div class="dept-icon" aria-hidden="true"><i class="fas fa-clipboard-list"></i></div>
                                <h4 class="dept-title">Secretary</h4>
                            </div>
                            <p class="dept-info">For general inquiries, society matters, and administrative issues.</p>
                            <div class="dept-contact">
                                <div class="dept-contact-item"><i class="fas fa-phone-alt"></i> <a href="tel:+919876543211">+91 98765 43211</a></div>
                                <div class="dept-contact-item"><i class="fas fa-envelope"></i> <a href="mailto:secretary@shreevikasnagar.org">secretary@shreevikasnagar.org</a></div>
                            </div>
                        </div>

                        <!-- Treasurer -->
                        <div class="dept-card">
                            <div class="dept-header">
                                <div class="dept-icon" aria-hidden="true"><i class="fas fa-indian-rupee-sign"></i></div>
                                <h4 class="dept-title">Treasurer</h4>
                            </div>
                            <p class="dept-info">For payment queries, financial matters, and account-related issues.</p>
                            <div class="dept-contact">
                                <div class="dept-contact-item"><i class="fas fa-phone-alt"></i> <a href="tel:+919876543212">+91 98765 43212</a></div>
                                <div class="dept-contact-item"><i class="fas fa-envelope"></i> <a href="mailto:treasurer@shreevikasnagar.org">treasurer@shreevikasnagar.org</a></div>
                            </div>
                        </div>

                        <!-- Maintenance -->
                        <div class="dept-card">
                            <div class="dept-header">
                                <div class="dept-icon" aria-hidden="true"><i class="fas fa-tools"></i></div>
                                <h4 class="dept-title">Maintenance</h4>
                            </div>
                            <p class="dept-info">For repairs, maintenance requests, and infrastructure issues.</p>
                            <div class="dept-contact">
                                <div class="dept-contact-item"><i class="fas fa-phone-alt"></i> <a href="tel:+919876543213">+91 98765 43213</a></div>
                                <div class="dept-contact-item"><i class="fas fa-envelope"></i> <a href="mailto:maintenance@shreevikasnagar.org">maintenance@shreevikasnagar.org</a></div>
                            </div>
                        </div>

                        <!-- Security -->
                        <div class="dept-card">
                            <div class="dept-header">
                                <div class="dept-icon" aria-hidden="true"><i class="fas fa-shield-alt"></i></div>
                                <h4 class="dept-title">Security</h4>
                            </div>
                            <p class="dept-info">For security concerns, visitor passes, and safety matters.</p>
                            <div class="dept-contact">
                                <div class="dept-contact-item"><i class="fas fa-phone-alt"></i> <a href="tel:+919876543214">+91 98765 43214</a></div>
                                <div class="dept-contact-item"><i class="fas fa-envelope"></i> <a href="mailto:security@shreevikasnagar.org">security@shreevikasnagar.org</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <?php 
                require_once '../assets/elements/footer.php';
            ?>
        </div>

        <!-- Toast Notification -->
        <div class="toast-notification" id="toastNotification">
            <span class="toast-icon"><i class="fas fa-check"></i></span>
            <span class="toast-message" id="toastMessage">Success!</span>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        
        <!-- Custom JS -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const contactQueryForm = document.getElementById('contactQueryForm');

                const toast = document.getElementById('toastNotification');
                const toastMessage = document.getElementById('toastMessage');

                contactQueryForm.onsubmit = function(e) {
                    e.preventDefault();

                    const sendMessageButton = document.getElementById('send_contact_query');
                    sendMessageButton.value = 'Sending...';
                    sendMessageButton.disabled = true;

                    const contactQueryFormData = new FormData(contactQueryForm);
                    contactQueryFormData.append('send_contact_query', 'true');

                    fetch('../assets/includes/functions/ajax/ajax-handler.php', {
                        method: 'POST',
                        body: contactQueryFormData
                    })
                    .then(response => {
                        if (!response.ok) {
                            showToast(toast, toastMessage, 'An error occurred. Please try again.', true);
                        }

                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            showToast(toast, toastMessage, 'Your message has been sent successfully!');
                            contactQueryForm.reset();
                        } else {
                            showToast(toast, toastMessage, 'Failed to send your message. Please try again.', true);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast(toast, toastMessage, 'An error occurred. Please try again.', true);
                    })
                    .finally(() => {
                        sendMessageButton.value = 'Send Message';
                        sendMessageButton.disabled = false;
                    });
                };
            });

            function showToast(toast, toastMessage, message, isError = false) {
                if (!toast || !toastMessage) return;
                toastMessage.textContent = message;
                toast.style.background = isError ? '#dc3545' : '#198754';
                toast.classList.add('active');
                setTimeout(() => toast.classList.remove('active'), 3000);
            }
        </script>
        <script src="../assets/js/login-modal.js"></script>
    </body>
</html>