(function () {
  if (window._jobUtsavAlertModalLoaded) return;
  window._jobUtsavAlertModalLoaded = true;

  var css = "#alertModalOverlay{position:fixed;inset:0;z-index:9999;display:flex;align-items:center;justify-content:center;padding:16px;opacity:0;visibility:hidden;pointer-events:none;transition:opacity 0.28s ease,visibility 0.28s ease}#alertModalOverlay.open{opacity:1;visibility:visible;pointer-events:auto}#alertModalOverlay .alert-modal-backdrop{position:absolute;inset:0;background:rgba(11,26,51,0.62);backdrop-filter:blur(6px);-webkit-backdrop-filter:blur(6px)}#alertModalOverlay .alert-modal{position:relative;z-index:1;background:#fff;border-radius:24px;padding:36px 32px 32px;width:100%;max-width:480px;box-shadow:0 32px 80px rgba(11,26,51,0.22),0 0 0 1px rgba(244,123,32,0.12);transform:translateY(22px) scale(0.97);transition:transform 0.32s cubic-bezier(.22,1,.36,1)}#alertModalOverlay.open .alert-modal{transform:translateY(0) scale(1)}.alert-modal-close{position:absolute;top:16px;right:16px;width:34px;height:34px;border-radius:50%;border:1px solid rgba(15,23,42,0.12);background:#f6f7f9;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:16px;color:#64748b;transition:background 0.15s ease,color 0.15s ease,transform 0.15s ease;line-height:1}.alert-modal-close:hover{background:rgba(244,123,32,0.1);color:var(--orange);transform:rotate(90deg)}.alert-modal-header{margin-bottom:6px}.alert-modal-title{margin:0;font-size:22px;font-weight:800;letter-spacing:-0.3px;color:#0f172a;line-height:1.2}.alert-modal-subtitle{margin:10px 0 0;font-size:13.5px;color:#64748b;line-height:1.75}.alert-modal-divider{height:1px;background:rgba(15,23,42,0.07);margin:18px 0}.alert-form-grid{display:grid;gap:14px}.alert-field{display:flex;flex-direction:column;gap:6px}.alert-field label{font-size:12.5px;font-weight:700;color:#334155;letter-spacing:0.02em}.alert-field input,.alert-field select{height:44px;padding:0 14px;border-radius:12px;border:1.5px solid rgba(15,23,42,0.12);background:#f8fafc;font-family:inherit;font-size:14px;color:#0f172a;outline:none;transition:border-color 0.18s ease,box-shadow 0.18s ease,background 0.18s ease;-webkit-appearance:none;appearance:none}.alert-field select{background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 12px center;padding-right:36px;cursor:pointer}.alert-field input:focus,.alert-field select:focus{border-color:var(--orange);background:#fff;box-shadow:0 0 0 3px rgba(244,123,32,0.12)}.alert-field input::placeholder{color:#94a3b8}.alert-field input.error,.alert-field select.error{border-color:#ef4444;box-shadow:0 0 0 3px rgba(239,68,68,0.10)}.alert-field-error{font-size:11.5px;color:#ef4444;font-weight:600;display:none;margin-top:2px}.alert-field.has-error .alert-field-error{display:block}.alert-form-row{display:grid;grid-template-columns:1fr 1fr;gap:12px}.alert-modal-actions{display:flex;gap:10px;margin-top:22px}.alert-btn-cancel{flex:1;height:46px;border-radius:13px;border:1.5px solid rgba(15,23,42,0.12);background:#fff;font-family:inherit;font-size:14px;font-weight:700;color:#475569;cursor:pointer;transition:background 0.15s ease,border-color 0.15s ease,transform 0.15s ease}.alert-btn-cancel:hover{background:#f1f5f9;border-color:rgba(15,23,42,0.18);transform:translateY(-1px)}.alert-btn-submit{flex:1.6;height:46px;border-radius:13px;border:none;background:linear-gradient(135deg,#f47b20 0%,#ff9a3c 100%);color:#fff;font-family:inherit;font-size:14px;font-weight:800;cursor:pointer;box-shadow:0 12px 28px rgba(244,123,32,0.32);transition:transform 0.15s ease,box-shadow 0.15s ease,filter 0.15s ease;letter-spacing:0.01em}.alert-btn-submit:hover{transform:translateY(-2px);box-shadow:0 18px 36px rgba(244,123,32,0.40);filter:brightness(1.05)}.alert-btn-submit:active{transform:translateY(0)}.alert-modal-success{display:none;text-align:center;padding:12px 0 4px}.alert-modal-success .success-icon{width:64px;height:64px;border-radius:50%;background:linear-gradient(135deg,rgba(244,123,32,0.12),rgba(255,138,42,0.06));border:2px solid rgba(244,123,32,0.22);display:flex;align-items:center;justify-content:center;font-size:28px;margin:0 auto 16px}.alert-modal-success h3{margin:0 0 8px;font-size:20px;font-weight:800;color:#0f172a}.alert-modal-success p{margin:0;font-size:14px;color:#64748b;line-height:1.7}.alert-modal-success .done-btn{margin-top:20px;height:44px;padding:0 28px;border-radius:12px;border:none;background:linear-gradient(135deg,#f47b20 0%,#ff9a3c 100%);color:#fff;font-family:inherit;font-size:14px;font-weight:800;cursor:pointer;box-shadow:0 10px 22px rgba(244,123,32,0.28);transition:transform 0.15s ease,box-shadow 0.15s ease}.alert-modal-success .done-btn:hover{transform:translateY(-2px);box-shadow:0 16px 30px rgba(244,123,32,0.36)}body.modal-open{overflow:hidden}@media (max-width:520px){.alert-modal{padding:28px 20px 24px;border-radius:20px}.alert-form-row{grid-template-columns:1fr}.alert-modal-title{font-size:19px}}";

  var style = document.createElement('style');
  style.type = 'text/css';
  style.appendChild(document.createTextNode(css));
  document.head.appendChild(style);

  var overlay = document.createElement('div');
  overlay.id = 'alertModalOverlay';
  overlay.setAttribute('role', 'dialog');
  overlay.setAttribute('aria-modal', 'true');
  overlay.setAttribute('aria-labelledby', 'alertModalTitle');
  overlay.innerHTML = '\n    <div class="alert-modal-backdrop"></div>\n    <div class="alert-modal" role="document">\n      <button type="button" class="alert-modal-close" aria-label="Close alert modal">\n        <span aria-hidden="true">×</span>\n      </button>\n      <div class="alert-modal-header">\n        <h2 id="alertModalTitle" class="alert-modal-title">Get updates for upcoming cities</h2>\n        <p class="alert-modal-subtitle">Register your details and we will send you city alerts as soon as registrations open.</p>\n      </div>\n      <div class="alert-modal-divider"></div>\n      <div class="alert-modal-form-panel">\n        <form class="alert-modal-form">\n          <div class="alert-form-grid">\n            <div class="alert-field">\n              <label for="alertName">Your Name</label>\n              <input type="text" id="alertName" name="name" placeholder="e.g. Rahul Sharma" autocomplete="name" maxlength="60" required />\n              <div class="alert-field-error">Please enter your name.</div>\n            </div>\n            <div class="alert-field">\n              <label for="alertEmail">Email address</label>\n              <input type="email" id="alertEmail" name="email" placeholder="e.g. rahul@example.com" autocomplete="email" required />\n              <div class="alert-field-error">Please enter a valid email address.</div>\n            </div>\n            <div class="alert-field">\n              <label for="alertPhone">Mobile Number</label>\n              <input type="tel" id="alertPhone" name="phone" placeholder="e.g. 8882866024" autocomplete="tel" required />\n              <div class="alert-field-error">Please enter a valid mobile number.</div>\n            </div>\n            <div class="alert-field">\n              <label for="alertCity">Preferred City</label>\n              <select id="alertCity" name="city" required>\n                <option value="">Select city</option>\n                <option value="Mumbai">Mumbai</option>\n                <option value="Bangalore">Bangalore</option>\n                <option value="Hyderabad">Hyderabad</option>\n                <option value="Chennai">Chennai</option>\n                <option value="Pune">Pune</option>\n                <option value="Kolkata">Kolkata</option>\n                <option value="Ahmedabad">Ahmedabad</option>\n              </select>\n              <div class="alert-field-error">Please select a city.</div>\n            </div>\n          </div>\n          <div class="alert-modal-actions">\n            <button type="button" class="alert-btn-cancel">Cancel</button>\n            <button type="submit" class="alert-btn-submit">Notify Me</button>\n          </div>\n        </form>\n      </div>\n      <div class="alert-modal-success" role="status" aria-live="polite">\n        <div class="success-icon">✓</div>\n        <h3>Thanks! You are all set.</h3>\n        <p>We will let you know when your chosen city opens for registration.</p>\n        <button type="button" class="done-btn">Done</button>\n      </div>\n    </div>\n  ";
  document.body.appendChild(overlay);

  var body = document.body;
  var citySelect = document.getElementById('alertCity');
  var nameInput = document.getElementById('alertName');
  var emailInput = document.getElementById('alertEmail');
  var phoneInput = document.getElementById('alertPhone');
  var form = overlay.querySelector('.alert-modal-form');
  var successPanel = overlay.querySelector('.alert-modal-success');
  var formPanel = overlay.querySelector('.alert-modal-form-panel');
  var closeBtn = overlay.querySelector('.alert-modal-close');
  var cancelBtn = overlay.querySelector('.alert-btn-cancel');
  var doneBtn = overlay.querySelector('.done-btn');
  var backdrop = overlay.querySelector('.alert-modal-backdrop');

  function setFieldError(field, message) {
    if (!field) return;
    var wrapper = field.closest('.alert-field');
    if (!wrapper) return;
    var error = wrapper.querySelector('.alert-field-error');
    wrapper.classList.add('has-error');
    if (error) error.textContent = message;
  }

  function clearFieldError(field) {
    if (!field) return;
    var wrapper = field.closest('.alert-field');
    if (!wrapper) return;
    wrapper.classList.remove('has-error');
  }

  function clearErrors() {
    [nameInput, emailInput, phoneInput, citySelect].forEach(clearFieldError);
  }

  function validateForm() {
    clearErrors();
    var valid = true;
    if (!nameInput.value.trim()) {
      valid = false;
      setFieldError(nameInput, 'Please enter your name.');
    }
    var emailValue = emailInput.value.trim();
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailValue)) {
      valid = false;
      setFieldError(emailInput, 'Please enter a valid email address.');
    }
    var phoneValue = phoneInput.value.trim();
    if (!/^\d{10,15}$/.test(phoneValue)) {
      valid = false;
      setFieldError(phoneInput, 'Please enter a valid mobile number.');
    }
    if (!citySelect.value) {
      valid = false;
      setFieldError(citySelect, 'Please select a city.');
    }
    return valid;
  }

  function closeModal() {
    overlay.classList.remove('open');
    body.classList.remove('modal-open');
  }

  function openModal(city) {
    if (!overlay) return;
    overlay.classList.add('open');
    body.classList.add('modal-open');
    if (city && citySelect) {
      if (Array.from(citySelect.options).some(function (opt) { return opt.value === city; })) {
        citySelect.value = city;
      }
    }
    if (formPanel) formPanel.style.display = '';
    if (successPanel) successPanel.style.display = 'none';
    if (nameInput) {
      setTimeout(function () {
        nameInput.focus();
      }, 80);
    }
  }

  function showSuccess() {
    if (formPanel) formPanel.style.display = 'none';
    if (successPanel) successPanel.style.display = 'block';
  }

  if (closeBtn) closeBtn.addEventListener('click', function (e) { e.preventDefault(); closeModal(); });
  if (cancelBtn) cancelBtn.addEventListener('click', function () { closeModal(); });
  if (doneBtn) doneBtn.addEventListener('click', function () { closeModal(); });
  if (backdrop) backdrop.addEventListener('click', function () { closeModal(); });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && overlay.classList.contains('open')) {
      closeModal();
    }
  });

  if (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      if (!validateForm()) return;
      showSuccess();
      form.reset();
    });
  }

  function handleLinkClick(e) {
    if (!overlay) return;
    e.preventDefault();
    openModal(e.currentTarget.getAttribute('data-city') || '');
  }

  document.querySelectorAll('.comingSoonLink').forEach(function (link) {
    link.addEventListener('click', handleLinkClick);
  });

  document.querySelectorAll('.alert-btn').forEach(function (btn) {
    if (!btn.hasAttribute('data-city')) {
      btn.addEventListener('click', function (e) {
        e.preventDefault();
        openModal('');
      });
    }
  });

  window.openAlertModal = openModal;
  window.closeAlertModal = closeModal;
})();
