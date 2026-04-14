from flask import Flask, render_template, request, redirect
from flask_mysqldb import MySQL
import MySQLdb.cursors
import hashlib

app = Flask(__name__)

# Database configuration
app.config['MYSQL_HOST'] = 'localhost'
app.config['MYSQL_USER'] = 'root'
app.config['MYSQL_PASSWORD'] = ''  # Add your password here
app.config['MYSQL_DB'] = 'Campus_share'

mysql = MySQL(app)

@app.route('/register', methods=['GET', 'POST'])
def register():
    if request.method == 'POST':
        username = request.form['username']
        email = request.form['email']
        password = request.form['password']
        confirm = request.form['confirm-password']

        if password != confirm:
            return "Passwords do not match!"

        # Hash the password using SHA-256 (for example)
        password_hash = hashlib.sha256(password.encode()).hexdigest()

        cursor = mysql.connection.cursor()
        cursor.execute('INSERT INTO Users (username, email, password_hash) VALUES (%s, %s, %s)',
                       (username, email, password_hash))
        mysql.connection.commit()
        cursor.close()

        return "User registered successfully!"

    return render_template('register.html')  # You can use your form here

if __name__ == '__main__':
    app.run(debug=True)
