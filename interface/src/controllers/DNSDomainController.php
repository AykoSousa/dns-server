<?php
namespace Controllers;

use Flight;
use Models\DNSDomainModel;

class DNSDomainController {
    private $model;

    public function __construct($db)
    {
        $this->model = new DNSDomainModel($db);
    }

    public function getAllDomains()
    {
        return $this->model->getAllDomains();
    }

    public function removeDomain($id): array
    {
        if (!$this->model->removeDomain($id)) {
            return ['success' => false, 'message' => 'Failed to remove domain.'];
        }
        
        return ['success' => true, 'message' => 'Domain removed successfully.'];
    }

    public function addDomain($domain): array
    {
        if ($this->model->domainExists($domain)) {
            return ['success' => false, 'message' => "Domain already exists."];
        }

        if ($this->model->addDomain($domain)) {
            return ['success' => true, 'message' => "Domain added successfully."];
        } else {
            return ['success' => false, 'message' => "Failed to add domain."];
        }
    }
}