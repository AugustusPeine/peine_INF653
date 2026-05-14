// Centralized Error Handling Middleware
// Catches all errors and returns consistent JSON error response

const errorHandler = (err, req, res, next) => {
  // Set default status code and message
  err.statusCode = err.statusCode || 500;
  err.message = err.message || 'Internal Server Error';

  // Handle invalid MongoDB ObjectId
  if (err.name === 'CastError') {
    const message = `Resource not found. Invalid: ${err.path}`;
    err.statusCode = 400;
    err.message = message;
  }

  // Handle Mongoose unique index constraint violation (e.g., duplicate email)
  if (err.code === 11000) {
    const message = `Duplicate field value entered`;
    err.statusCode = 400;
    err.message = message;
  }

  // Handle invalid JWT token
  if (err.name === 'JsonWebTokenError') {
    const message = 'JSON Web Token is invalid. Try Again';
    err.statusCode = 400;
    err.message = message;
  }

  // Handle expired JWT token
  if (err.name === 'TokenExpiredError') {
    const message = 'JSON Web Token has expired. Try Again';
    err.statusCode = 400;
    err.message = message;
  }

  // Handle Mongoose schema validation errors
  if (err.name === 'ValidationError') {
    // Combine all validation error messages
    const message = Object.values(err.errors)
      .map((val) => val.message)
      .join(', ');
    err.statusCode = 400;
    err.message = message;
  }

  // Send error response with status code and message
  res.status(err.statusCode).json({
    error: err.message,
  });
};

module.exports = errorHandler;
