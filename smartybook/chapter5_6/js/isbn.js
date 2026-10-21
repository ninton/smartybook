/**
 * @param {string} i_src
 * @returns {string}
 */
function isbn13_to_isbn10(i_src) {
  var dst;

  if (is_isbn13(i_src)) {
    var body = i_src.substr(3, 9);
    var cd = calc_isbn10_cd(body);
    dst = body + cd;
  } else {
    dst = i_src;
  }

  return dst;
}

/**
 * @param {string} i_src
 * @returns {string}
 */
function isbn10_to_isbn13(i_src) {
  var dst;

  if (is_isbn10(i_src)) {
    var body = '978' + i_src.substr(0, 9);
    var cd = calc_isbn13_cd(body);
    dst = body + cd;
  } else {
    dst = i_src;
  }

  return dst;
}

/**
 * @param {string} i_str
 * @returns {boolean}
 */
function is_isbn13(i_str) {
  if (i_str.search(/^978[0-9]{10}$/) < 0) {
    return false;
  }

  var cd = calc_isbn13_cd(i_str);
  return cd == i_str.substr(12, 1);
}

/**
 * @param {string} i_str
 * @returns {boolean}
 */
function is_isbn10(i_str) {
  if (i_str.search(/^[0-9]{9}[0-9X]$/) < 0) {
    return false;
  }

  var cd = calc_isbn10_cd(i_str);
  return cd == i_str.substr(9, 1);
}

/**
 *	n11 n12 n13  - n1 - n2 n3 n4 n5 - n6 n7 n8 n9 - n10
 *	n10 = 10 - (n11x1 + n12x3 + n13x1 + n1x3 +
 *    	        n2 x1  + n3x3 + n4 x1 + n5x3 +
 *        	    n8 x1  + n7x3 + n8 x1 + n9x3) % 10
 *
 * @param {string} i_str
 * @returns {string}
 */
function calc_isbn13_cd(i_str) {
  var sum = 0;

  for (var i = 0; i < 12; ++i) {
    sum += parseInt(i_str.charAt(i), 10) * (i % 2 ? 3 : 1);
  }

  let cd = 10 - (sum % 10);
  if (10 == cd) {
    cd = 0;
  }

  return String(cd);
}

/**
 *	n1 - n2 n3 n4 n5 - n6 n7 n8 n9 - n10
 *	n10 = 11 - (n1x10 + n2x9 + n3x8 + n4x7 + n5x6 + n6x5 + n7x4 + n8x3 + n9x2) % 11
 *	(n11==11のときは 0、n10==10 のときは "X" とする)
 *
 * @param {string} i_str
 * @returns {string}
 */
function calc_isbn10_cd(i_str) {
  var sum = 0;

  for (var i = 0; i < 9; ++i) {
    sum += parseInt(i_str.charAt(i), 10) * (10 - i);
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

  return String(cd);
}
