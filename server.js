require('dotenv').config();
const express = require('express');
const cors = require('cors');
const connectDB = require('./config/db');
const errorHandler = require('./middleware/errorHandler');

// Connect to database
connectDB();

const app = express();

// Middleware
app.use(cors());
app.use(express.json());

// Root route - HTML welcome page
app.get('/', (req, res) => {
  res.send(`
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Event Ticketing System API</title>
      <style>
        body {
          font-family: Arial, sans-serif;
          margin: 0;
          padding: 20px;
          background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
          min-height: 100vh;
          display: flex;
          align-items: center;
          justify-content: center;
        }
        .container {
          background: white;
          padding: 40px;
          border-radius: 10px;
          box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
          max-width: 600px;
          text-align: center;
        }
        h1 {
          color: #333;
          margin: 0 0 10px 0;
        }
        p {
          color: #666;
          line-height: 1.6;
        }
        .api-link {
          background: #667eea;
          color: white;
          padding: 10px 20px;
          text-decoration: none;
          border-radius: 5px;
          display: inline-block;
          margin-top: 20px;
        }
        .api-link:hover {
          background: #764ba2;
        }
      </style>
    </head>
    <body>
      <div class="container">
        <h1>🎫 Event Ticketing System API</h1>
        <p>Welcome to the Event Ticketing System REST API</p>
        <p>This API allows users to browse events, book tickets, and manage their bookings.</p>
        <a href="/api" class="api-link">View API Documentation</a>
      </div>
    </body>
    </html>
  `);
});

// API Documentation route
app.get('/api', (req, res) => {
  res.send(`
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>API Documentation</title>
      <style>
        body {
          font-family: Arial, sans-serif;
          margin: 0;
          padding: 20px;
          background: #f5f5f5;
        }
        .container {
          max-width: 1000px;
          margin: 0 auto;
          background: white;
          padding: 20px;
          border-radius: 5px;
        }
        h1 { color: #333; }
        h2 { color: #667eea; margin-top: 30px; }
        .endpoint {
          background: #f9f9f9;
          padding: 15px;
          margin: 10px 0;
          border-left: 4px solid #667eea;
          border-radius: 3px;
        }
        .method {
          display: inline-block;
          padding: 5px 10px;
          border-radius: 3px;
          color: white;
          font-weight: bold;
          margin-right: 10px;
        }
        .get { background: #61affe; }
        .post { background: #49cc90; }
        .put { background: #fca130; }
        .delete { background: #f93e3e; }
      </style>
    </head>
    <body>
      <div class="container">
        <h1>🎫 Event Ticketing System API Documentation</h1>
        
        <h2>Authentication Endpoints</h2>
        <div class="endpoint">
          <span class="method post">POST</span> /api/auth/register - Register a new user
        </div>
        <div class="endpoint">
          <span class="method post">POST</span> /api/auth/login - Login and get JWT token
        </div>
        
        <h2>Event Endpoints</h2>
        <div class="endpoint">
          <span class="method get">GET</span> /api/events - Get all events (with optional category and date filters)
        </div>
        <div class="endpoint">
          <span class="method get">GET</span> /api/events/:id - Get a specific event
        </div>
        <div class="endpoint">
          <span class="method post">POST</span> /api/events - Create a new event (Admin only)
        </div>
        <div class="endpoint">
          <span class="method put">PUT</span> /api/events/:id - Update an event (Admin only)
        </div>
        <div class="endpoint">
          <span class="method delete">DELETE</span> /api/events/:id - Delete an event (Admin only)
        </div>
        
        <h2>Booking Endpoints</h2>
        <div class="endpoint">
          <span class="method get">GET</span> /api/bookings - Get all your bookings (Authenticated users only)
        </div>
        <div class="endpoint">
          <span class="method get">GET</span> /api/bookings/:id - Get a specific booking (Authenticated users only)
        </div>
        <div class="endpoint">
          <span class="method post">POST</span> /api/bookings - Create a new booking (Authenticated users only)
        </div>
        <div class="endpoint">
          <span class="method get">GET</span> /api/bookings/validate/:qr - Validate a QR code
        </div>
        
        <h2>Authentication</h2>
        <p>Use the JWT token received from /api/auth/login by adding it to your request headers:</p>
        <p><code>Authorization: Bearer your_jwt_token</code></p>
      </div>
    </body>
    </html>
  `);
});

// API Routes
app.use('/api/auth', require('./routes/auth'));
app.use('/api/events', require('./routes/events'));
app.use('/api/bookings', require('./routes/bookings'));

// 404 Handler
app.use((req, res) => {
  const acceptHeader = req.get('Accept') || '';
  
  if (acceptHeader.includes('text/html')) {
    res.status(404).send(`
      <!DOCTYPE html>
      <html lang="en">
      <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>404 - Not Found</title>
        <style>
          body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
          }
          .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            text-align: center;
          }
          h1 { color: #f93e3e; font-size: 72px; margin: 0; }
          p { color: #666; }
          a { color: #667eea; text-decoration: none; }
        </style>
      </head>
      <body>
        <div class="container">
          <h1>404</h1>
          <p>Page not found</p>
          <p><a href="/">Go to home</a></p>
        </div>
      </body>
      </html>
    `);
  } else {
    res.status(404).json({ error: '404 Not Found' });
  }
});

// Error handling middleware
app.use(errorHandler);

const PORT = process.env.PORT || 5000;

app.listen(PORT, () => {
  console.log(`Server running on port ${PORT}`);
});
