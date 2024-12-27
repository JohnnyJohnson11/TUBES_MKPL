const PekerjaModel = require("../models/pekerjaModel");
const ResponseHandler = require("../utils/responseHandler");



class pekerjaController {
  static createPekerja(req, res) {
    const { username, email, password } = req.body;
    if (!username || !email || !password) {
      return ResponseHandler.error(res, 400, "Semua field harus diisi");
    }
    PekerjaModel.createPekerja(username, email, password, (error, result) => {
      if (error) {
        return ResponseHandler.error(res, 400, error.message);
      }
      PekerjaModel.ambilSemuaPekerja((error, pekerjas) => {
        if (error) {
          return ResponseHandler.error(res, 400, error.message);
        }
        ResponseHandler.sukses(res, 201, pekerjas);
      });
    });
  }
  
  static ambilSemuaPekerja(req, res) {
    console.log("Mengambil semua data pekerja...");

    PekerjaModel.ambilSemuaPekerja((error, pekerjas) => {
      if (error) {
        console.error(error);
        return ResponseHandler.error(res, 500, error.message);
      }
      ResponseHandler.sukses(res, 200, pekerjas);
    });
  }

  static ambilPekerjaByEmail(req, res) {
    console.log("Mengambil semua data pekerja...");
    const {email} = req.body;
    PekerjaModel.ambilPekerjaByEmail(email,(error, pekerjas) => {
      if (error) {
        console.error(error);
        return ResponseHandler.error(res, 500, error.message);
      }
      ResponseHandler.sukses(res, 200, pekerjas);
    });
  }

}

module.exports = pekerjaController;
