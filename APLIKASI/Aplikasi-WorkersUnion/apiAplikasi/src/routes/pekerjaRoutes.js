const express = require('express');
const pekerjaController = require('../controllers/pekerjaController');
const router = express.Router();

router.post('/', pekerjaController.createPekerja);
router.post('/checkEmail', pekerjaController.ambilPekerjaByEmail);

module.exports = router;
