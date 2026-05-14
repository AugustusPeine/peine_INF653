const mongoose = require('mongoose');

const eventSchema = new mongoose.Schema({
  title: {
    type: String,
    required: [true, 'Please provide an event title'],
    trim: true,
  },
  description: {
    type: String,
    trim: true,
  },
  category: {
    type: String,
    trim: true,
  },
  venue: {
    type: String,
    trim: true,
  },
  date: {
    type: Date,
    required: [true, 'Please provide an event date'],
  },
  time: {
    type: String,
    trim: true,
  },
  seatCapacity: {
    type: Number,
    required: [true, 'Please provide seat capacity'],
    validate: {
      validator: function (v) {
        return v > 0;
      },
      message: 'Seat capacity must be greater than 0',
    },
  },
  bookedSeats: {
    type: Number,
    default: 0,
    validate: {
      validator: function (v) {
        return v >= 0 && v <= this.seatCapacity;
      },
      message: 'Booked seats must be between 0 and seat capacity',
    },
  },
  price: {
    type: Number,
    required: [true, 'Please provide an event price'],
    validate: {
      validator: function (v) {
        return v >= 0;
      },
      message: 'Price cannot be negative',
    },
  },
  createdBy: {
    type: mongoose.Schema.Types.ObjectId,
    ref: 'User',
    required: true,
  },
  createdAt: {
    type: Date,
    default: Date.now,
  },
});

module.exports = mongoose.model('Event', eventSchema);
