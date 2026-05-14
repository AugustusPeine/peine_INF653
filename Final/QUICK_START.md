# Quick Start Guide

Get your Event Ticketing System API up and running in 5 minutes!

## Prerequisites

- Node.js installed (v14 or higher)
- MongoDB Atlas account (free tier available)
- Text editor or IDE

## Step 1: Setup MongoDB

1. Go to [MongoDB Atlas](https://www.mongodb.com/cloud/atlas)
2. Create free account or sign in
3. Create a new cluster (free tier)
4. Click "Connect" → "Connect your application"
5. Copy the connection string
6. Replace `<password>` with your password and `myFirstDatabase` with `event-ticketing`

Example:
```
mongodb+srv://username:password@cluster0.xxxxx.mongodb.net/event-ticketing?retryWrites=true&w=majority
```

## Step 2: Install Dependencies

```bash
cd event-ticketing-api
npm install
```

## Step 3: Configure Environment

```bash
# Copy the example file
cp .env.example .env

# Edit .env file and add:
MONGODB_URI=mongodb+srv://username:password@cluster0.xxxxx.mongodb.net/event-ticketing
JWT_SECRET=your-super-secret-key-change-this-in-production
PORT=5000
```

## Step 4: Start the Server

```bash
# Development mode (with auto-reload)
npm run dev

# Or production mode
npm start
```

You should see:
```
MongoDB Connected: cluster0.xxxxx.mongodb.net
Server running on port 5000
```

## Step 5: Test the API

### Option A: Using Postman

1. Download [Postman](https://www.postman.com/downloads/)
2. Import `postman_collection.json` into Postman
3. Set base_url variable to `http://localhost:5000`
4. Run the requests in order:
   - Register User
   - Register Admin
   - Create Event
   - Create Booking

### Option B: Using Thunder Client (VSCode)

1. Install Thunder Client extension in VSCode
2. Click Thunder Client icon
3. Create requests to:
   - `POST http://localhost:5000/api/auth/register`
   - `GET http://localhost:5000/api/events`
   - etc.

### Option C: Using curl

```bash
# Register user
curl -X POST http://localhost:5000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{"name":"Test","email":"test@example.com","password":"123456"}'

# Get events
curl http://localhost:5000/api/events

# Create event (need token)
curl -X POST http://localhost:5000/api/events \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_ADMIN_TOKEN" \
  -d '{"title":"Concert","date":"2024-07-15T18:00:00.000Z","seatCapacity":100,"price":50}'
```

## Troubleshooting

### "Cannot find module"
```bash
npm install
```

### "MongoDB connection failed"
- Check MONGODB_URI in .env
- Verify MongoDB Atlas cluster is active
- Check IP whitelist in MongoDB Atlas (should allow all)

### "Port 5000 already in use"
- Change PORT in .env to another number (e.g., 5001)
- Or kill the process: `lsof -ti:5000 | xargs kill -9`

### "JWT token invalid"
- Tokens expire after 7 days
- Generate new token by logging in again
- Check JWT_SECRET in .env

## Key Endpoints

```
# Auth
POST   /api/auth/register    - Register new user
POST   /api/auth/login       - Login user

# Events (public)
GET    /api/events           - Get all events
GET    /api/events/:id       - Get single event
GET    /api/events?category=X - Filter by category
GET    /api/events?date=YYYY-MM-DD - Filter by date

# Events (admin only)
POST   /api/events           - Create event
PUT    /api/events/:id       - Update event
DELETE /api/events/:id       - Delete event

# Bookings (authenticated users)
GET    /api/bookings         - Get my bookings
GET    /api/bookings/:id     - Get booking details
POST   /api/bookings         - Create booking

# Public pages
GET    /                     - Welcome page
GET    /api                  - API documentation
```

## Next Steps

1. **Test all endpoints** using TESTING_GUIDE.md
2. **Customize** the code for your needs
3. **Deploy** to Render.com (see README.md for instructions)
4. **Build frontend** to consume your API

## Additional Resources

- Full documentation: See [README.md](./README.md)
- Testing guide: See [TESTING_GUIDE.md](./TESTING_GUIDE.md)
- Postman collection: Import [postman_collection.json](./postman_collection.json)

## Support

If you get stuck:
1. Check the error message in the terminal
2. Verify MongoDB connection
3. Ensure all required fields are provided
4. Check JWT token validity
5. Review the test examples in TESTING_GUIDE.md

Happy coding! 🚀
