const Booking = require('../models/Booking');
const Event = require('../models/Event');
const QRCode = require('qrcode');

// @desc    Get all bookings for logged-in user
// @route   GET /api/bookings
// @access  Private
exports.getBookings = async (req, res, next) => {
  try {
    const bookings = await Booking.find({ user: req.user._id })
      .populate('event')
      .populate('user', 'name email');

    res.status(200).json({
      success: true,
      count: bookings.length,
      data: bookings,
    });
  } catch (error) {
    next(error);
  }
};

// @desc    Get single booking (only if it belongs to user)
// @route   GET /api/bookings/:id
// @access  Private
exports.getBooking = async (req, res, next) => {
  try {
    const booking = await Booking.findById(req.params.id)
      .populate('event')
      .populate('user', 'name email');

    if (!booking) {
      return res.status(404).json({
        error: 'Booking not found',
      });
    }

    // Check if booking belongs to the user
    if (booking.user._id.toString() !== req.user._id.toString()) {
      return res.status(403).json({
        error: 'Not authorized to access this booking',
      });
    }

    res.status(200).json({
      success: true,
      data: booking,
    });
  } catch (error) {
    next(error);
  }
};

// @desc    Create booking
// @route   POST /api/bookings
// @access  Private
exports.createBooking = async (req, res, next) => {
  try {
    const { eventId, quantity } = req.body;

    // Validation
    if (!eventId || !quantity) {
      return res.status(400).json({
        error: 'Please provide eventId and quantity',
      });
    }

    if (quantity <= 0) {
      return res.status(400).json({
        error: 'Quantity must be greater than 0',
      });
    }

    // Check event exists
    const event = await Event.findById(eventId);
    if (!event) {
      return res.status(404).json({
        error: 'Event not found',
      });
    }

    // Check available seats
    const availableSeats = event.seatCapacity - event.bookedSeats;

    if (quantity > availableSeats) {
      return res.status(400).json({
        error: `Only ${availableSeats} seats available for this event`,
      });
    }

    // Create booking
    const booking = await Booking.create({
      user: req.user._id,
      event: eventId,
      quantity,
      totalPrice: quantity * event.price,
    });

    // Update booked seats
    event.bookedSeats += quantity;
    await event.save();

    // Generate QR code
    try {
      const qrData = JSON.stringify({
        bookingId: booking._id,
        eventId: event._id,
        userId: req.user._id,
        quantity,
        bookingDate: booking.bookingDate,
      });
      const qrCode = await QRCode.toDataURL(qrData);
      booking.qrCode = qrCode;
      await booking.save();
    } catch (qrError) {
      console.log('QR Code generation failed, continuing without QR code');
    }

    const populatedBooking = await Booking.findById(booking._id)
      .populate('event')
      .populate('user', 'name email');

    res.status(201).json({
      success: true,
      data: populatedBooking,
    });
  } catch (error) {
    next(error);
  }
};

// @desc    Validate QR code
// @route   GET /api/bookings/validate/:qr
// @access  Public
exports.validateQRCode = async (req, res, next) => {
  try {
    const bookings = await Booking.find({}).populate('event').populate('user');

    let validBooking = null;
    for (const booking of bookings) {
      if (booking.qrCode && booking.qrCode.includes(req.params.qr)) {
        validBooking = booking;
        break;
      }
    }

    if (!validBooking) {
      return res.status(404).json({
        error: 'Invalid QR code',
      });
    }

    res.status(200).json({
      success: true,
      message: 'QR code is valid',
      data: validBooking,
    });
  } catch (error) {
    next(error);
  }
};
