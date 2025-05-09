import dotenv
import logging
import os
import sqlite3

dotenv.load_dotenv()

def init_config()-> tuple[str, int]:
    SERVER_ADDRES = os.getenv("SERVER_ADDRES")
    SERVER_PORT = int(os.getenv("SERVER_PORT", 53))

    if SERVER_ADDRES is None:
        raise ValueError("SERVER_ADDRES environment variable is not set.")
    if SERVER_PORT is None:
        raise ValueError("SERVER_PORT environment variable is not set.")

    return SERVER_ADDRES, SERVER_PORT

def load_blocked_domains()-> list[str]:
    DB_PATH = os.getenv("DB_PATH")
    conn = sqlite3.connect(DB_PATH)
    cursor = conn.cursor()
    cursor.execute("CREATE TABLE IF NOT EXISTS blocked_domains (domain TEXT PRIMARY KEY)")
    cursor.execute("SELECT domain FROM blocked_domains")
    blocked_domains = [row[0] for row in cursor.fetchall()]
    conn.close()
    return blocked_domains

def init_log_config()-> logging.Logger:
    os.makedirs("logs", exist_ok=True)
    logging.basicConfig(
        level=logging.INFO,
        format="%(asctime)s - %(name)s - %(levelname)s - %(message)s",
        handlers=[
            logging.FileHandler("logs/app.log"),
            logging.StreamHandler()
        ]
    )
    
    return logging