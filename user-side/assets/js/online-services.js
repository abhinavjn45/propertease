(function () {
    'use strict';

    const serviceForms = {
        payment: {
            title: 'Pay Maintenance Charges',
            html:
                '<form id="serviceForm">' +
                '<div class="form-group">' +
                '<label for="flatNo" class="form-label">Flat Number <span class="required">*</span></label>' +
                '<input type="text" id="flatNo" class="form-input" placeholder="e.g., A-101" required>' +
                '<div class="form-error" id="flatNoError">Please enter your flat number</div>' +
                '</div>' +
                '<div class="form-group">' +
                '<label for="residentName" class="form-label">Resident Name <span class="required">*</span></label>' +
                '<input type="text" id="residentName" class="form-input" placeholder="Enter your full name" required>' +
                '<div class="form-error" id="residentNameError">Please enter your name</div>' +
                '</div>' +
                '<div class="form-group">' +
                '<label for="paymentMonth" class="form-label">Payment Month <span class="required">*</span></label>' +
                '<select id="paymentMonth" class="form-select" required>' +
                '<option value="">Select month</option>' +
                '<option value="june-2025">June 2025</option>' +
                '<option value="july-2025">July 2025</option>' +
                '<option value="august-2025">August 2025</option>' +
                '</select>' +
                '<div class="form-error" id="paymentMonthError">Please select a month</div>' +
                '</div>' +
                '<div class="form-group">' +
                '<label for="amount" class="form-label">Amount (₹) <span class="required">*</span></label>' +
                '<input type="number" id="amount" class="form-input" placeholder="Enter amount" required>' +
                '<div class="form-error" id="amountError">Please enter a valid amount</div>' +
                '</div>' +
                '<div class="form-group">' +
                '<label for="paymentMethod" class="form-label">Payment Method <span class="required">*</span></label>' +
                '<select id="paymentMethod" class="form-select" required>' +
                '<option value="">Select payment method</option>' +
                '<option value="upi">UPI</option>' +
                '<option value="netbanking">Net Banking</option>' +
                '<option value="card">Credit/Debit Card</option>' +
                '</select>' +
                '<div class="form-error" id="paymentMethodError">Please select a payment method</div>' +
                '</div>' +
                '<div class="form-actions">' +
                '<button type="button" class="btn-secondary" id="cancelBtn">Cancel</button>' +
                '<button type="submit" class="btn-primary" id="submitBtn">Proceed to Payment</button>' +
                '</div>' +
                '</form>'
        },
        complaint: {
            title: 'Register Complaint',
            html:
                '<form id="serviceForm">' +
                '<div class="form-group">' +
                '<label for="flatNo" class="form-label">Flat Number <span class="required">*</span></label>' +
                '<input type="text" id="flatNo" class="form-input" placeholder="e.g., A-101" required>' +
                '<div class="form-error" id="flatNoError">Please enter your flat number</div>' +
                '</div>' +
                '<div class="form-group">' +
                '<label for="residentName" class="form-label">Resident Name <span class="required">*</span></label>' +
                '<input type="text" id="residentName" class="form-input" placeholder="Enter your full name" required>' +
                '<div class="form-error" id="residentNameError">Please enter your name</div>' +
                '</div>' +
                '<div class="form-group">' +
                '<label for="complaintCategory" class="form-label">Complaint Category <span class="required">*</span></label>' +
                '<select id="complaintCategory" class="form-select" required>' +
                '<option value="">Select category</option>' +
                '<option value="plumbing">Plumbing</option>' +
                '<option value="electrical">Electrical</option>' +
                '<option value="cleaning">Cleaning & Sanitation</option>' +
                '<option value="security">Security</option>' +
                '<option value="other">Other</option>' +
                '</select>' +
                '<div class="form-error" id="complaintCategoryError">Please select a category</div>' +
                '</div>' +
                '<div class="form-group">' +
                '<label for="complaintDetails" class="form-label">Complaint Details <span class="required">*</span></label>' +
                '<textarea id="complaintDetails" class="form-textarea" placeholder="Describe your complaint in detail..." required></textarea>' +
                '<div class="form-error" id="complaintDetailsError">Please provide complaint details</div>' +
                '</div>' +
                '<div class="form-group">' +
                '<label for="contactNumber" class="form-label">Contact Number <span class="required">*</span></label>' +
                '<input type="tel" id="contactNumber" class="form-input" placeholder="Enter your mobile number" required>' +
                '<div class="form-error" id="contactNumberError">Please enter a valid contact number</div>' +
                '</div>' +
                '<div class="form-actions">' +
                '<button type="button" class="btn-secondary" id="cancelBtn">Cancel</button>' +
                '<button type="submit" class="btn-primary" id="submitBtn">Submit Complaint</button>' +
                '</div>' +
                '</form>'
        },
        booking: {
            title: 'Book Community Hall',
            html:
                '<form id="serviceForm">' +
                '<div class="form-group">' +
                '<label for="flatNo" class="form-label">Flat Number <span class="required">*</span></label>' +
                '<input type="text" id="flatNo" class="form-input" placeholder="e.g., A-101" required>' +
                '<div class="form-error" id="flatNoError">Please enter your flat number</div>' +
                '</div>' +
                '<div class="form-group">' +
                '<label for="residentName" class="form-label">Resident Name <span class="required">*</span></label>' +
                '<input type="text" id="residentName" class="form-input" placeholder="Enter your full name" required>' +
                '<div class="form-error" id="residentNameError">Please enter your name</div>' +
                '</div>' +
                '<div class="form-group">' +
                '<label for="eventDate" class="form-label">Event Date <span class="required">*</span></label>' +
                '<input type="date" id="eventDate" class="form-input" required>' +
                '<div class="form-error" id="eventDateError">Please select an event date</div>' +
                '</div>' +
                '<div class="form-group">' +
                '<label for="eventTime" class="form-label">Event Time <span class="required">*</span></label>' +
                '<select id="eventTime" class="form-select" required>' +
                '<option value="">Select time slot</option>' +
                '<option value="morning">Morning (9 AM - 1 PM)</option>' +
                '<option value="afternoon">Afternoon (2 PM - 6 PM)</option>' +
                '<option value="evening">Evening (6 PM - 10 PM)</option>' +
                '<option value="fullday">Full Day (9 AM - 10 PM)</option>' +
                '</select>' +
                '<div class="form-error" id="eventTimeError">Please select a time slot</div>' +
                '</div>' +
                '<div class="form-group">' +
                '<label for="eventType" class="form-label">Event Type <span class="required">*</span></label>' +
                '<input type="text" id="eventType" class="form-input" placeholder="e.g., Birthday Party, Wedding Reception" required>' +
                '<div class="form-error" id="eventTypeError">Please specify event type</div>' +
                '</div>' +
                '<div class="form-group">' +
                '<label for="guestCount" class="form-label">Expected Guest Count <span class="required">*</span></label>' +
                '<input type="number" id="guestCount" class="form-input" placeholder="Number of guests" required>' +
                '<div class="form-error" id="guestCountError">Please enter guest count</div>' +
                '</div>' +
                '<div class="form-actions">' +
                '<button type="button" class="btn-secondary" id="cancelBtn">Cancel</button>' +
                '<button type="submit" class="btn-primary" id="submitBtn">Submit Booking Request</button>' +
                '</div>' +
                '</form>'
        }
    };

    const messages = {
        payment: 'Payment request submitted successfully! You will be redirected to payment gateway.',
        complaint: 'Complaint registered successfully! Reference number will be sent to your mobile.',
        booking: 'Booking request submitted successfully! Committee will review and confirm within 24 hours.'
    };

    function getSuccessMessage(serviceType) {
        return messages[serviceType] || 'Request submitted successfully!';
    }

    function closeModal(modalOverlay) {
        modalOverlay.classList.remove('active');
    }

    function showToast(message) {
        const toast = document.getElementById('toastNotification');
        const toastMessage = document.getElementById('toastMessage');
        if (!toast || !toastMessage) return;

        toastMessage.textContent = message;
        toast.classList.add('active');

        setTimeout(function () {
            toast.classList.remove('active');
        }, 5000);
    }

    function handleFormSubmit(serviceType) {
        const form = document.getElementById('serviceForm');
        if (!form) return;

        let isValid = true;

        const errors = form.querySelectorAll('.form-error');
        errors.forEach(function (error) {
            error.classList.remove('active');
        });

        const inputs = form.querySelectorAll('[required]');
        inputs.forEach(function (input) {
            if (!input.value.trim()) {
                isValid = false;
                const errorEl = document.getElementById(input.id + 'Error');
                if (errorEl) {
                    errorEl.classList.add('active');
                }
            }
        });

        if (!isValid) return;

        const submitBtn = document.getElementById('submitBtn');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.textContent = 'Processing...';
        }

        setTimeout(function () {
            closeModal(document.getElementById('modalOverlay'));
            showToast(getSuccessMessage(serviceType));
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Submit';
            }
        }, 1000);
    }

    function openModal(serviceType) {
        const modalOverlay = document.getElementById('modalOverlay');
        const modalTitle = document.getElementById('modalTitle');
        const modalBody = document.getElementById('modalBody');
        const formData = serviceForms[serviceType];

        if (!modalOverlay || !modalTitle || !modalBody || !formData) return;

        modalTitle.textContent = formData.title;
        modalBody.innerHTML = formData.html;
        modalOverlay.classList.add('active');

        const form = document.getElementById('serviceForm');
        const cancelBtn = document.getElementById('cancelBtn');
        const submitBtn = document.getElementById('submitBtn');

        if (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                handleFormSubmit(serviceType);
            });
        }

        if (cancelBtn) {
            cancelBtn.addEventListener('click', function () {
                closeModal(modalOverlay);
            });
        }

        if (submitBtn) {
            submitBtn.addEventListener('click', function (e) {
                e.preventDefault();
                handleFormSubmit(serviceType);
            });
        }
    }

    function wireServiceCards() {
        const serviceCards = document.querySelectorAll('.service-card');
        serviceCards.forEach(function (card) {
            card.addEventListener('click', function () {
                const serviceType = card.getAttribute('data-service');
                if (serviceType === 'coming-soon') {
                    showToast('This service is coming soon! Stay tuned for updates.');
                } else if (serviceForms[serviceType]) {
                    openModal(serviceType);
                }
            });
        });
    }

    function wireModalClose() {
        const modalOverlay = document.getElementById('modalOverlay');
        const modalClose = document.getElementById('modalClose');

        if (modalClose) {
            modalClose.addEventListener('click', function () {
                if (modalOverlay) {
                    closeModal(modalOverlay);
                }
            });
        }

        if (modalOverlay) {
            modalOverlay.addEventListener('click', function (e) {
                if (e.target === modalOverlay) {
                    closeModal(modalOverlay);
                }
            });
        }
    }

    function init() {
        wireServiceCards();
        wireModalClose();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
