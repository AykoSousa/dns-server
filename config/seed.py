from dotenv import load_dotenv

import os
import sqlite3

load_dotenv()

def seed_db():
    DB_PATH = os.getenv("DB_PATH")
    conn = sqlite3.connect(DB_PATH)
    cursor = conn.cursor()

    cursor.execute("CREATE TABLE IF NOT EXISTS blocked_domains (domain TEXT PRIMARY KEY)")

    initial_domains = [
        "example.com"
    ]

    for domain in initial_domains:
        try:
            cursor.execute("INSERT INTO blocked_domains (domain) VALUES (?)", (domain,))
        except sqlite3.IntegrityError:
            pass

    conn.commit()
    conn.close()

seed_db()