// Contact page interactions

document.addEventListener('DOMContentLoaded', () => {
    initElementSdk();
    wireForm();
});

function initElementSdk() {
    if (!window.dwolla || !window.dwolla.configure) {
        console.warn('Element SDK not available.');
        return;
    }
    // Configure sandbox for now; swap to prod key when ready
    window.dwolla.configure({ environment: 'sandbox', apiKey: 'sandbox_bnf6tb6wyk0hzz2w99pqgy9nhlg5hjkz' });
}

function wireForm() {
    const form = document.querySelector('#contactForm');
    const toast = document.querySelector('.toast-notification');
    const toastMessage = toast?.querySelector('.toast-message');
    const submitBtn = form?.querySelector('.btn-submit');

    if (!form) return;

    form.addEventListener('submit', event => {
        event.preventDefault();
        const formData = new FormData(form);
        const errors = validate(formData);

        clearErrors(form);
        if (errors.length) {
            showErrors(form, errors);
            return;
        }

        submitBtn?.setAttribute('disabled', 'true');

        fetch(window.location.href, {
            method: 'POST',
            body: formData
        })
        .then(response => {
            console.log('Response Status:', response.status);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.text().then(text => {
                console.log('Raw Response:', text);
                try {
                    return JSON.parse(text);
                } catch (e) {
                    console.error('JSON Parse Error:', e);
                    console.error('Response was:', text);
                    throw new Error('Invalid JSON response from server');
                }
            });
        })
        .then(data => {
            console.log('Parsed Data:', data);
            if (data.status === 'success') {
                showToast(toast, toastMessage, data.message);
                form.reset();
            } else {
                showToast(toast, toastMessage, data.message, true);
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            showToast(toast, toastMessage, 'Something went wrong. Please try again.', true);
        })
        .finally(() => {
            submitBtn?.removeAttribute('disabled');
        });
    });
}

function validate(formData) {
    const errors = [];
    const requiredFields = [
        ['contact_fullName', 'Please enter your name.'],
        ['contact_flatNumber', 'Please enter your flat number.'],
        ['contact_email', 'Please enter your email.'],
        ['contact_phone', 'Please enter your phone number.'],
        ['contact_subject', 'Please select a subject.'],
        ['contact_message', 'Please enter your message.']
    ];

    requiredFields.forEach(([field, message]) => {
        const value = (formData.get(field) || '').toString().trim();
        if (!value) errors.push({ field, message });
    });

    return errors;
}

function showErrors(form, errors) {
    errors.forEach(({ field, message }) => {
        const errorEl = form.querySelector(`#${field}Error`);
        if (errorEl) {
            errorEl.textContent = message;
            errorEl.classList.add('active');
        }
    });
}

function clearErrors(form) {
    form.querySelectorAll('.form-error').forEach(el => {
        el.textContent = '';
        el.classList.remove('active');
    });
}

function showToast(toast, toastMessage, message, isError = false) {
    if (!toast || !toastMessage) return;
    toastMessage.textContent = message;
    toast.style.background = isError ? '#dc3545' : '#198754';
    toast.classList.add('active');
    setTimeout(() => toast.classList.remove('active'), 2600);
}