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

  static async logIn(req, res) {
    try {
        const { email, password } = req.body;

        const user = await PekerjaModel.logIn(email, password);

        if (!user) {
            return res.status(200).send({ message: 'Invalid email or password', passwordCorrect: false});
        }

        return res.status(200).send({ message: 'Login successful', user, passwordCorrect: true });
    } catch (error) {
        console.error('Error during login:', error);
        return res.status(500).send({ message: 'Internal server error' , passwordCorrect: false});
    }
  }

  static async ambilPekerjaById(req, res) {
    const {idPekerja} = req.body;
    PekerjaModel.ambilPekerjaById(idPekerja,(error, pekerjas) => {
      if (error) {
        console.error(error);
        return ResponseHandler.error(res, 500, error.message);
      }
      ResponseHandler.sukses(res, 200, pekerjas);
    });
  }

  static async addRingkasan(req, res) {
    const {idPekerja,ringkasan} = req.body;
    PekerjaModel.addRingkasan(idPekerja, ringkasan,(error, pekerjas) => {
      if (error) {
        console.error(error);
        return ResponseHandler.error(res, 500, error.message);
      }
      ResponseHandler.sukses(res, 200, pekerjas);
    });
  }

  static async addInformasiPekerjaan(req,res){
    const {idPekerja, posisiPekerjaan, namaPerusahaan, tahunMulaiPekerjaan, tahunBerakhirPekerjaan, statusJabatanPekerjaan, deskripsiPekerjaan} = req.body;
    PekerjaModel.addInformasiPekerjaan(idPekerja, posisiPekerjaan, namaPerusahaan, tahunMulaiPekerjaan, tahunBerakhirPekerjaan, statusJabatanPekerjaan, deskripsiPekerjaan,(error, pekerjas) => {
      if (error) {
        console.error(error);
        return ResponseHandler.error(res, 500, error.message);
      }
      ResponseHandler.sukses(res, 200, pekerjas);
    });
  }
  
  static async addInformasiPendidikan(req,res){
    const {idPekerja, kursusPendidikan, lembagaPendidikan, statusKualifikasiPendidikan, tahunSelesaiPendidikan, poinPentingPendidikan} = req.body;
    PekerjaModel.addInformasiPendidikan(idPekerja, kursusPendidikan, lembagaPendidikan, statusKualifikasiPendidikan, tahunSelesaiPendidikan, poinPentingPendidikan,(error, pekerjas) => {
      if (error) {
        console.error(error);
        return ResponseHandler.error(res, 500, error.message);
      }
      ResponseHandler.sukses(res, 200, pekerjas);
    });
  }

  static async addInformasiLisensi(req,res){
    const {idPekerja, namaLisensi, organisasiPenerbitLisensi, tanggalTerbitLisensi, tanggalKadaluwarsaLisensi, statusLisensi, deskripsiLisensi}=req.body;
    PekerjaModel.addInformasiLisensi(idPekerja, namaLisensi, organisasiPenerbitLisensi, tanggalTerbitLisensi, tanggalKadaluwarsaLisensi, statusLisensi, deskripsiLisensi,(error, pekerjas) => {
      if (error) {
        console.error(error);
        return ResponseHandler.error(res, 500, error.message);
      }
      ResponseHandler.sukses(res, 200, pekerjas);
    });
  }  
  static async addSkills(req, res) {
    const { idPekerja, skills } = req.body;

    if (!idPekerja || !Array.isArray(skills)) {
        return ResponseHandler.error(res, 400, "Invalid input");
    }

    try {
        PekerjaModel.addSkills(idPekerja, skills, (error, results) => {
            if (error) {
                console.error(error);
                return ResponseHandler.error(res, 500, "Failed to save skills");
            }
            return ResponseHandler.sukses(res, 200, "Skills saved successfully");
        });
    } catch (error) {
        console.error(error);
        return ResponseHandler.error(res, 500, "Unexpected error occurred");
    }
  }
  static async getSkills(req, res) {
    const { idPekerja } = req.body;

    if (!idPekerja) {
        return res.status(400).json({
            success: false,
            message: "idPekerja is required.",
        });
    }

    try {
        PekerjaModel.getSkills(idPekerja, (error, results) => {
            if (error) {
                console.error("Error fetching skills:", error);
                return res.status(500).json({
                    success: false,
                    message: "Failed to fetch skills.",
                });
            }

            return res.status(200).json({
                success: true,
                skills: results,
            });
        });
    } catch (error) {
        console.error("Unexpected error:", error);
        return res.status(500).json({
            success: false,
            message: "An unexpected error occurred.",
        });
    }
  }

  static async deleteSkills(req,res){
    const { idPekerja } = req.body;

    if (!idPekerja) {
        return res.status(400).json({
            success: false,
            message: "idPekerja is required.",
        });
    }

    try {
        PekerjaModel.deleteSkills(idPekerja, (error, results) => {
            if (error) {
                console.error("Error fetching skills:", error);
                return res.status(500).json({
                    success: false,
                    message: "Failed to fetch skills.",
                });
            }

            return res.status(200).json({
                success: true,
                skills: results,
            });
        });
    } catch (error) {
        console.error("Unexpected error:", error);
        return res.status(500).json({
            success: false,
            message: "An unexpected error occurred.",
        });
    }
  }

}

module.exports = pekerjaController;
