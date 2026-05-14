# Event Ticketing System API

A comprehensive REST API for an Event Ticketing System built with Node.js, Express, MongoDB, and JWT authentication. Users can browse events, book tickets, and manage their bookings while admins can manage events.

## Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [Installation](#installation)
- [Setup](#setup)
- [Environment Variables](#environment-variables)
- [Running the Project](#running-the-project)
- [API Endpoints](#api-endpoints)
- [Authentication](#authentication)
- [Deployment](#deployment)
- [Testing](#testing)
- [Bonus Features](#bonus-features)

## Features

### User Features
- ✅ User registration and login with JWT authentication
- ✅ Browse all events
- ✅ Filter events by category and date
- ✅ View event details (title, date, time, venue, available seats, price)
- ✅ Book tickets for events with seat validation
- ✅ View personal bookings
- ✅ QR code generation for bookings
- ✅ QR code validation

### Admin Features
- ✅ Create new events
- ✅ Update existing events
- ✅ Delete events
- ✅ Manage seat capacity and validate availability
- ✅ Automatic booking cleanup on event deletion

### Technical Features
- ✅ JWT-based authentication and authorization
- ✅ Role-based access control (Admin/User)
- ✅ Password hashing with bcryptjs
- ✅ Input validation for all major inputs
- ✅ Error handling middleware
- ✅ 404 handler with HTML/JSON responses based on Accept header
- ✅ Modular project structure
- ✅ MongoDB integration with Mongoose

## Tech Stack

- **Runtime**: Node.js
- **Framework**: Express.js
- **Database**: MongoDB with Mongoose ODM
- **Authentication**: JWT (JSON Web Tokens)
- **Password Hashing**: bcryptjs
- **Validation**: express-validator
- **QR Code**: qrcode package
- **Email**: nodemailer (optional)
- **CORS**: cors package
- **Environment**: dotenv

## Installation

### Prerequisites
- Node.js (v14 or higher)
- MongoDB Atlas account or local MongoDB instance
- npm or yarn package manager

### Steps

1. **Clone the repository** (or download the project)
   ```bash
   cd event-ticketing-api
   ```

2. **Install dependencies**
   ```bash
   npm install
   ```

3. **Create a `.env` file** in the root directory
   ```bash
   cp .env.example .env
   ```

## Setup

### Environment Variables

Update your `.env` file with the following variables:

```env
# MongoDB Connection String
MONGODB_URI=mongodb+srv://username:password@cluster.mongodb.net/event-ticketing

# JWT Secret (use a strong, random string in production)
JWT_SECRET=your_super_secret_jwt_key_change_this_in_production

# JWT Expiration
JWT_EXPIRE=7d

# Server Port
PORT=5000

# Email Configuration (Optional - for bonus email feature)
SMTP_EMAIL=your_email@gmail.com
SMTP_PASSWORD=your_app_password
SMTP_HOST=smtp.gmail.com
SMTP_PORT=587
```

### Getting MongoDB Connection String

1. Go to [MongoDB Atlas](https://www.mongodb.com/cloud/atlas)
2. Create a free account or sign in
3. Create a new cluster
4. Click "Connect" and select "Connect your application"
5. Copy the connection string and replace username:password with your credentials
6. Add the connection string to your `.env` file

## Running the Project

### Development Mode (with auto-reload)
```bash
npm run dev
```

### Production Mode
```bash
npm start
```

The server will start on `http://localhost:5000`

## API Endpoints

### Base URL
- Local: `http://localhost:5000/api`
- Deployed: `https://your-project-name.onrender.com/api`

### Authentication Endpoints

#### Register a New User
```
POST /api/auth/register
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "role": "user" // optional, defaults to "user"
}
```

**Response (201 Created):**
```json
{
  "success": true,
  "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
  "user": {
    "id": "507f1f77bcf86cd799439011",
    "name": "John Doe",
    "email": "john@example.com",
    "role": "user"
  }
}
```

#### Login User
```
POST /api/auth/login
Content-Type: application/json

{
  "email": "john@example.com",
  "password": "password123"
}
```

**Response (200 OK):**
```json
{
  "success": true,
  "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
  "user": {
    "id": "507f1f77bcf86cd799439011",
    "name": "John Doe",
    "email": "john@example.com",
    "role": "user"
  }
}
```

### Event Endpoints

#### Get All Events (with optional filtering)
```
GET /api/events
GET /api/events?category=Concert
GET /api/events?date=2024-12-25
GET /api/events?category=Concert&date=2024-12-25
```

**Response (200 OK):**
```json
{
  "success": true,
  "count": 5,
  "data": [
    {
      "_id": "507f1f77bcf86cd799439011",
      "title": "Summer Concert 2024",
      "description": "An amazing summer concert",
      "category": "Concert",
      "venue": "Central Park",
      "date": "2024-07-15T18:00:00.000Z",
      "time": "6:00 PM",
      "seatCapacity": 1000,
      "bookedSeats": 150,
      "price": 50,
      "createdBy": {
        "_id": "507f1f77bcf86cd799439012",
        "name": "Admin User",
        "email": "admin@example.com"
      },
      "createdAt": "2024-01-10T10:00:00.000Z"
    }
  ]
}
```

#### Get Single Event
```
GET /api/events/:id
```

#### Create Event (Admin Only)
```
POST /api/events
Authorization: Bearer <JWT_TOKEN>
Content-Type: application/json

{
  "title": "Summer Concert 2024",
  "description": "An amazing summer concert",
  "category": "Concert",
  "venue": "Central Park",
  "date": "2024-07-15T18:00:00.000Z",
  "time": "6:00 PM",
  "seatCapacity": 1000,
  "price": 50
}
```

**Response (201 Created):**
```json
{
  "success": true,
  "data": {
    "_id": "507f1f77bcf86cd799439011",
    "title": "Summer Concert 2024",
    ...
  }
}
```

#### Update Event (Admin Only)
```
PUT /api/events/:id
Authorization: Bearer <JWT_TOKEN>
Content-Type: application/json

{
  "title": "Updated Concert Name",
  "price": 60
}
```

**Note:** Cannot update `_id` field or reduce `seatCapacity` below current `bookedSeats`.

#### Delete Event (Admin Only)
```
DELETE /api/events/:id
Authorization: Bearer <JWT_TOKEN>
```

**Response (200 OK):**
```json
{
  "success": true,
  "message": "Event deleted successfully"
}
```

**Note:** Associated bookings are automatically deleted when an event is deleted.

### Booking Endpoints

#### Get All Bookings (For Logged-in User)
```
GET /api/bookings
Authorization: Bearer <JWT_TOKEN>
```

**Response (200 OK):**
```json
{
  "success": true,
  "count": 2,
  "data": [
    {
      "_id": "507f1f77bcf86cd799439020",
      "user": {
        "_id": "507f1f77bcf86cd799439011",
        "name": "John Doe",
        "email": "john@example.com"
      },
      "event": {
        "_id": "507f1f77bcf86cd799439012",
        "title": "Summer Concert 2024",
        "date": "2024-07-15T18:00:00.000Z",
        ...
      },
      "quantity": 2,
      "totalPrice": 100,
      "bookingDate": "2024-01-10T12:30:00.000Z",
      "qrCode": "data:image/png;base64,..."
    }
  ]
}
```

#### Get Single Booking (For Logged-in User)
```
GET /api/bookings/:id
Authorization: Bearer <JWT_TOKEN>
```

**Note:** Users can only access their own bookings.

#### Create Booking
```
POST /api/bookings
Authorization: Bearer <JWT_TOKEN>
Content-Type: application/json

{
  "eventId": "507f1f77bcf86cd799439012",
  "quantity": 2
}
```

**Response (201 Created):**
```json
{
  "success": true,
  "data": {
    "_id": "507f1f77bcf86cd799439020",
    "user": {...},
    "event": {...},
    "quantity": 2,
    "totalPrice": 100,
    "bookingDate": "2024-01-10T12:30:00.000Z",
    "qrCode": "data:image/png;base64,..."
  }
}
```

**Note:** The booking quantity cannot exceed available seats. When a booking is created, the event's `bookedSeats` is automatically updated.

#### Validate QR Code
```
GET /api/bookings/validate/:qr
```

**Response (200 OK):**
```json
{
  "success": true,
  "message": "QR code is valid",
  "data": {
    "_id": "507f1f77bcf86cd799439020",
    "user": {...},
    "event": {...},
    ...
  }
}
```

## Authentication

### How to Use JWT Token

1. **Register or Login** to get a JWT token
2. **Include the token** in subsequent API requests using the Authorization header:

```bash
Authorization: Bearer your_jwt_token_here
```

### Example using curl:
```bash
curl -H "Authorization: Bearer your_jwt_token_here" \
  http://localhost:5000/api/bookings
```

### Example using Postman:
1. Go to the "Headers" tab
2. Add a new header: `Authorization`
3. Set value to: `Bearer your_jwt_token_here`

## Deployment

### Deploy to Render

1. **Create a GitHub Repository**
   - Push your project to GitHub

2. **Create a Render Account**
   - Go to [render.com](https://render.com)
   - Sign up with your GitHub account

3. **Create a New Web Service**
   - Click "New" → "Web Service"
   - Connect your GitHub repository
   - Choose Node as the environment

4. **Configure Environment Variables**
   - Add all variables from `.env.example` in the Render dashboard
   - Make sure to set strong JWT_SECRET and correct MONGODB_URI

5. **Deploy**
   - Render will automatically deploy when you push to main branch
   - Your API will be available at `https://your-app-name.onrender.com`

### Important Notes for Deployment
- ✅ Never commit `.env` file to GitHub
- ✅ Include `.env.example` in GitHub
- ✅ Set environment variables in Render dashboard
- ✅ Test all endpoints after deployment

## Testing

### Using Postman

1. **Download Postman** from [postman.com](https://www.postman.com/downloads/)

2. **Import Collection** (optional)
   - Create a new collection for this API
   - Add requests for each endpoint

3. **Testing Flow**
   - Register a new user: `POST /api/auth/register`
   - Login: `POST /api/auth/login` (copy the token)
   - Add token to Authorization header for protected routes
   - Test other endpoints

4. **Sample Test Data**

**Register User:**
```json
{
  "name": "Test User",
  "email": "test@example.com",
  "password": "password123"
}
```

**Create Event (as admin):**
```json
{
  "title": "Concert Night",
  "description": "Amazing concert",
  "category": "Music",
  "venue": "Main Hall",
  "date": "2024-12-25T19:00:00.000Z",
  "time": "7:00 PM",
  "seatCapacity": 500,
  "price": 75
}
```

**Create Booking:**
```json
{
  "eventId": "<event_id_from_create_event>",
  "quantity": 2
}
```

### Using Thunder Client (VSCode)

1. **Install Thunder Client** extension in VSCode
2. Click the Thunder Client icon
3. Create requests for each endpoint
4. Test as shown above

## Bonus Features

### 1. QR Code Generation ✅
- Automatically generated when a booking is created
- Stored as base64 data URL
- Contains booking and event information

### 2. QR Code Validation ✅
- Endpoint: `GET /api/bookings/validate/:qr`
- Validates QR codes from bookings

### 3. Email Confirmation (Optional)
- Configure SMTP variables in `.env`
- Implement in booking controller to send confirmation emails
- Uses nodemailer package

### 4. Admin Dashboard Route (Optional)
- Could be implemented as `GET /api/admin/dashboard`
- Returns all events with booking statistics
- Restricted to admin users only

## Validation Rules

- **Email**: Must be valid format (regex validated)
- **Password**: Minimum 6 characters, automatically hashed
- **Name**: Required, trimmed
- **Seat Capacity**: Must be > 0
- **Price**: Cannot be negative
- **Quantity**: Must be > 0
- **Booking Quantity**: Cannot exceed available seats
- **Event Date**: Required

## Error Handling

The API returns meaningful error messages:

```json
{
  "error": "Error description"
}
```

### Status Codes
- `200`: Success
- `201`: Created
- `400`: Bad Request (validation error)
- `401`: Unauthorized (missing or invalid token)
- `403`: Forbidden (insufficient permissions)
- `404`: Not Found
- `500`: Server Error

## Project Structure

```
event-ticketing-api/
├── config/
│   └── db.js                 # Database connection
├── controllers/
│   ├── authController.js     # Auth logic
│   ├── eventController.js    # Event logic
│   └── bookingController.js  # Booking logic
├── middleware/
│   ├── auth.js              # JWT & Authorization
│   └── errorHandler.js      # Error handling
├── models/
│   ├── User.js              # User schema
│   ├── Event.js             # Event schema
│   └── Booking.js           # Booking schema
├── routes/
│   ├── auth.js              # Auth routes
│   ├── events.js            # Event routes
│   └── bookings.js          # Booking routes
├── utils/
│   └── tokens.js            # Token utilities
├── .env.example             # Environment variables template
├── .gitignore              # Git ignore rules
├── package.json            # Dependencies
├── server.js               # Server entry point
└── README.md               # Documentation
```

## Notes

- Users can only view their own bookings
- Admins can create, update, and delete events
- Event deletion cascades to associated bookings
- Passwords are hashed using bcryptjs before storage
- JWT tokens expire after 7 days (configurable)
- All dates are stored in UTC format

## Support

For issues or questions, please check:
1. The error message response from the API
2. Console logs on the server
3. MongoDB Atlas logs for database issues
4. Environment variables are correctly set

## License

ISC

---

**Happy coding! 🎫**
