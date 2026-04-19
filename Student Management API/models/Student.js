const mongoose = require('mongoose');

//Student schema for Mongo
const studentSchema = new mongoose.Schema({
  firstName: {
    type: String,
    required: true,
    trim: true
  },
  lastName: {
    type: String,
    required: true,
    trim: true
  },
  email: {
    type: String,
    required: true,
    unique: true,       //Make sure email is unique
    lowercase: true,    //Make email be lowercase
    trim: true
  },
  course: {
    type: String,
    required: true,
    trim: true
  },
  enrolledDate: {
    type: Date,
    default: Date.now    //Use current date when not given
  }
});

module.exports = mongoose.model('Student', studentSchema);