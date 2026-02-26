<?php 
    $domainToCheck = "abhinavjain.site";

    $dnsRecords = dns_get_record($domainToCheck, DNS_CNAME);

    if (!empty($dnsRecords)) {
        foreach ($dnsRecords as $record) {
            if ($record['target'] === "") {
                # code...
            }
            echo "Host: " . $record['host'] . " -> Target: " . $record['target'] . "\n";
        }
    } else {
        echo "No CNAME records found for $domainToCheck.\n";
    }
?>