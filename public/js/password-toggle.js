document.addEventListener('DOMContentLoaded', function() {
  const toggles = document.querySelectorAll('.pwd-toggle');

  const eye = {
    on: '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12z" stroke="#333" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="12" r="3" stroke="#333" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
    off: '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17.94 17.94A10.94 10.94 0 0 1 12 19c-6 0-10-7-10-7a17.69 17.69 0 0 1 4.11-5.05" stroke="#333" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/><path d="M1 1l22 22" stroke="#333" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>'
  };

  toggles.forEach(btn => {
    btn.dataset.visible = 'false';
    btn.innerHTML = eye.on;

    btn.addEventListener('click', function() {
      const wrapper = btn.closest('.password-wrapper');
      const input = wrapper.querySelector('input');

      const isVisible = btn.dataset.visible === 'true';

      if (isVisible) {
        input.type = 'password';
        btn.innerHTML = eye.on;
        btn.dataset.visible = 'false';
      } else {
        input.type = 'text';
        btn.innerHTML = eye.off;
        btn.dataset.visible = 'true';
      }
      input.focus();
    });
  });
});
