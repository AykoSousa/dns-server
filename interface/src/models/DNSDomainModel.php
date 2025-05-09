<?php
namespace Models;

use PDO;

class DNSDomainModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllDomains(): array
    {
        $stmt = $this->db->prepare("SELECT id, domain FROM blocked_domains");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function removeDomain($id): array
    {
        $stmt = $this->db->prepare("DELETE FROM blocked_domains WHERE id = ?");
        $stmt->execute([$id]);
        return ['message' => 'Domain' . $id . 'deleted.'];
    }

    public function addDomain($domain): array
    {
        $stmt = $this->db->prepare("INSERT INTO blocked_domains (domain) VALUES (?)");
        $stmt->execute([$domain]);
        return ['domain' => $domain];
    }

    public function domainExists($domain): bool
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM blocked_domains WHERE domain = ?");
        $stmt->execute([$domain]);
        return $stmt->fetchColumn() > 0;
    }
}