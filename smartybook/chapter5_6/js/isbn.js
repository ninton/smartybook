/**
 * @param {string} src
 * @returns {string}
 */
export function isbn13_to_isbn10(src) {
  if (!is_isbn13(src)) {
    return src;
  }

  const body = src.substring(3, 12);
  const cd = calc_isbn10_cd(body);
  return body + cd;
}

// noinspection JSUnusedGlobalSymbols
/**
 * @param {string} src
 * @returns {string}
 */
export function isbn10_to_isbn13(src) {
  if (!is_isbn10(src)) {
    return src;
  }

  const body = '978' + src.substring(0, 9);
  const cd = calc_isbn13_cd(body);
  return body + cd;
}

/**
 * @param {string} str
 * @returns {boolean}
 */
function is_isbn13(str) {
  if (str.search(/^978[0-9]{10}$/) < 0) {
    return false;
  }

  const cd = calc_isbn13_cd(str);
  return cd === str.substring(12, 13);
}

/**
 * @param {string} str
 * @returns {boolean}
 */
function is_isbn10(str) {
  if (str.search(/^[0-9]{9}[0-9X]$/) < 0) {
    return false;
  }

  const cd = calc_isbn10_cd(str);
  return cd === str.substring(9, 10);
}

/**
 *	n11 n12 n13  - n1 - n2 n3 n4 n5 - n6 n7 n8 n9 - n10
 *	n10 = 10 - (n11x1 + n12x3 + n13x1 + n1x3 +
 *    	        n2 x1  + n3x3 + n4 x1 + n5x3 +
 *        	    n8 x1  + n7x3 + n8 x1 + n9x3) % 10
 *
 * @param {string} str
 * @returns {string}
 */
function calc_isbn13_cd(str) {
  let sum = 0;

  for (let i = 0; i < 12; ++i) {
    sum += parseInt(str.charAt(i), 10) * (i % 2 ? 3 : 1);
  }

  let cd = 10 - (sum % 10);
  if (cd === 10) {
    cd = 0;
  }

  return String(cd);
}

/**
 *	n1 - n2 n3 n4 n5 - n6 n7 n8 n9 - n10
 *	n10 = 11 - (n1x10 + n2x9 + n3x8 + n4x7 + n5x6 + n6x5 + n7x4 + n8x3 + n9x2) % 11
 *	(n11==11のときは 0、n10==10 のときは "X" とする)
 *
 * @param {string} str
 * @returns {string}
 */
function calc_isbn10_cd(str) {
  let sum = 0;

  for (let i = 0; i < 9; ++i) {
    sum += parseInt(str.charAt(i), 10) * (10 - i);
  }

  let rawCd = 11 - (sum % 11);
  /** @type {string} */
  let cd;

  switch (rawCd) {
    case 11:
      cd = '0';
      break;

    case 10:
      cd = 'X';
      break;

    default:
      cd = String(rawCd);
      break;
  }

  return cd;
}
