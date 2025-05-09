from config.init import load_blocked_domains, init_log_config
from dnslib import DNSRecord, DNSHeader, RR, A
from dns import resolver

BLOCKED_DOMAINS = load_blocked_domains()
logging = init_log_config()

def is_blocked(domain: str) -> bool:
    return domain in BLOCKED_DOMAINS

def handle_request(data, addr):
    request = DNSRecord.parse(data)
    domain = str(request.q.qname).rstrip('.')
    logging.info(f"Received request for domain: {domain} from {addr}")
    
    if is_blocked(domain):
        logging.warning(f"Blocked domain request: {domain} from {addr}")
        return DNSRecord(
            DNSHeader(id=request.header.id, qr=1, aa=1, ra=1),
            q=request.q,
            a=RR(domain, rdata=A("0.0.0.0"), ttl=0)
        ).pack()
    else:
        dns_resolver = resolver.Resolver()
        response = dns_resolver.resolve(domain)
        ip = response[0].address
        return DNSRecord(
            DNSHeader(id=request.header.id, qr=1, aa=1, ra=1),
            q=request.q,
            a=RR(domain, rdata=A(ip), ttl=300)
        ).pack()