from config.init import load_blocked_domains
from src.handle_requests import is_blocked

from dnslib import DNSRecord

import pytest
import socket

def test_is_blocked_true():
    assert is_blocked("example.com")

def test_is_blocked_false():
    assert not is_blocked("google.com")

def test_load_blocked_domains_from_db():
    blocked = load_blocked_domains()
    assert isinstance(blocked, list)
    assert "example.com" in blocked

def test_send_block_request():
    qname= "example.com"
    request = DNSRecord.question(qname, qtype="A")
    
    sock = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
    sock.sendto(request.pack(), ("127.0.0.1", 53))
    data, addr = sock.recvfrom(512)
    response = DNSRecord.parse(data)
    
    assert response.header.rcode == 0
    assert response.header.qr == 1
    assert response.header.aa == 1
    assert response.header.ra == 1
    assert response.q.qname == qname
    assert response.rr[0].rdata == "0.0.0.0"
    assert response.rr[0].ttl == 0
