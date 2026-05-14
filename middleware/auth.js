// JWT Authentication & Authorization Middleware
const jwt = require('jsonwebtoken');
const User = require('../models/User');

/**
 * Middleware to protect routes and verify JWT token
 * Extracts token from Authorization header (Bearer token)
 * Verifies token signature and loads user from database
 * Sets req.user for use in subsequent middleware/controllers
 */
exports.protect = async (req, res, next) => {
  let token;

  // Extract token from Authorization header (format: Bearer <token>)
  if (req.headers.authorization && req.headers.authorization.startsWith('Bearer')) {
    token = req.headers.authorization.split(' ')[1];
  }

  // Return error if no token provided
  if (!token) {
    return res.status(401).json({ error: 'Not authorized to access this route' });
  }

  try {
    // Verify token signature using JWT_SECRET
    const decoded = jwt.verify(token, process.env.JWT_SECRET);
    
    // Load user from database using ID from token
    req.user = await User.findById(decoded.id);

    // Return error if user not found
    if (!req.user) {
      return res.status(401).json({ error: 'User not found' });
    }

    // Continue to next middleware/route handler
    next();
  } catch (error) {
    // Return error if token verification fails
    return res.status(401).json({ error: 'Not authorized to access this route' });
  }
};

/**
 * Middleware factory to check if user has required role(s)
 * Used with protect middleware to enforce admin-only routes
 * Example: authorize('admin') or authorize('admin', 'user')
 */
exports.authorize = (...roles) => {
  return (req, res, next) => {
    // Check if user's role is in allowed roles array
    if (!roles.includes(req.user.role)) {
      return res.status(403).json({ error: `User role '${req.user.role}' is not authorized to access this route` });
    }
    // Continue if authorized
    next();
  };
};
