// JWT Token Generation & Response Utilities
const jwt = require('jsonwebtoken');

/**
 * Generate JWT token for a user
 * Token contains user ID and expires after JWT_EXPIRE time (default 7 days)
 * @param {String} id - User MongoDB ObjectId
 * @returns {String} Signed JWT token
 */
const generateToken = (id) => {
  return jwt.sign({ id }, process.env.JWT_SECRET, {
    expiresIn: process.env.JWT_EXPIRE || '7d',
  });
};

/**
 * Create JWT token and send standardized JSON response
 * Used after successful register/login
 * @param {Object} user - User document from MongoDB
 * @param {Number} statusCode - HTTP status code (201 for register, 200 for login)
 * @param {Object} res - Express response object
 */
const sendTokenResponse = (user, statusCode, res) => {
  // Generate new token
  const token = generateToken(user._id);

  // Send response with token and user data
  res.status(statusCode).json({
    success: true,
    token,
    user: {
      id: user._id,
      name: user.name,
      email: user.email,
      role: user.role,
    },
  });
};

module.exports = {
  generateToken,
  sendTokenResponse,
};
