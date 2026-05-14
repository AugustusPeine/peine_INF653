// User Model - Represents users in the application
const mongoose = require('mongoose');
const bcryptjs = require('bcryptjs');

const userSchema = new mongoose.Schema({
  // User's full name
  name: {
    type: String,
    required: [true, 'Please provide a name'],
    trim: true,
  },
  // User's email (unique, indexed by MongoDB for fast lookups)
  email: {
    type: String,
    required: [true, 'Please provide an email'],
    unique: true,
    lowercase: true,
    // Email format validation using regex pattern
    match: [
      /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/,
      'Please provide a valid email',
    ],
  },
  // User's password (hashed, not returned in queries by default)
  password: {
    type: String,
    required: [true, 'Please provide a password'],
    minlength: 6,
    select: false, // Don't include password in queries unless explicitly requested
  },
  // User's role: 'user' (regular user) or 'admin' (can manage events)
  role: {
    type: String,
    enum: ['user', 'admin'],
    default: 'user',
  },
  // Timestamp of when user was created
  createdAt: {
    type: Date,
    default: Date.now,
  },
});

// Pre-save middleware: Hash password before saving to database
// Called automatically before .save() is executed
userSchema.pre('save', async function (next) {
  // Skip hashing if password hasn't been modified (e.g., during profile updates)
  if (!this.isModified('password')) {
    next();
  }

  try {
    // Generate salt for hashing (10 rounds = good security/speed balance)
    const salt = await bcryptjs.genSalt(10);
    // Hash the password with the salt
    this.password = await bcryptjs.hash(this.password, salt);
    next();
  } catch (error) {
    next(error);
  }
});

/**
 * Instance method: Compare entered password with hashed password
 * Used during login to verify user credentials
 * @param {String} enteredPassword - Plain text password from login form
 * @returns {Promise<Boolean>} True if passwords match, false otherwise
 */
userSchema.methods.matchPassword = async function (enteredPassword) {
  return await bcryptjs.compare(enteredPassword, this.password);
};

module.exports = mongoose.model('User', userSchema);
