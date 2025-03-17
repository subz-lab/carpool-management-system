// script.js
document.addEventListener('DOMContentLoaded', function () {
    // Handle modals
    const editProfileBtn = document.getElementById('editProfileBtn');
    const editProfileModal = document.getElementById('editProfileModal');
    const closeModal = document.querySelector('.modal-content .close');
  
    if (editProfileBtn && editProfileModal && closeModal) {
      editProfileBtn.addEventListener('click', () => {
        editProfileModal.style.display = 'block';
      });
  
      closeModal.addEventListener('click', () => {
        editProfileModal.style.display = 'none';
      });
  
      window.addEventListener('click', (e) => {
        if (e.target === editProfileModal) {
          editProfileModal.style.display = 'none';
        }
      });
    }
  
    // Basic form validation
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
      registerForm.addEventListener('submit', (e) => {
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirmPassword');
        if (password.value !== confirmPassword.value) {
          e.preventDefault();
          alert('Passwords do not match!');
        }
      });
    }
  });
  // Toggle dark mode
document.getElementById('dark-mode-toggle').addEventListener('click', () => {
  document.documentElement.setAttribute('data-bs-theme', 
    document.documentElement.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark'
  );
});