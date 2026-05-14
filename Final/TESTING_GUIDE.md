# API Testing Guide

This guide will help you test all endpoints of the Event Ticketing System API.

## Prerequisites

- API running locally (`http://localhost:3001`)
- Postman or Thunder Client installed
- A text editor for organizing test data

## Setup

### Step 1: Start the API Server

```bash
# Install dependencies
npm install

# Create .env file from .env.example
cp .env.example .env

# Update .env with your MongoDB connection string

# Start the server
npm run dev
```

You should see: `Server running on port 3001`

### Step 2: Open Testing Tool

**Using Postman:**
- Download from https://www.postman.com/downloads/
- Click "New Collection" to create a test collection
- Add requests for each endpoint

**Using Thunder Client (VSCode):**
- Install Thunder Client extension
- Click Thunder Client icon in sidebar
- Create new collection

## Test Flow

### 1. Authentication Tests

#### Test 1.1: Register User (Regular)
```
Method: POST
URL: http://localhost:3001/api/auth/register
Headers: Content-Type: application/json

Body:
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123"
}

Expected Response: 201 Created
{
  "success": true,
  "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
  "user": {
    "id": "...",
    "name": "John Doe",
    "email": "john@example.com",
    "role": "user"
  }
}
```

✅ **Copy the token for later use**

#### Test 1.2: Register Admin User
```
Method: POST
URL: http://localhost:3001/api/auth/register
Headers: Content-Type: application/json

Body:
{
  "name": "Admin User",
  "email": "admin@example.com",
  "password": "admin123",
  "role": "admin"
}

Expected Response: 201 Created
```

✅ **Copy the admin token for later use**

#### Test 1.3: Login User
```
Method: POST
URL: http://localhost:3001/api/auth/login
Headers: Content-Type: application/json

Body:
{
  "email": "john@example.com",
  "password": "password123"
}

Expected Response: 200 OK
{
  "success": true,
  "token": "...",
  "user": {...}
}
```

#### Test 1.4: Login with Wrong Password
```
Method: POST
URL: http://localhost:3001/api/auth/login
Headers: Content-Type: application/json

Body:
{
  "email": "john@example.com",
  "password": "wrongpassword"
}

Expected Response: 401 Unauthorized
{
  "error": "Invalid credentials"
}
```

### 2. Event Endpoints Tests

#### Test 2.1: Get All Events (Should be empty initially)
```
Method: GET
URL: http://localhost:3001/api/events

Expected Response: 200 OK
{
  "success": true,
  "count": 0,
  "data": []
}
```

#### Test 2.2: Create Event (Admin Only)
```
Method: POST
URL: http://localhost:3001/api/events
Headers: 
  - Content-Type: application/json
  - Authorization: Bearer <ADMIN_TOKEN>

Body:
{
  "title": "Summer Music Festival 2024",
  "description": "A wonderful music festival featuring local and international artists",
  "category": "Music",
  "venue": "Central Park Amphitheater",
  "date": "2024-07-15T18:00:00.000Z",
  "time": "6:00 PM",
  "seatCapacity": 1000,
  "price": 75
}

Expected Response: 201 Created
{
  "success": true,
  "data": {
    "_id": "...",
    "title": "Summer Music Festival 2024",
    ...
  }
}
```

✅ **Copy the event ID for later use**

#### Test 2.3: Create Another Event
```
Method: POST
URL: http://localhost:3001/api/events
Headers: 
  - Content-Type: application/json
  - Authorization: Bearer <ADMIN_TOKEN>

Body:
{
  "title": "Comedy Night",
  "description": "A night of laughter with famous comedians",
  "category": "Comedy",
  "venue": "Theater Downtown",
  "date": "2024-08-20T19:00:00.000Z",
  "time": "7:00 PM",
  "seatCapacity": 500,
  "price": 50
}

Expected Response: 201 Created
```

#### Test 2.4: Get All Events
```
Method: GET
URL: http://localhost:3001/api/events

Expected Response: 200 OK
{
  "success": true,
  "count": 2,
  "data": [
    {
      "_id": "...",
      "title": "Summer Music Festival 2024",
      ...
    },
    {
      "_id": "...",
      "title": "Comedy Night",
      ...
    }
  ]
}
```

#### Test 2.5: Filter Events by Category
```
Method: GET
URL: http://localhost:3001/api/events?category=Music

Expected Response: 200 OK
{
  "success": true,
  "count": 1,
  "data": [
    {
      "title": "Summer Music Festival 2024",
      "category": "Music",
      ...
    }
  ]
}
```

#### Test 2.6: Filter Events by Date
```
Method: GET
URL: http://localhost:3001/api/events?date=2024-07-15

Expected Response: 200 OK
{
  "success": true,
  "count": 1,
  "data": [
    {
      "title": "Summer Music Festival 2024",
      "date": "2024-07-15T18:00:00.000Z",
      ...
    }
  ]
}
```

#### Test 2.7: Get Single Event
```
Method: GET
URL: http://localhost:3001/api/events/<EVENT_ID>

Expected Response: 200 OK
{
  "success": true,
  "data": {
    "_id": "<EVENT_ID>",
    "title": "Summer Music Festival 2024",
    ...
  }
}
```

#### Test 2.8: Update Event (Admin Only)
```
Method: PUT
URL: http://localhost:3001/api/events/<EVENT_ID>
Headers: 
  - Content-Type: application/json
  - Authorization: Bearer <ADMIN_TOKEN>

Body:
{
  "price": 85,
  "description": "Updated: A wonderful music festival with more artists"
}

Expected Response: 200 OK
{
  "success": true,
  "data": {
    "_id": "<EVENT_ID>",
    "title": "Summer Music Festival 2024",
    "price": 85,
    ...
  }
}
```

#### Test 2.9: Try to Create Event Without Admin Role (Should fail)
```
Method: POST
URL: http://localhost:3001/api/events
Headers: 
  - Content-Type: application/json
  - Authorization: Bearer <USER_TOKEN>

Body:
{
  "title": "Fake Event",
  "date": "2024-09-01T18:00:00.000Z",
  "seatCapacity": 100,
  "price": 50
}

Expected Response: 403 Forbidden
{
  "error": "User role 'user' is not authorized to access this route"
}
```

#### Test 2.10: Try to Update with Invalid Seat Capacity
```
Method: PUT
URL: http://localhost:3001/api/events/<EVENT_ID>
Headers: 
  - Content-Type: application/json
  - Authorization: Bearer <ADMIN_TOKEN>

Body:
{
  "seatCapacity": -100
}

Expected Response: 400 Bad Request
{
  "error": "Seat capacity must be greater than 0"
}
```

### 3. Booking Endpoints Tests

#### Test 3.1: Get Bookings (Should be empty initially)
```
Method: GET
URL: http://localhost:3001/api/bookings
Headers: 
  - Authorization: Bearer <USER_TOKEN>

Expected Response: 200 OK
{
  "success": true,
  "count": 0,
  "data": []
}
```

#### Test 3.2: Create Booking
```
Method: POST
URL: http://localhost:3001/api/bookings
Headers: 
  - Content-Type: application/json
  - Authorization: Bearer <USER_TOKEN>

Body:
{
  "eventId": "<EVENT_ID>",
  "quantity": 2
}

Expected Response: 201 Created
{
  "success": true,
  "data": {
    "_id": "<BOOKING_ID>",
    "user": {
      "_id": "...",
      "name": "John Doe",
      "email": "john@example.com"
    },
    "event": {
      "_id": "<EVENT_ID>",
      "title": "Summer Music Festival 2024",
      ...
    },
    "quantity": 2,
    "totalPrice": 170,
    "bookingDate": "2024-01-10T12:30:00.000Z",
    "qrCode": "data:image/png;base64,..."
  }
}
```

✅ **Copy the booking ID for later use**

#### Test 3.3: Get All Bookings for User
```
Method: GET
URL: http://localhost:3001/api/bookings
Headers: 
  - Authorization: Bearer <USER_TOKEN>

Expected Response: 200 OK
{
  "success": true,
  "count": 1,
  "data": [
    {
      "_id": "<BOOKING_ID>",
      ...
    }
  ]
}
```

#### Test 3.4: Get Single Booking
```
Method: GET
URL: http://localhost:3001/api/bookings/<BOOKING_ID>
Headers: 
  - Authorization: Bearer <USER_TOKEN>

Expected Response: 200 OK
{
  "success": true,
  "data": {
    "_id": "<BOOKING_ID>",
    ...
  }
}
```

#### Test 3.5: Try to Access Another User's Booking (Should fail)
```
Method: GET
URL: http://localhost:3001/api/bookings/<BOOKING_ID>
Headers: 
  - Authorization: Bearer <ANOTHER_USER_TOKEN>

Expected Response: 403 Forbidden
{
  "error": "Not authorized to access this booking"
}
```

#### Test 3.6: Try to Book Without Authentication (Should fail)
```
Method: POST
URL: http://localhost:3001/api/bookings

Body:
{
  "eventId": "<EVENT_ID>",
  "quantity": 1
}

Expected Response: 401 Unauthorized
{
  "error": "Not authorized to access this route"
}
```

#### Test 3.7: Try to Book More Tickets Than Available
```
Method: POST
URL: http://localhost:3001/api/bookings
Headers: 
  - Content-Type: application/json
  - Authorization: Bearer <USER_TOKEN>

Body:
{
  "eventId": "<EVENT_ID>",
  "quantity": 2000
}

Expected Response: 400 Bad Request
{
  "error": "Only XXX seats available for this event"
}
```

#### Test 3.8: Create Multiple Bookings
```
Create 3-4 more bookings with different quantities using different users or the same user
```

### 4. Validation Tests

#### Test 4.1: Register with Invalid Email
```
Method: POST
URL: http://localhost:3001/api/auth/register

Body:
{
  "name": "Test",
  "email": "invalid-email",
  "password": "password123"
}

Expected Response: 400 Bad Request
{
  "error": "Please provide a valid email"
}
```

#### Test 4.2: Register with Short Password
```
Method: POST
URL: http://localhost:3001/api/auth/register

Body:
{
  "name": "Test",
  "email": "test@example.com",
  "password": "123"
}

Expected Response: 400 Bad Request (or 201 depending on validation)
```

#### Test 4.3: Register with Duplicate Email
```
Method: POST
URL: http://localhost:3001/api/auth/register

Body:
{
  "name": "Another John",
  "email": "john@example.com",
  "password": "password123"
}

Expected Response: 400 Bad Request
{
  "error": "Email already in use"
}
```

### 5. Delete Event Test

#### Test 5.1: Delete Event (Admin Only)
```
Method: DELETE
URL: http://localhost:3001/api/events/<EVENT_ID>
Headers: 
  - Authorization: Bearer <ADMIN_TOKEN>

Expected Response: 200 OK
{
  "success": true,
  "message": "Event deleted successfully"
}
```

✅ **Note: Associated bookings are automatically deleted**

#### Test 5.2: Verify Event is Deleted
```
Method: GET
URL: http://localhost:3001/api/events/<EVENT_ID>

Expected Response: 404 Not Found
{
  "error": "Event not found"
}
```

### 6. 404 Endpoint Tests

#### Test 6.1: Access Non-existent Route (JSON)
```
Method: GET
URL: http://localhost:3001/api/nonexistent
Headers: 
  - Accept: application/json

Expected Response: 404 Not Found
{
  "error": "404 Not Found"
}
```

#### Test 6.2: Access Non-existent Route (HTML)
```
Method: GET
URL: http://localhost:3001/api/nonexistent
Headers: 
  - Accept: text/html

Expected Response: 404 Not Found (HTML page)
<html>
  <h1>404</h1>
  <p>Page not found</p>
  ...
</html>
```

### 7. Root URL Test

#### Test 7.1: Visit Root URL
```
Method: GET
URL: http://localhost:3001/

Expected Response: 200 OK (HTML welcome page)
```

## Testing Checklist

- [ ] User Registration Works
- [ ] Admin Registration Works  
- [ ] Login Works
- [ ] JWT Token is Generated
- [ ] Events can be created by admin
- [ ] Events cannot be created by regular user
- [ ] Events can be filtered by category
- [ ] Events can be filtered by date
- [ ] Events can be updated by admin
- [ ] Events cannot be updated by regular user
- [ ] Events can be deleted by admin
- [ ] Bookings are created successfully
- [ ] Users can view only their bookings
- [ ] Users cannot view others' bookings
- [ ] QR codes are generated
- [ ] Booking quantity cannot exceed available seats
- [ ] Validation works for all inputs
- [ ] 404 handler returns JSON
- [ ] 404 handler returns HTML
- [ ] Error handling works
- [ ] Root URL shows welcome page

## Troubleshooting

### Issue: Cannot connect to MongoDB
- Check MONGODB_URI in .env
- Verify MongoDB Atlas account and cluster
- Check IP whitelist in MongoDB Atlas

### Issue: JWT token invalid
- Regenerate token by logging in again
- Check JWT_SECRET in .env matches

### Issue: CORS errors
- Check CORS is properly configured in server.js
- Add your frontend URL to CORS if deploying separately

### Issue: Port already in use
- Change PORT in .env
- Or kill process using port: `lsof -ti:3001 | xargs kill -9`

## Performance Testing (Optional)

Create a script to test API performance:
```bash
# Test 100 requests
for i in {1..100}; do
  curl http://localhost:3001/api/events
done
```

## Notes

- Keep track of generated IDs for use in subsequent tests
- Always use valid JWT tokens in Authorization headers
- Test both happy paths and error cases
- Document any unexpected behavior
