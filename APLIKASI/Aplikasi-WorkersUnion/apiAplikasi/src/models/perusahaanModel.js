const pool = require('../config/database');
const bcrypt=require('bcrypt');

class perusahaanModel{
    static async createPerusahaan(username, email, password, nomorHP, namaBisnis, callback) {
        try {
          const salt = await bcrypt.genSalt(9);
          const hashedPassword = await bcrypt.hash(password, salt);
      
          const query = 'INSERT INTO perusahaan (username, email, password, nomorHP, namaBisnis) VALUES (?, ?, ?, ?, ?)';
          const values = [username, email, hashedPassword, nomorHP, namaBisnis];
      
          pool.query(query, values, (error, results) => {
            if (typeof callback === 'function') {
              if (error) {
                return callback(error, null);
              }
              callback(null, results);
            } else {
              console.error("Callback is not a function:", callback);
            }
          });
        } catch (error) {
          if (typeof callback === 'function') {
            callback(error, null);
          } else {
            console.error("Callback is not a function:", callback);
          }
        }
      }
    
      static ambilSemuaPerusahaan(callback) {
        const query = 'SELECT * FROM perusahaan';
      
        pool.query(query, (error, results) => {
          if (typeof callback === 'function') {
            if (error) {
              return callback(error, null);
            }
            callback(null, results);
          } else {
            console.error("Callback is not a function:", callback);
          }
        });
      }
      static ambilPerusahaanByEmail(email, callback) {
        const query = 'SELECT * FROM perusahaan WHERE email=?';
        const values = [email];
        console.log("Searching for email:", email);
    
        pool.query(query, values, (error, results) => {
          if (typeof callback === 'function') {
            if (error) {
              return callback(error, null);
            }
            callback(null, results);
          } else {
            console.error("Callback is not a function:", callback);
          }
        });
      }
      static async logIn(email, password) {
        const query = 'SELECT * FROM perusahaan WHERE email=?';
        const values = [email];
    
        return new Promise((resolve, reject) => {
            pool.query(query, values, async (error, results) => {
                if (error) {
                    return reject(error); // Handle database error
                }
    
                if (results.length === 0) {
                    return resolve(false); // No user found
                }
    
                const user = results[0]; // Get the first result
                const isPasswordValid = await bcrypt.compare(password, user.password); // Compare passwords
    
                if (!isPasswordValid) {
                    return resolve(false); // Password doesn't match
                }
    
                resolve(user); // User verified
            });
        });
      }
      static ambilPerusahaanById(idPerusahaan, callback) {
        const query = `
            SELECT 
                idPerusahaan, 
                email, 
                password, 
                username, 
                nomorHP, 
                kontakUtama, 
                namaBisnis, 
                alamatPerusahaan, 
                emailPenagihan, 
                CAST(logoPerusahaan AS CHAR) AS logoPerusahaan 
                FROM perusahaan 
                WHERE idPerusahaan = ?`;
        const values = [idPerusahaan];
    
        pool.query(query, values, (error, results) => {
            if (typeof callback === 'function') {
                if (error) {
                    return callback(error, null);
                }
                callback(null, results);
            } else {
                console.error("Callback is not a function:", callback);
            }
        });
    }
    
    
      static uploadPekerjaan(idPerusahaan,judulPekerjaan,lokasiPekerjaan,kategoriJabatan,kategoriGaji,jenisGaji,kisaranGaji,bannerPerusahaan,deskripsiPerusahaan,linkReferensi, pertanyaan,callback){
        const query = 'INSERT INTO pekerjaan (idPerusahaan,judulPekerjaan,lokasiPekerjaan,kategoriJabatan,kategoriGaji,jenisGaji,kisaranGaji,bannerPerusahaan,deskripsiPerusahaan,linkReferensi, pertanyaan) VALUES (?, ?, ?, ?, ?,?,?,?,?,?,?)';
        const values = [idPerusahaan,judulPekerjaan,lokasiPekerjaan,kategoriJabatan,kategoriGaji,jenisGaji,kisaranGaji,bannerPerusahaan,deskripsiPerusahaan,linkReferensi, pertanyaan];
    
        pool.query(query, values, (error, results) => {
          if (typeof callback === 'function') {
            if (error) {
              return callback(error, null);
            }
            callback(null, results);
          } else {
            console.error("Callback is not a function:", callback);
          }
        });
      }
      static getPekerjaan(idPerusahaan, callback) {
        const query = "SELECT * FROM pekerjaan WHERE idPerusahaan = ?";
        pool.query(query, [idPerusahaan], (error, results) => {
            if (error) {
                return callback(error, null);
            }
            callback(null, results);
        });
      }
      static getPekerjaanById(idPekerjaan,callback){
        const query = `SELECT 
        idPekerjaan,
        idPerusahaan,
        judulPekerjaan,
        lokasiPekerjaan,
        kategoriJabatan,
        kategoriGaji,
        jenisGaji,
        kisaranGaji,
        CAST(bannerPerusahaan AS CHAR) AS bannerPerusahaan,
        deskripsiPerusahaan,
        linkReferensi,
        pertanyaan,
        created_at 
        FROM pekerjaan WHERE idPekerjaan = ?
        `;
        pool.query(query, [idPekerjaan], (error, results) => {
            if (error) {
                return callback(error, null);
            }
            callback(null, results);
        });
      }
      static updatePerusahaan(idPerusahaan, nomorHP,kontakUtama,alamatPerusahaan,emailPenagihan,logoPerusahaan,callback){
        const query='UPDATE perusahaan SET nomorHP = ?, kontakUtama = ?, alamatPerusahaan = ?, emailPenagihan = ?, logoPerusahaan = ? WHERE idPerusahaan=?;';
        const values=[nomorHP,kontakUtama,alamatPerusahaan,emailPenagihan,logoPerusahaan,idPerusahaan];
        pool.query(query, values, (error, results) => {
          if (typeof callback === 'function') {
            if (error) {
              return callback(error, null);
            }
            callback(null, results);
          } else {
            console.error("Callback is not a function:", callback);
          }
        });
      }
      static getPerusahaanAndPekerjaan(callback) {
        const query = "SELECT pekerjaan.idPekerjaan, CAST(perusahaan.logoPerusahaan AS CHAR) AS logoPerusahaan, pekerjaan.kategoriJabatan, pekerjaan.lokasiPekerjaan, pekerjaan.kisaranGaji,pekerjaan.jenisGaji, COUNT(*) OVER () AS totalCount FROM pekerjaan JOIN perusahaan ON pekerjaan.idPerusahaan = perusahaan.idPerusahaan;";
        pool.query(query,(error, results) => {
            if (error) {
                return callback(error, null);
            }
            callback(null, results);
        });
      }
}
module.exports = perusahaanModel;