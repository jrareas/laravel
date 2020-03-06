<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Iodev\Whois\Whois;

class Who extends Controller
{
    private $whois;
    private function getWhois() {
        if ($this->whois == null) {
            $this->whois = Whois::create();
        }
        return $this->whois;
    }

    public function is($url) {
        $data = ["available" => $this->getWhois()->isDomainAvailable($url)];
        if ($data['available'] !== true) {
            $info = $this->getWhois()->loadDomainInfo($url);
            $data["data"] = [
                'Domain created' => date("Y-m-d", $info->getCreationDate()),
                'Domain expires' => date("Y-m-d", $info->getExpirationDate()),
                'Domain owner' => $info->getOwner()
            ];
        }
        // Getting parsed domain info
        return response($data);
    }

    public function domaiAvailable($url) {
        return $this->getWhois()->isDomainAvailable($url);
    }
}
