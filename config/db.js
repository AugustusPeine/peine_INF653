// MongoDB Connection Configuration
const mongoose = require('mongoose');

/**
 * Connect to MongoDB using Mongoose
 * Reads connection string from MONGODB_URI environment variable
 * @returns {Promise} MongoDB connection object
 * @throws {Error} Exits process if connection fails
 */
const connectDB = async () => {
  try {
    // Attempt to connect to MongoDB Atlas
    const conn = await mongoose.connect(process.env.MONGODB_URI, {
      useNewUrlParser: true,
      useUnifiedTopology: true,
    });
    console.log(`MongoDB Connected: ${conn.connection.host}`);
    return conn;
  } catch (err) {
    // Log error and exit if connection fails
    console.error(`Error connecting to MongoDB: ${err.message}`);
    process.exit(1);
  }
};

module.exports = connectDB;
