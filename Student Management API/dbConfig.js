const dns = require('dns');
const mongoose = require('mongoose');
require('dotenv').config();

//Public DNS servers to resolve Atlas SRV records
dns.setServers(['8.8.8.8', '1.1.1.1']);

const connectDB = async () => {
  try {
    //Connect to Mongo with URI from .env
    await mongoose.connect(process.env.MONGO_URI);
    console.log('MongoDB connected');
  } catch (error) {
    console.error('MongoDB connection error:', error);
    process.exit(1);
  }
};

module.exports = connectDB;