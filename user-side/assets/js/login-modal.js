document.addEventListener('DOMContentLoaded', function() {
    // Toggle Member Password
    const toggleMemberPassword = document.getElementById('togglePassword');
    const memberPasswordInput = document.getElementById('loginPassword');
    
    if (toggleMemberPassword && memberPasswordInput) {
        toggleMemberPassword.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const currentType = memberPasswordInput.getAttribute('type');
            const newType = currentType === 'password' ? 'text' : 'password';
            
            memberPasswordInput.setAttribute('type', newType);
            
            const icon = this.querySelector('i');
            if (icon) {
                if (newType === 'text') {
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            }
            
            return false;
        });
    }
    
    // Toggle Confirm Password
    const toggleOfficePassword = document.getElementById('toggleOfficePassword');
    const officePasswordInput = document.getElementById('officeLoginPassword');
    
    if (toggleOfficePassword && officePasswordInput) {
        toggleOfficePassword.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const currentType = officePasswordInput.getAttribute('type');
            const newType = currentType === 'password' ? 'text' : 'password';
            
            officePasswordInput.setAttribute('type', newType);
            
            const icon = this.querySelector('i');
            if (icon) {
                if (newType === 'text') {
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            }
            
            return false;
        });
    }
});