const express = require('express');
const connectDB = require('./dbConfig');
require('dotenv').config();

const app = express();

//Middleware
app.use(express.json());

//Connect to Mongo
connectDB();

//Routes
app.use('/students', require('./routes/students'));

const PORT = process.env.PORT || 3000;

app.listen(PORT, () => {
  console.log(`Server running on port ${PORT}`);
});