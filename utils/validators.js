// Input Validation Helper Functions
// These functions validate common user inputs

/**
 * Validate email format using regex
 * @param {String} email - Email to validate
 * @returns {Boolean} True if valid, false otherwise
 */
const validateEmail = (email) => {
  const regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  return regex.test(email);
};

/**
 * Validate password minimum length (6 characters)
 * @param {String} password - Password to validate
 * @returns {Boolean} True if valid, false otherwise
 */
const validatePassword = (password) => {
  return password && password.length >= 6;
};

/**
 * Validate price is a non-negative number
 * @param {Number} price - Price to validate
 * @returns {Boolean} True if valid, false otherwise
 */
const validatePrice = (price) => {
  return typeof price === 'number' && price >= 0;
};

/**
 * Validate seat capacity is a positive number
 * @param {Number} capacity - Seat capacity to validate
 * @returns {Boolean} True if valid (> 0), false otherwise
 */
const validateSeatCapacity = (capacity) => {
  return typeof capacity === 'number' && capacity > 0;
};

/**
 * Validate quantity is a positive number
 * @param {Number} quantity - Quantity to validate
 * @returns {Boolean} True if valid (> 0), false otherwise
 */
const validateQuantity = (quantity) => {
  return typeof quantity === 'number' && quantity > 0;
};

module.exports = {
  validateEmail,
  validatePassword,
  validatePrice,
  validateSeatCapacity,
  validateQuantity,
};
