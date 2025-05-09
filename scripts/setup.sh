echo "Setting up the environment..."
pip install -r requirements.txt
apt-get update && apt-get install -y dnsutils
apt-get install -y sqlite3
sqlite3 ./db/dns.db < ./db/init.sql
python3 ./config/seed.py
echo "Environment setup complete."