    const otpInputs = document.querySelectorAll('.otp-input');
    const form = document.getElementById('otpForm');
    const otpError = document.getElementById('otpError');

    // Auto focus logic
    otpInputs.forEach((input, index) => {
      input.addEventListener('input', () => {
        if (input.value.length === 1 && index < otpInputs.length - 1) {
          otpInputs[index + 1].focus();
        }
      });

      input.addEventListener('keydown', (e) => {
        if (e.key === 'Backspace' && !input.value && index > 0) {
          otpInputs[index - 1].focus();
        }
      });
    });

    // Allow paste of entire code
    form.addEventListener('paste', (e) => {
      e.preventDefault();
      const pasteData = e.clipboardData.getData('text').replace(/\D/g, '').slice(0, 6);
      otpInputs.forEach((input, i) => {
        input.value = pasteData[i] || '';
      });
    });

    // Validate and handle submit
    form.addEventListener('submit', (e) => {
     
      const code = Array.from(otpInputs).map(input => input.value).join('');

      if (code.length !== 6) {
        e.preventDefault();
        otpError.textContent = 'Please enter a 6-digit code.';
        
      } else {
        otpError.textContent = '';
      }
    });

    // Handle resend
    document.getElementById('resendBtn').addEventListener('click', (e) => {
      e.preventDefault();
      alert("A new code has been sent.");
      // Trigger resend logic here
    });