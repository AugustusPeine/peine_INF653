const mongoose = require('mongoose');

const bookingSchema = new mongoose.Schema({
  user: {
    type: mongoose.Schema.Types.ObjectId,
    ref: 'User',
    required: true,
  },
  event: {
    type: mongoose.Schema.Types.ObjectId,
    ref: 'Event',
    required: true,
  },
  quantity: {
    type: Number,
    required: [true, 'Please provide a quantity'],
    validate: {
      validator: function (v) {
        return v > 0;
      },
      message: 'Quantity must be greater than 0',
    },
  },
  bookingDate: {
    type: Date,
    default: Date.now,
  },
  qrCode: {
    type: String,
    default: null,
  },
  totalPrice: {
    type: Number,
  },
});

module.exports = mongoose.model('Booking', bookingSchema);
