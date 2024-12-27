
const express = require('express');
const app = express();
require('dotenv').config();
const pekerjaRoutes = require('./src/routes/pekerjaRoutes');
const cors = require('cors');

app.use(cors());
app.use(express.json());
app.use('/api', pekerjaRoutes);

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
  console.log(`Server berjalan di port ${PORT}`);
});