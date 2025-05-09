from config.init import init_config, init_log_config
from src.handle_requests import handle_request
import socket

SERVER_ADDRES, SERVER_PORT = init_config()
logging = init_log_config()
    
def main():
    logging.info("Starting DNS server...")
    sock = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
    sock.bind((SERVER_ADDRES, SERVER_PORT))
    logging.info(f"DNS server running on {SERVER_ADDRES}:{SERVER_PORT}")

    try:
        while True:
            data, addr = sock.recvfrom(512)
            response = handle_request(data, addr)
            sock.sendto(response, addr)
            logging.info(f"Sent response to {addr}")
    except KeyboardInterrupt:
        logging.warning("Shutting down DNS server...")
        sock.close()
        logging.warning("DNS server shut down.")
    except Exception as e:
        logging.error(f"An error occurred: {e}")
        sock.close()
        logging.error("DNS server shut down due to error.")

if __name__ == "__main__":
    main()
        