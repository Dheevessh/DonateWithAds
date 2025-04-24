from flask import Flask, render_template, request, redirect
import sqlite3
import os

app = Flask(__name__)
DB_PATH = 'data/votes.db'

# Initialize the database
def init_db():
    os.makedirs('data', exist_ok=True)
    with sqlite3.connect(DB_PATH) as conn:
        conn.execute(
            "CREATE TABLE IF NOT EXISTS votes (charity TEXT PRIMARY KEY, count INTEGER)"
        )
        for charity in ["Red Cross", "UNICEF", "Doctors Without Borders"]:
            conn.execute("INSERT OR IGNORE INTO votes (charity, count) VALUES (?, ?)", (charity, 0))
        conn.commit()

@app.route('/', methods=['GET', 'POST'])
def index():
    if request.method == 'POST':
        selected_charity = request.form.get('charity')
        if selected_charity:
            with sqlite3.connect(DB_PATH) as conn:
                conn.execute("UPDATE votes SET count = count + 1 WHERE charity = ?", (selected_charity,))
                conn.commit()
        return redirect('/')

    with sqlite3.connect(DB_PATH) as conn:
        results = conn.execute("SELECT charity, count FROM votes ORDER BY count DESC").fetchall()
    return render_template("index.html", votes=results)

if __name__ == '__main__':
    init_db()
    app.run(debug=True)
