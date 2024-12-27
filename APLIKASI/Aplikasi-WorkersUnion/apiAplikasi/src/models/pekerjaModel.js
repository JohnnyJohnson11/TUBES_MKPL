const pool = require('../config/database');
const bcrypt=require('bcrypt');
const {v4:uuidv4}=require('uuid');

class pekerjaModel {
  static async createPekerja(username, email, password, callback) {
    try {
      const salt = await bcrypt.genSalt(9);
      const hashedPassword = await bcrypt.hash(password, salt);
  
      const query = 'INSERT INTO pekerja (username, email, password) VALUES (?, ?, ?)';
      const values = [username, email, hashedPassword];
  
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

  static ambilSemuaPekerja(callback) {
    const query = 'SELECT * FROM pekerja';
  
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
  
  static ambilPekerjaByEmail(email, callback) {
    const query = 'SELECT * FROM pekerja WHERE email=?';
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

}

module.exports = pekerjaModel;