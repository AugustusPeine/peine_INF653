const Event = require('../models/Event');

// @desc    Get all events with optional filtering
// @route   GET /api/events
// @access  Public
exports.getEvents = async (req, res, next) => {
  try {
    const { category, date } = req.query;
    let filter = {};

    if (category) {
      filter.category = category;
    }

    if (date) {
      const startDate = new Date(date);
      const endDate = new Date(date);
      endDate.setDate(endDate.getDate() + 1);
      filter.date = { $gte: startDate, $lt: endDate };
    }

    const events = await Event.find(filter).populate('createdBy', 'name email');

    res.status(200).json({
      success: true,
      count: events.length,
      data: events,
    });
  } catch (error) {
    next(error);
  }
};

// @desc    Get single event
// @route   GET /api/events/:id
// @access  Public
exports.getEvent = async (req, res, next) => {
  try {
    const event = await Event.findById(req.params.id).populate('createdBy', 'name email');

    if (!event) {
      return res.status(404).json({
        error: 'Event not found',
      });
    }

    res.status(200).json({
      success: true,
      data: event,
    });
  } catch (error) {
    next(error);
  }
};

// @desc    Create event
// @route   POST /api/events
// @access  Private (Admin only)
exports.createEvent = async (req, res, next) => {
  try {
    const { title, description, category, venue, date, time, seatCapacity, price } = req.body;

    // Validation
    if (!title || !date || !seatCapacity || price === undefined) {
      return res.status(400).json({
        error: 'Please provide title, date, seatCapacity, and price',
      });
    }

    if (seatCapacity <= 0) {
      return res.status(400).json({
        error: 'Seat capacity must be greater than 0',
      });
    }

    if (price < 0) {
      return res.status(400).json({
        error: 'Price cannot be negative',
      });
    }

    const event = await Event.create({
      title,
      description,
      category,
      venue,
      date,
      time,
      seatCapacity,
      price,
      createdBy: req.user._id,
    });

    res.status(201).json({
      success: true,
      data: event,
    });
  } catch (error) {
    next(error);
  }
};

// @desc    Update event
// @route   PUT /api/events/:id
// @access  Private (Admin only)
exports.updateEvent = async (req, res, next) => {
  try {
    let event = await Event.findById(req.params.id);

    if (!event) {
      return res.status(404).json({
        error: 'Event not found',
      });
    }

    // Check if trying to reduce seatCapacity below bookedSeats
    if (req.body.seatCapacity && req.body.seatCapacity < event.bookedSeats) {
      return res.status(400).json({
        error: `Cannot reduce seat capacity below ${event.bookedSeats} booked seats`,
      });
    }

    // Validate price if provided
    if (req.body.price !== undefined && req.body.price < 0) {
      return res.status(400).json({
        error: 'Price cannot be negative',
      });
    }

    // Validate seatCapacity if provided
    if (req.body.seatCapacity !== undefined && req.body.seatCapacity <= 0) {
      return res.status(400).json({
        error: 'Seat capacity must be greater than 0',
      });
    }

    // Cannot modify _id
    const { _id, ...updateData } = req.body;

    event = await Event.findByIdAndUpdate(req.params.id, updateData, {
      new: true,
      runValidators: true,
    });

    res.status(200).json({
      success: true,
      data: event,
    });
  } catch (error) {
    next(error);
  }
};

// @desc    Delete event
// @route   DELETE /api/events/:id
// @access  Private (Admin only)
exports.deleteEvent = async (req, res, next) => {
  try {
    const event = await Event.findById(req.params.id);

    if (!event) {
      return res.status(404).json({
        error: 'Event not found',
      });
    }

    // Check if event has bookings
    const Booking = require('../models/Booking');
    const bookings = await Booking.find({ event: req.params.id });

    if (bookings.length > 0) {
      // Delete associated bookings
      await Booking.deleteMany({ event: req.params.id });
    }

    await Event.findByIdAndDelete(req.params.id);

    res.status(200).json({
      success: true,
      message: 'Event deleted successfully',
    });
  } catch (error) {
    next(error);
  }
};
