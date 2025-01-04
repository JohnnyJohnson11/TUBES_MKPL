const express = require('express');
const bodyParser = require('body-parser');
const app = express();
require('dotenv').config();
const pekerjaRoutes = require('./src/routes/pekerjaRoutes');
const perusahaanRoutes = require('./src/routes/perusahaanRoutes');
const cors = require('cors');

// Middleware for CORS
app.use(cors());

// Middleware to handle large JSON and form-data payloads
app.use(bodyParser.json({ limit: '10mb' }));
app.use(bodyParser.urlencoded({ limit: '10mb', extended: true }));

// Define your routes
app.use('/api', pekerjaRoutes);
app.use('/api', perusahaanRoutes);

// Start the server
const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
  console.log(`Server berjalan di port ${PORT}`);
});
