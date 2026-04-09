// Підключення функціоналу "Чертоги Фрілансера"
import { gotoBlock, FLS } from "@js/common/functions.js";
// Підключення функціоналу модуля форм
import { formValidate } from "../_functions.js";

import './form.scss';

function formInit() {
	function showFormMessage(form, type, message) {
		const box = form.querySelector('.form-message');
		if (!box) return;

		box.textContent = message;
		box.classList.remove('is-success', 'is-error');
		box.classList.add(type === 'success' ? 'is-success' : 'is-error');
	}

	function clearFormMessage(form) {
		const box = form.querySelector('.form-message');
		if (!box) return;

		box.textContent = '';
		box.classList.remove('is-success', 'is-error');
	}

	function setSubmittingState(form, isSubmitting) {
		const submitButton = form.querySelector('button[type="submit"], input[type="submit"]');

		if (isSubmitting) {
			form.classList.add('--sending');
			if (submitButton) {
				submitButton.disabled = true;
				if (!submitButton.dataset.originalText) {
					submitButton.dataset.originalText = submitButton.textContent;
				}
				if (submitButton.tagName === 'BUTTON') {
					submitButton.textContent = 'Wysyłanie...';
				}
			}
		} else {
			form.classList.remove('--sending');
			if (submitButton) {
				submitButton.disabled = false;
				if (submitButton.tagName === 'BUTTON' && submitButton.dataset.originalText) {
					submitButton.textContent = submitButton.dataset.originalText;
				}
			}
		}
	}

	function toggleFilledState(field) {
		if (!(field.tagName === 'INPUT' || field.tagName === 'TEXTAREA')) return;
		if (!field.parentElement) return;

		const hasValue = field.value.trim() !== '';

		field.classList.toggle('--has-value', hasValue);
		field.parentElement.classList.toggle('--has-value', hasValue);
	}

	function updateFormFilledState(form) {
		const fields = form.querySelectorAll('.input-contact');
		fields.forEach((field) => toggleFilledState(field));
	}

	function initFilledState() {
		const fields = document.querySelectorAll('.input-contact');

		fields.forEach((field) => {
			toggleFilledState(field);

			field.addEventListener('input', () => toggleFilledState(field));
			field.addEventListener('change', () => toggleFilledState(field));
		});

		setTimeout(() => {
			fields.forEach((field) => toggleFilledState(field));
		}, 100);

		setTimeout(() => {
			fields.forEach((field) => toggleFilledState(field));
		}, 500);
	}

	function normalizePhone(value) {
		if (!value) return '';

		let cleaned = value.trim();

		// Если номер начинается с 00, превращаем в +
		if (cleaned.startsWith('00')) {
			cleaned = '+' + cleaned.slice(2);
		}

		// Оставляем только цифры и +
		cleaned = cleaned.replace(/[^\d+]/g, '');

		// Плюс только в начале
		if (cleaned.includes('+')) {
			cleaned = '+' + cleaned.replace(/\+/g, '');
		}

		// Если пользователь ввел просто цифры без плюса, добавим +
		if (cleaned && !cleaned.startsWith('+')) {
			cleaned = '+' + cleaned;
		}

		return cleaned;
	}

	function isValidPhone(value) {
		const normalized = normalizePhone(value);
		return /^\+\d{7,15}$/.test(normalized);
	}

	function formatPhoneForDisplay(value) {
		const normalized = normalizePhone(value);
		if (!normalized) return '';

		const digits = normalized.slice(1);

		// Простая группировка для удобства чтения
		const groups = digits.match(/.{1,3}/g) || [];
		return '+' + groups.join(' ');
	}

	function initPhoneInputs() {
		const phoneInputs = document.querySelectorAll('[data-phone-input]');

		phoneInputs.forEach((input) => {
			input.addEventListener('focus', () => {
				if (!input.value.trim()) {
					input.value = '+';
					toggleFilledState(input);
				}
			});

			input.addEventListener('input', () => {
				let value = input.value;

				if (!value) {
					input.classList.remove('--form-error');
					input.parentElement?.classList.remove('--form-error');
					toggleFilledState(input);
					return;
				}

				value = normalizePhone(value);

				const digits = value.replace(/\D/g, '').slice(0, 15);
				input.value = digits ? `+${digits}` : '+';

				input.classList.remove('--form-error');
				input.parentElement?.classList.remove('--form-error');
				toggleFilledState(input);
			});

			input.addEventListener('blur', () => {
				const normalized = normalizePhone(input.value);

				if (normalized === '+') {
					input.value = '';
					toggleFilledState(input);
					return;
				}

				if (normalized && isValidPhone(normalized)) {
					input.value = normalized; // БЕЗ ПРОБЕЛОВ
				}
			});
		});
	}

	function formatFileSize(bytes) {
		if (bytes < 1024) return `${bytes} B`;
		if (bytes < 1024 * 1024) return `${(bytes / 1024).toFixed(1)} KB`;
		return `${(bytes / (1024 * 1024)).toFixed(1)} MB`;
	}

	function syncInputFiles(input) {
		const dt = new DataTransfer();
		const selectedFiles = input._selectedFiles || [];

		selectedFiles.forEach((file) => dt.items.add(file));
		input.files = dt.files;
	}

	function renderFileList(input) {
		console.log('NEW renderFileList loaded');
		const form = input.closest('form');
		const fileUpload = input.closest('.file-upload');
		const fileList = fileUpload?.querySelector('.file-list');

		if (!fileList) return;

		const removeLabel = input.dataset.removeLabel || 'Remove';
		const selectedFiles = input._selectedFiles || [];

		fileList.innerHTML = '';

		if (!selectedFiles.length) return;

		selectedFiles.forEach((file, index) => {
			const item = document.createElement('div');
			item.className = 'file-item';

			const info = document.createElement('div');
			info.className = 'file-item__info';

			const name = document.createElement('span');
			name.className = 'file-item__name';
			name.textContent = file.name;

			const size = document.createElement('span');
			size.className = 'file-item__size';
			size.textContent = formatFileSize(file.size);

			info.appendChild(name);
			info.appendChild(size);

			const removeBtn = document.createElement('button');
			removeBtn.type = 'button';
			removeBtn.className = 'file-item__remove';
			removeBtn.innerHTML = '';
			removeBtn.setAttribute('aria-label', `${removeLabel}: ${file.name}`);

			removeBtn.addEventListener('click', (e) => {
				e.preventDefault();
				e.stopPropagation();

				input._selectedFiles.splice(index, 1);
				syncInputFiles(input);
				renderFileList(input);

				if ((input._selectedFiles || []).length === 0) {
					clearFormMessage(form);
				}
			});

			item.appendChild(info);
			item.appendChild(removeBtn);
			fileList.appendChild(item);
		});
	}

	function initFileUploads() {
		console.log('NEW form.js loaded');
		const fileInputs = document.querySelectorAll('.input-file');

		fileInputs.forEach((input) => {
			input._selectedFiles = [];

			input.addEventListener('change', () => {
				const form = input.closest('form');
				const selectedFiles = input._selectedFiles || [];
				const incomingFiles = Array.from(input.files || []);

				const maxFiles = parseInt(input.dataset.maxFiles || '10', 10);
				const maxFileSize = parseInt(input.dataset.maxFileSize || String(5 * 1024 * 1024), 10);
				const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

				const messages = [];
				const nextFiles = [...selectedFiles];

				incomingFiles.forEach((file) => {
					if (!allowedTypes.includes(file.type)) {
						messages.push(input.dataset.errorInvalidType || 'Invalid file type.');
						return;
					}

					if (file.size > maxFileSize) {
						messages.push(input.dataset.errorTooLarge || 'File is too large.');
						return;
					}

					if (nextFiles.length >= maxFiles) {
						messages.push(input.dataset.errorTooMany || 'Too many files.');
						return;
					}

					const exists = nextFiles.some(
						(item) =>
							item.name === file.name &&
							item.size === file.size &&
							item.lastModified === file.lastModified
					);

					if (!exists) {
						nextFiles.push(file);
					}
				});

				input._selectedFiles = nextFiles;
				syncInputFiles(input);
				renderFileList(input);

				if (messages.length) {
					showFormMessage(form, 'error', messages[0]);
				} else {
					clearFormMessage(form);
				}
			});
		});
	}

	function formSubmit() {
		const forms = document.forms;
		if (forms.length) {
			for (const form of forms) {
				!form.hasAttribute('data-fls-form-novalidate') ? form.setAttribute('novalidate', true) : null;

				form.addEventListener('submit', function (e) {
					const currentForm = e.target;
					formSubmitAction(currentForm, e);
				});

				form.addEventListener('reset', function (e) {
					const currentForm = e.target;
					clearFormMessage(currentForm);

					const fileInputs = currentForm.querySelectorAll('.input-file');
					fileInputs.forEach((input) => {
						input._selectedFiles = [];
						input.value = '';
						syncInputFiles(input);
					});

					const fileLists = currentForm.querySelectorAll('.file-list');
					fileLists.forEach((list) => {
						list.innerHTML = '';
					});

					setTimeout(() => {
						updateFormFilledState(currentForm);
					}, 0);
				});
			}
		}

		async function formSubmitAction(form, e) {
			clearFormMessage(form);

			const phoneInput = form.querySelector('[data-phone-input]');
			if (phoneInput) {
				const normalizedPhone = normalizePhone(phoneInput.value);

				if (!isValidPhone(normalizedPhone)) {
					e.preventDefault();
					showFormMessage(form, 'error', phoneInput.dataset.phoneError || 'Invalid phone number.');
					phoneInput.classList.add('--form-error');
					phoneInput.parentElement?.classList.add('--form-error');
					return;
				}

				phoneInput.value = normalizedPhone;
			}

			const error = formValidate.getErrors(form);

			if (error === 0) {
				if (form.dataset.flsForm === 'ajax') {
					e.preventDefault();

					const formAction = form.getAttribute('action') ? form.getAttribute('action').trim() : '#';
					const formMethod = form.getAttribute('method') ? form.getAttribute('method').trim() : 'GET';
					const formData = new FormData();

					const elements = Array.from(form.elements);

					elements.forEach((element) => {
						if (!element.name || element.disabled) return;

						if (element.type === 'file') {
							const files = element._selectedFiles || [];
							files.forEach((file) => {
								formData.append(element.name, file);
							});
							return;
						}

						if ((element.type === 'checkbox' || element.type === 'radio') && !element.checked) {
							return;
						}

						formData.append(element.name, element.value);
					});

					formData.set('page_url', window.location.href);

					setSubmittingState(form, true);

					try {
						const response = await fetch(formAction, {
							method: formMethod,
							body: formData
						});

						const responseResult = await response.json();

						setSubmittingState(form, false);

						if (response.ok && responseResult.status === 'success') {
							formSent(form, responseResult);
						} else {
							showFormMessage(form, 'error', responseResult.message || 'Failed to send form.');
							FLS("_FLS_FORM_AJAX_ERR");
						}
					} catch (error) {
						setSubmittingState(form, false);
						showFormMessage(form, 'error', 'Wystąpił błąd. Spróbuj ponownie.');
						FLS(`(!!) ${error.message}`);
					}
				} else if (form.dataset.flsForm === 'dev') {
					e.preventDefault();
					formSent(form);
					showFormMessage(form, 'success', 'Form sent successfully.');
				}
			} else {
				e.preventDefault();

				showFormMessage(form, 'error', 'Uzupełnij wymagane pola.');

				if (form.querySelector('.--form-error') && form.hasAttribute('data-fls-form-gotoerr')) {
					const formGoToErrorClass = form.dataset.flsFormGotoerr ? form.dataset.flsFormGotoerr : '.--form-error';
					gotoBlock(formGoToErrorClass);
				}
			}
		}

		function formSent(form, responseResult = ``) {
			document.dispatchEvent(new CustomEvent("formSent", {
				detail: {
					form: form,
					response: responseResult
				}
			}));

			setTimeout(() => {
				if (window.flsPopup) {
					const popup = form.dataset.flsFormPopup;
					popup ? window.flsPopup.open(popup) : null;
				}
			}, 0);

			setTimeout(() => {
				formValidate.formClean(form);

				const fileInputs = form.querySelectorAll('.input-file');
				fileInputs.forEach((input) => {
					input._selectedFiles = [];
					input.value = '';
					syncInputFiles(input);
				});

				const fileLists = form.querySelectorAll('.file-list');
				fileLists.forEach((list) => {
					list.innerHTML = '';
				});

				clearFormMessage(form);
				updateFormFilledState(form);
			}, 1500);

			FLS(`_FLS_FORM_SEND`);
		}
	}

	function formFieldsInit() {
		document.body.addEventListener("focusin", function (e) {
			const targetElement = e.target;
			if ((targetElement.tagName === 'INPUT' || targetElement.tagName === 'TEXTAREA')) {
				if (!targetElement.hasAttribute('data-fls-form-nofocus')) {
					targetElement.classList.add('--form-focus');
					targetElement.parentElement.classList.add('--form-focus');
				}
				targetElement.hasAttribute('data-fls-form-validatenow') ? formValidate.removeError(targetElement) : null;
				toggleFilledState(targetElement);
			}
		});

		document.body.addEventListener("focusout", function (e) {
			const targetElement = e.target;
			if ((targetElement.tagName === 'INPUT' || targetElement.tagName === 'TEXTAREA')) {
				if (!targetElement.hasAttribute('data-fls-form-nofocus')) {
					targetElement.classList.remove('--form-focus');
					targetElement.parentElement.classList.remove('--form-focus');
				}
				targetElement.hasAttribute('data-fls-form-validatenow') ? formValidate.validateInput(targetElement) : null;
				toggleFilledState(targetElement);
			}
		});
	}

	formSubmit();
	formFieldsInit();
	initFilledState();
	initPhoneInputs();
	initFileUploads();
}

document.querySelector('[data-fls-form]') ?
	window.addEventListener('load', formInit) : null;