const express = require('express');
const router = express.Router();
const {
  getBookings,
  getBooking,
  createBooking,
  validateQRCode,
} = require('../controllers/bookingController');
const { protect } = require('../middleware/auth');

// Protected routes
router.get('/', protect, getBookings);
router.get('/:id', protect, getBooking);
router.post('/', protect, createBooking);

// Public route for QR validation (could be protected in production)
router.get('/validate/:qr', validateQRCode);

module.exports = router;
