import { isbn13_to_isbn10 } from './isbn.js';

const isbnInputs = document.querySelectorAll('.js-input-isbn');
isbnInputs.forEach((input) => {
  input.addEventListener('change', (event) => {
    const inputElement = /** @type {HTMLInputElement} */ (event.target);
    inputElement.value = isbn13_to_isbn10(inputElement.value);
  });
});
