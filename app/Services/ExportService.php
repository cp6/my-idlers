<?php

namespace App\Services;

use App\Models\DNS;
use App\Models\Domains;
use App\Models\Misc;
use App\Models\Reseller;
use App\Models\SeedBoxes;
use App\Models\Server;
use App\Models\Shared;
use Illuminate\Support\Collection;

class ExportService
{
    /**
     * Valid export formats
     */
    protected const VALID_FORMATS = ['json', 'csv'];

    /**
     * Validate export format
     *
     * @param string $format
     * @return bool
     */
    public function isValidFormat(string $format): bool
    {
        return in_array(strtolower($format), self::VALID_FORMATS, true);
    }

    /**
     * Export servers with all related data (YABS, pricing, IPs)
     *
     * @param string $format 'json' or 'csv'
     * @return array{data: string, filename: string, content_type: string}
     */
    public function exportServers(string $format): array
    {
        $format = strtolower($format);
        
        // Fetch all servers with relationships
        $servers = Server::with([
            'location',
            'provider',
            'os',
            'price',
            'ips',
            'yabs',
            'yabs.disk_speed',
            'yabs.network_speed'
        ])->get();

        // Transform server data
        $exportData = $servers->map(function ($server) {
            return $this->transformServerForExport($server);
        });

        $timestamp = date('Y-m-d_His');

        if ($format === 'json') {
            return [
                'data' => $this->toJson($exportData),
                'filename' => "servers_export_{$timestamp}.json",
                'content_type' => 'application/json'
            ];
        }

        // CSV format
        return [
            'data' => $this->toCsv($exportData, $this->getServerCsvHeaders()),
            'filename' => "servers_export_{$timestamp}.csv",
            'content_type' => 'text/csv'
        ];
    }

    /**
     * Export domains with pricing data
     *
     * @param string $format 'json' or 'csv'
     * @return array{data: string, filename: string, content_type: string}
     */
    public function exportDomains(string $format): array
    {
        $format = strtolower($format);

        // Fetch all domains with relationships
        $domains = Domains::with(['provider', 'price'])->get();

        // Transform domain data
        $exportData = $domains->map(function ($domain) {
            return $this->transformDomainForExport($domain);
        });

        $timestamp = date('Y-m-d_His');

        if ($format === 'json') {
            return [
                'data' => $this->toJson($exportData),
                'filename' => "domains_export_{$timestamp}.json",
                'content_type' => 'application/json'
            ];
        }

        // CSV format
        return [
            'data' => $this->toCsv($exportData, $this->getDomainCsvHeaders()),
            'filename' => "domains_export_{$timestamp}.csv",
            'content_type' => 'text/csv'
        ];
    }

    /**
     * Export shared hosting with pricing and IPs
     *
     * @param string $format 'json' or 'csv'
     * @return array{data: string, filename: string, content_type: string}
     */
    public function exportShared(string $format): array
    {
        $format = strtolower($format);

        // Fetch all shared hosting with relationships
        $sharedHosting = Shared::with(['location', 'provider', 'price', 'ips'])->get();

        // Transform shared hosting data
        $exportData = $sharedHosting->map(function ($shared) {
            return $this->transformSharedForExport($shared);
        });

        $timestamp = date('Y-m-d_His');

        if ($format === 'json') {
            return [
                'data' => $this->toJson($exportData),
                'filename' => "shared_hosting_export_{$timestamp}.json",
                'content_type' => 'application/json'
            ];
        }

        // CSV format
        return [
            'data' => $this->toCsv($exportData, $this->getSharedCsvHeaders()),
            'filename' => "shared_hosting_export_{$timestamp}.csv",
            'content_type' => 'text/csv'
        ];
    }

    /**
     * Export reseller hosting with pricing and IPs
     *
     * @param string $format 'json' or 'csv'
     * @return array{data: string, filename: string, content_type: string}
     */
    public function exportReseller(string $format): array
    {
        $format = strtolower($format);

        // Fetch all reseller hosting with relationships
        $resellerHosting = Reseller::with(['location', 'provider', 'price', 'ips'])->get();

        // Transform reseller hosting data
        $exportData = $resellerHosting->map(function ($reseller) {
            return $this->transformResellerForExport($reseller);
        });

        $timestamp = date('Y-m-d_His');

        if ($format === 'json') {
            return [
                'data' => $this->toJson($exportData),
                'filename' => "reseller_hosting_export_{$timestamp}.json",
                'content_type' => 'application/json'
            ];
        }

        // CSV format
        return [
            'data' => $this->toCsv($exportData, $this->getResellerCsvHeaders()),
            'filename' => "reseller_hosting_export_{$timestamp}.csv",
            'content_type' => 'text/csv'
        ];
    }

    /**
     * Export seedboxes with pricing
     *
     * @param string $format 'json' or 'csv'
     * @return array{data: string, filename: string, content_type: string}
     */
    public function exportSeedboxes(string $format): array
    {
        $format = strtolower($format);

        // Fetch all seedboxes with relationships
        $seedboxes = SeedBoxes::with(['location', 'provider', 'price'])->get();

        // Transform seedbox data
        $exportData = $seedboxes->map(function ($seedbox) {
            return $this->transformSeedboxForExport($seedbox);
        });

        $timestamp = date('Y-m-d_His');

        if ($format === 'json') {
            return [
                'data' => $this->toJson($exportData),
                'filename' => "seedboxes_export_{$timestamp}.json",
                'content_type' => 'application/json'
            ];
        }

        // CSV format
        return [
            'data' => $this->toCsv($exportData, $this->getSeedboxCsvHeaders()),
            'filename' => "seedboxes_export_{$timestamp}.csv",
            'content_type' => 'text/csv'
        ];
    }

    /**
     * Export DNS records
     *
     * @param string $format 'json' or 'csv'
     * @return array{data: string, filename: string, content_type: string}
     */
    public function exportDns(string $format): array
    {
        $format = strtolower($format);

        // Fetch all DNS records
        $dnsRecords = DNS::all();

        // Transform DNS data
        $exportData = $dnsRecords->map(function ($dns) {
            return $this->transformDnsForExport($dns);
        });

        $timestamp = date('Y-m-d_His');

        if ($format === 'json') {
            return [
                'data' => $this->toJson($exportData),
                'filename' => "dns_export_{$timestamp}.json",
                'content_type' => 'application/json'
            ];
        }

        // CSV format
        return [
            'data' => $this->toCsv($exportData, $this->getDnsCsvHeaders()),
            'filename' => "dns_export_{$timestamp}.csv",
            'content_type' => 'text/csv'
        ];
    }

    /**
     * Transform a single DNS record for export
     *
     * @param DNS $dns
     * @return array
     */
    protected function transformDnsForExport(DNS $dns): array
    {
        return [
            'id' => $dns->id,
            'hostname' => $dns->hostname,
            'dns_type' => $dns->dns_type,
            'address' => $dns->address,
            'server_id' => $dns->server_id,
            'domain_id' => $dns->domain_id,
        ];
    }

    /**
     * Get CSV headers for DNS export
     *
     * @return array
     */
    protected function getDnsCsvHeaders(): array
    {
        return [
            'id',
            'hostname',
            'dns_type',
            'address',
            'server_id',
            'domain_id'
        ];
    }

    /**
     * Export miscellaneous services with pricing
     *
     * @param string $format 'json' or 'csv'
     * @return array{data: string, filename: string, content_type: string}
     */
    public function exportMisc(string $format): array
    {
        $format = strtolower($format);

        // Fetch all misc services with relationships
        $miscServices = Misc::with(['price'])->get();

        // Transform misc service data
        $exportData = $miscServices->map(function ($misc) {
            return $this->transformMiscForExport($misc);
        });

        $timestamp = date('Y-m-d_His');

        if ($format === 'json') {
            return [
                'data' => $this->toJson($exportData),
                'filename' => "misc_services_export_{$timestamp}.json",
                'content_type' => 'application/json'
            ];
        }

        // CSV format
        return [
            'data' => $this->toCsv($exportData, $this->getMiscCsvHeaders()),
            'filename' => "misc_services_export_{$timestamp}.csv",
            'content_type' => 'text/csv'
        ];
    }

    /**
     * Transform a single misc service model for export
     *
     * @param Misc $misc
     * @return array
     */
    protected function transformMiscForExport(Misc $misc): array
    {
        $data = [
            'id' => $misc->id,
            'name' => $misc->name,
            'owned_since' => $misc->owned_since,
        ];

        // Add pricing data
        $data['pricing'] = $misc->price ? [
            'price' => $misc->price->price,
            'currency' => $misc->price->currency,
            'term' => $misc->price->term,
            'term_name' => $this->getTermName($misc->price->term),
            'as_usd' => $misc->price->as_usd,
            'usd_per_month' => $misc->price->usd_per_month,
            'next_due_date' => $misc->price->next_due_date
        ] : null;

        return $data;
    }

    /**
     * Get CSV headers for misc services export
     *
     * @return array
     */
    protected function getMiscCsvHeaders(): array
    {
        return [
            'id',
            'name',
            'owned_since',
            'pricing_price',
            'pricing_currency',
            'pricing_term',
            'pricing_term_name',
            'pricing_as_usd',
            'pricing_usd_per_month',
            'pricing_next_due_date'
        ];
    }

    /**
     * Transform a single seedbox model for export
     *
     * @param SeedBoxes $seedbox
     * @return array
     */
    protected function transformSeedboxForExport(SeedBoxes $seedbox): array
    {
        $data = [
            'id' => $seedbox->id,
            'title' => $seedbox->title,
            'hostname' => $seedbox->hostname,
            'seed_box_type' => $seedbox->seed_box_type,
            'disk' => $seedbox->disk,
            'disk_type' => $seedbox->disk_type,
            'disk_as_gb' => $seedbox->disk_as_gb,
            'bandwidth' => $seedbox->bandwidth,
            'port_speed' => $seedbox->port_speed,
            'was_promo' => $seedbox->was_promo,
            'active' => $seedbox->active,
            'owned_since' => $seedbox->owned_since,
        ];

        // Add location relationship
        $data['location'] = $seedbox->location ? [
            'id' => $seedbox->location->id,
            'name' => $seedbox->location->name
        ] : null;

        // Add provider relationship
        $data['provider'] = $seedbox->provider ? [
            'id' => $seedbox->provider->id,
            'name' => $seedbox->provider->name
        ] : null;

        // Add pricing data
        $data['pricing'] = $seedbox->price ? [
            'price' => $seedbox->price->price,
            'currency' => $seedbox->price->currency,
            'term' => $seedbox->price->term,
            'term_name' => $this->getTermName($seedbox->price->term),
            'as_usd' => $seedbox->price->as_usd,
            'usd_per_month' => $seedbox->price->usd_per_month,
            'next_due_date' => $seedbox->price->next_due_date
        ] : null;

        return $data;
    }

    /**
     * Get CSV headers for seedbox export
     *
     * @return array
     */
    protected function getSeedboxCsvHeaders(): array
    {
        return [
            'id',
            'title',
            'hostname',
            'seed_box_type',
            'disk',
            'disk_type',
            'disk_as_gb',
            'bandwidth',
            'port_speed',
            'was_promo',
            'active',
            'owned_since',
            'location_id',
            'location_name',
            'provider_id',
            'provider_name',
            'pricing_price',
            'pricing_currency',
            'pricing_term',
            'pricing_term_name',
            'pricing_as_usd',
            'pricing_usd_per_month',
            'pricing_next_due_date'
        ];
    }

    /**
     * Transform a single reseller hosting model for export
     *
     * @param Reseller $reseller
     * @return array
     */
    protected function transformResellerForExport(Reseller $reseller): array
    {
        $data = [
            'id' => $reseller->id,
            'main_domain' => $reseller->main_domain,
            'reseller_type' => $reseller->reseller_type,
            'accounts' => $reseller->accounts,
            'disk' => $reseller->disk,
            'disk_type' => $reseller->disk_type,
            'disk_as_gb' => $reseller->disk_as_gb,
            'bandwidth' => $reseller->bandwidth,
            'domains_limit' => $reseller->domains_limit,
            'subdomains_limit' => $reseller->subdomains_limit,
            'ftp_limit' => $reseller->ftp_limit,
            'email_limit' => $reseller->email_limit,
            'db_limit' => $reseller->db_limit,
            'was_promo' => $reseller->was_promo,
            'active' => $reseller->active,
            'owned_since' => $reseller->owned_since,
        ];

        // Add location relationship
        $data['location'] = $reseller->location ? [
            'id' => $reseller->location->id,
            'name' => $reseller->location->name
        ] : null;

        // Add provider relationship
        $data['provider'] = $reseller->provider ? [
            'id' => $reseller->provider->id,
            'name' => $reseller->provider->name
        ] : null;

        // Add IP addresses
        $data['ips'] = $reseller->ips->map(function ($ip) {
            return [
                'address' => $ip->address,
                'is_ipv4' => $ip->is_ipv4
            ];
        })->toArray();

        // Add pricing data
        $data['pricing'] = $reseller->price ? [
            'price' => $reseller->price->price,
            'currency' => $reseller->price->currency,
            'term' => $reseller->price->term,
            'term_name' => $this->getTermName($reseller->price->term),
            'as_usd' => $reseller->price->as_usd,
            'usd_per_month' => $reseller->price->usd_per_month,
            'next_due_date' => $reseller->price->next_due_date
        ] : null;

        return $data;
    }

    /**
     * Get CSV headers for reseller hosting export
     *
     * @return array
     */
    protected function getResellerCsvHeaders(): array
    {
        return [
            'id',
            'main_domain',
            'reseller_type',
            'accounts',
            'disk',
            'disk_type',
            'disk_as_gb',
            'bandwidth',
            'domains_limit',
            'subdomains_limit',
            'ftp_limit',
            'email_limit',
            'db_limit',
            'was_promo',
            'active',
            'owned_since',
            'location_id',
            'location_name',
            'provider_id',
            'provider_name',
            'ips',
            'pricing_price',
            'pricing_currency',
            'pricing_term',
            'pricing_term_name',
            'pricing_as_usd',
            'pricing_usd_per_month',
            'pricing_next_due_date'
        ];
    }

    /**
     * Transform a single shared hosting model for export
     *
     * @param Shared $shared
     * @return array
     */
    protected function transformSharedForExport(Shared $shared): array
    {
        $data = [
            'id' => $shared->id,
            'main_domain' => $shared->main_domain,
            'shared_type' => $shared->shared_type,
            'disk' => $shared->disk,
            'disk_type' => $shared->disk_type,
            'disk_as_gb' => $shared->disk_as_gb,
            'bandwidth' => $shared->bandwidth,
            'domains_limit' => $shared->domains_limit,
            'subdomains_limit' => $shared->subdomains_limit,
            'ftp_limit' => $shared->ftp_limit,
            'email_limit' => $shared->email_limit,
            'db_limit' => $shared->db_limit,
            'was_promo' => $shared->was_promo,
            'active' => $shared->active,
            'owned_since' => $shared->owned_since,
        ];

        // Add location relationship
        $data['location'] = $shared->location ? [
            'id' => $shared->location->id,
            'name' => $shared->location->name
        ] : null;

        // Add provider relationship
        $data['provider'] = $shared->provider ? [
            'id' => $shared->provider->id,
            'name' => $shared->provider->name
        ] : null;

        // Add IP addresses
        $data['ips'] = $shared->ips->map(function ($ip) {
            return [
                'address' => $ip->address,
                'is_ipv4' => $ip->is_ipv4
            ];
        })->toArray();

        // Add pricing data
        $data['pricing'] = $shared->price ? [
            'price' => $shared->price->price,
            'currency' => $shared->price->currency,
            'term' => $shared->price->term,
            'term_name' => $this->getTermName($shared->price->term),
            'as_usd' => $shared->price->as_usd,
            'usd_per_month' => $shared->price->usd_per_month,
            'next_due_date' => $shared->price->next_due_date
        ] : null;

        return $data;
    }

    /**
     * Get CSV headers for shared hosting export
     *
     * @return array
     */
    protected function getSharedCsvHeaders(): array
    {
        return [
            'id',
            'main_domain',
            'shared_type',
            'disk',
            'disk_type',
            'disk_as_gb',
            'bandwidth',
            'domains_limit',
            'subdomains_limit',
            'ftp_limit',
            'email_limit',
            'db_limit',
            'was_promo',
            'active',
            'owned_since',
            'location_id',
            'location_name',
            'provider_id',
            'provider_name',
            'ips',
            'pricing_price',
            'pricing_currency',
            'pricing_term',
            'pricing_term_name',
            'pricing_as_usd',
            'pricing_usd_per_month',
            'pricing_next_due_date'
        ];
    }

    /**
     * Transform a single domain model for export
     *
     * @param Domains $domain
     * @return array
     */
    protected function transformDomainForExport(Domains $domain): array
    {
        $data = [
            'id' => $domain->id,
            'domain' => $domain->domain,
            'extension' => $domain->extension,
            'full_domain' => $domain->domain . '.' . $domain->extension,
            'ns1' => $domain->ns1,
            'ns2' => $domain->ns2,
            'ns3' => $domain->ns3,
            'owned_since' => $domain->owned_since,
        ];

        // Add provider relationship
        $data['provider'] = $domain->provider ? [
            'id' => $domain->provider->id,
            'name' => $domain->provider->name
        ] : null;

        // Add pricing data
        $data['pricing'] = $domain->price ? [
            'price' => $domain->price->price,
            'currency' => $domain->price->currency,
            'term' => $domain->price->term,
            'term_name' => $this->getTermName($domain->price->term),
            'as_usd' => $domain->price->as_usd,
            'usd_per_month' => $domain->price->usd_per_month,
            'next_due_date' => $domain->price->next_due_date
        ] : null;

        return $data;
    }

    /**
     * Get CSV headers for domain export
     *
     * @return array
     */
    protected function getDomainCsvHeaders(): array
    {
        return [
            'id',
            'domain',
            'extension',
            'full_domain',
            'ns1',
            'ns2',
            'ns3',
            'owned_since',
            'provider_id',
            'provider_name',
            'pricing_price',
            'pricing_currency',
            'pricing_term',
            'pricing_term_name',
            'pricing_as_usd',
            'pricing_usd_per_month',
            'pricing_next_due_date'
        ];
    }

    /**
     * Transform a single server model for export
     *
     * @param Server $server
     * @return array
     */
    protected function transformServerForExport(Server $server): array
    {
        $data = [
            'id' => $server->id,
            'hostname' => $server->hostname,
            'server_type' => $server->server_type,
            'server_type_name' => Server::serviceServerType($server->server_type ?? 0, false),
            'cpu' => $server->cpu,
            'ram' => $server->ram,
            'ram_type' => $server->ram_type,
            'ram_as_mb' => $server->ram_as_mb,
            'disk' => $server->disk,
            'disk_type' => $server->disk_type,
            'disk_as_gb' => $server->disk_as_gb,
            'bandwidth' => $server->bandwidth,
            'ssh' => $server->ssh,
            'active' => $server->active,
            'owned_since' => $server->owned_since,
        ];

        // Add OS relationship
        $data['os'] = $server->os ? [
            'id' => $server->os->id,
            'name' => $server->os->name
        ] : null;

        // Add location relationship
        $data['location'] = $server->location ? [
            'id' => $server->location->id,
            'name' => $server->location->name
        ] : null;

        // Add provider relationship
        $data['provider'] = $server->provider ? [
            'id' => $server->provider->id,
            'name' => $server->provider->name
        ] : null;

        // Add IP addresses
        $data['ips'] = $server->ips->map(function ($ip) {
            return [
                'address' => $ip->address,
                'is_ipv4' => $ip->is_ipv4
            ];
        })->toArray();

        // Add pricing data
        $data['pricing'] = $server->price ? [
            'price' => $server->price->price,
            'currency' => $server->price->currency,
            'term' => $server->price->term,
            'term_name' => $this->getTermName($server->price->term),
            'as_usd' => $server->price->as_usd,
            'usd_per_month' => $server->price->usd_per_month,
            'next_due_date' => $server->price->next_due_date
        ] : null;

        // Add YABS data with disk_speed and network_speed
        $data['yabs'] = $server->yabs->map(function ($yabs) {
            return $this->transformYabsForExport($yabs);
        })->toArray();

        return $data;
    }

    /**
     * Transform YABS data for export including disk_speed and network_speed
     *
     * @param \App\Models\Yabs $yabs
     * @return array
     */
    protected function transformYabsForExport($yabs): array
    {
        $data = [
            'id' => $yabs->id,
            'output_date' => $yabs->output_date,
            'cpu_model' => $yabs->cpu_model,
            'cpu_cores' => $yabs->cpu_cores,
            'cpu_freq' => $yabs->cpu_freq,
            'aes' => $yabs->aes,
            'vm' => $yabs->vm,
            'gb5_single' => $yabs->gb5_single,
            'gb5_multi' => $yabs->gb5_multi,
            'gb6_single' => $yabs->gb6_single,
            'gb6_multi' => $yabs->gb6_multi,
            'ram' => $yabs->ram,
            'ram_type' => $yabs->ram_type,
            'disk' => $yabs->disk,
            'disk_type' => $yabs->disk_type,
        ];

        // Add disk speed data
        $data['disk_speed'] = $yabs->disk_speed ? [
            'd_4k' => $yabs->disk_speed->d_4k,
            'd_4k_type' => $yabs->disk_speed->d_4k_type,
            'd_64k' => $yabs->disk_speed->d_64k,
            'd_64k_type' => $yabs->disk_speed->d_64k_type,
            'd_512k' => $yabs->disk_speed->d_512k,
            'd_512k_type' => $yabs->disk_speed->d_512k_type,
            'd_1m' => $yabs->disk_speed->d_1m,
            'd_1m_type' => $yabs->disk_speed->d_1m_type,
        ] : null;

        // Add network speed data
        $data['network_speed'] = $yabs->network_speed->map(function ($ns) {
            return [
                'location' => $ns->location,
                'send' => $ns->send,
                'send_type' => $ns->send_type,
                'receive' => $ns->receive,
                'receive_type' => $ns->receive_type,
            ];
        })->toArray();

        return $data;
    }

    /**
     * Get human-readable term name from term ID
     *
     * @param int|null $term
     * @return string
     */
    protected function getTermName(?int $term): string
    {
        return match ($term) {
            1 => 'Monthly',
            2 => 'Quarterly',
            3 => 'Semi-Annually',
            4 => 'Yearly',
            5 => 'Biennially',
            6 => 'Triennially',
            default => 'Unknown'
        };
    }

    /**
     * Get CSV headers for server export
     *
     * @return array
     */
    protected function getServerCsvHeaders(): array
    {
        return [
            'id',
            'hostname',
            'server_type',
            'server_type_name',
            'cpu',
            'ram',
            'ram_type',
            'ram_as_mb',
            'disk',
            'disk_type',
            'disk_as_gb',
            'bandwidth',
            'ssh',
            'active',
            'owned_since',
            'os_id',
            'os_name',
            'location_id',
            'location_name',
            'provider_id',
            'provider_name',
            'ips',
            'pricing_price',
            'pricing_currency',
            'pricing_term',
            'pricing_term_name',
            'pricing_as_usd',
            'pricing_usd_per_month',
            'pricing_next_due_date',
            'yabs'
        ];
    }

    /**
     * Transform collection to JSON string with pretty-print formatting
     *
     * @param Collection|array $data
     * @return string
     */
    protected function toJson($data): string
    {
        if ($data instanceof Collection) {
            $data = $data->toArray();
        }

        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    /**
     * Transform collection to CSV string with header row and proper escaping
     *
     * @param Collection|array $data
     * @param array $headers Optional headers (auto-detected if not provided)
     * @return string
     */
    protected function toCsv($data, array $headers = []): string
    {
        if ($data instanceof Collection) {
            $data = $data->toArray();
        }

        if (empty($data)) {
            return empty($headers) ? '' : $this->escapeCsvRow($headers);
        }

        // Flatten all items and collect all possible headers
        $flattenedData = [];
        $allKeys = [];

        foreach ($data as $item) {
            $flattened = $this->flattenForCsv((array) $item);
            $flattenedData[] = $flattened;
            $allKeys = array_merge($allKeys, array_keys($flattened));
        }

        // Use provided headers or auto-detect from data
        if (empty($headers)) {
            $headers = array_unique($allKeys);
        }

        // Build CSV output
        $output = $this->escapeCsvRow($headers) . "\n";

        foreach ($flattenedData as $row) {
            $rowData = [];
            foreach ($headers as $header) {
                $rowData[] = $row[$header] ?? '';
            }
            $output .= $this->escapeCsvRow($rowData) . "\n";
        }

        return rtrim($output, "\n");
    }

    /**
     * Escape a single CSV row with proper handling of special characters
     *
     * @param array $row
     * @return string
     */
    protected function escapeCsvRow(array $row): string
    {
        $escapedFields = [];

        foreach ($row as $field) {
            $escapedFields[] = $this->escapeCsvField($field);
        }

        return implode(',', $escapedFields);
    }

    /**
     * Escape a single CSV field value
     *
     * @param mixed $value
     * @return string
     */
    protected function escapeCsvField($value): string
    {
        // Convert to string
        if (is_null($value)) {
            return '';
        }

        if (is_bool($value)) {
            return $value ? '1' : '0';
        }

        if (is_array($value)) {
            $value = json_encode($value);
        }

        $value = (string) $value;

        // Check if the field needs quoting
        $needsQuoting = false;

        // Quote if contains comma, double quote, newline, or carriage return
        if (strpos($value, ',') !== false ||
            strpos($value, '"') !== false ||
            strpos($value, "\n") !== false ||
            strpos($value, "\r") !== false) {
            $needsQuoting = true;
        }

        if ($needsQuoting) {
            // Escape double quotes by doubling them
            $value = str_replace('"', '""', $value);
            return '"' . $value . '"';
        }

        return $value;
    }

    /**
     * Flatten nested data for CSV export with appropriate prefixes
     *
     * @param array $item
     * @param string $prefix
     * @return array
     */
    protected function flattenForCsv(array $item, string $prefix = ''): array
    {
        $result = [];

        foreach ($item as $key => $value) {
            $newKey = $prefix === '' ? $key : $prefix . '_' . $key;

            if (is_array($value)) {
                // Check if it's an indexed array (list) or associative array
                if ($this->isIndexedArray($value)) {
                    // For indexed arrays, convert to JSON string or count
                    if ($this->isArrayOfScalars($value)) {
                        // Simple array of scalars - join with semicolon
                        $result[$newKey] = implode(';', $value);
                    } else {
                        // Complex array - store as JSON
                        $result[$newKey] = json_encode($value);
                    }
                } else {
                    // Associative array - recursively flatten
                    $flattened = $this->flattenForCsv($value, $newKey);
                    $result = array_merge($result, $flattened);
                }
            } elseif (is_object($value)) {
                // Convert object to array and flatten
                $flattened = $this->flattenForCsv((array) $value, $newKey);
                $result = array_merge($result, $flattened);
            } else {
                $result[$newKey] = $value;
            }
        }

        return $result;
    }

    /**
     * Check if an array is indexed (sequential numeric keys starting from 0)
     *
     * @param array $array
     * @return bool
     */
    protected function isIndexedArray(array $array): bool
    {
        if (empty($array)) {
            return true;
        }

        return array_keys($array) === range(0, count($array) - 1);
    }

    /**
     * Check if an array contains only scalar values
     *
     * @param array $array
     * @return bool
     */
    protected function isArrayOfScalars(array $array): bool
    {
        foreach ($array as $value) {
            if (!is_scalar($value) && !is_null($value)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Export all data combined
     * For JSON: returns combined data with metadata
     * For CSV: returns ZIP file with separate CSV files for each service type
     *
     * @param string $format 'json' or 'csv'
     * @return array{data: string, filename: string, content_type: string}
     */
    public function exportAll(string $format): array
    {
        $format = strtolower($format);
        $timestamp = date('Y-m-d_His');

        // Fetch all data for each service type
        $servers = Server::with([
            'location',
            'provider',
            'os',
            'price',
            'ips',
            'yabs',
            'yabs.disk_speed',
            'yabs.network_speed'
        ])->get();

        $domains = Domains::with(['provider', 'price'])->get();
        $shared = Shared::with(['location', 'provider', 'price', 'ips'])->get();
        $reseller = Reseller::with(['location', 'provider', 'price', 'ips'])->get();
        $seedboxes = SeedBoxes::with(['location', 'provider', 'price'])->get();
        $dns = DNS::all();
        $misc = Misc::with(['price'])->get();

        // Transform all data
        $serversData = $servers->map(fn($server) => $this->transformServerForExport($server))->toArray();
        $domainsData = $domains->map(fn($domain) => $this->transformDomainForExport($domain))->toArray();
        $sharedData = $shared->map(fn($s) => $this->transformSharedForExport($s))->toArray();
        $resellerData = $reseller->map(fn($r) => $this->transformResellerForExport($r))->toArray();
        $seedboxesData = $seedboxes->map(fn($sb) => $this->transformSeedboxForExport($sb))->toArray();
        $dnsData = $dns->map(fn($d) => $this->transformDnsForExport($d))->toArray();
        $miscData = $misc->map(fn($m) => $this->transformMiscForExport($m))->toArray();

        if ($format === 'json') {
            return $this->exportAllAsJson(
                $serversData,
                $domainsData,
                $sharedData,
                $resellerData,
                $seedboxesData,
                $dnsData,
                $miscData,
                $timestamp
            );
        }

        // CSV format - create ZIP with separate CSV files
        return $this->exportAllAsCsvZip(
            $serversData,
            $domainsData,
            $sharedData,
            $resellerData,
            $seedboxesData,
            $dnsData,
            $miscData,
            $timestamp
        );
    }

    /**
     * Export all data as JSON with metadata
     *
     * @param array $serversData
     * @param array $domainsData
     * @param array $sharedData
     * @param array $resellerData
     * @param array $seedboxesData
     * @param array $dnsData
     * @param array $miscData
     * @param string $timestamp
     * @return array{data: string, filename: string, content_type: string}
     */
    protected function exportAllAsJson(
        array $serversData,
        array $domainsData,
        array $sharedData,
        array $resellerData,
        array $seedboxesData,
        array $dnsData,
        array $miscData,
        string $timestamp
    ): array {
        $exportData = [
            'export_metadata' => [
                'export_date' => date('c'), // ISO 8601 format
                'version' => '4.1.0',
                'counts' => [
                    'servers' => count($serversData),
                    'domains' => count($domainsData),
                    'shared' => count($sharedData),
                    'reseller' => count($resellerData),
                    'seedboxes' => count($seedboxesData),
                    'dns' => count($dnsData),
                    'misc' => count($miscData),
                ],
            ],
            'servers' => $serversData,
            'domains' => $domainsData,
            'shared' => $sharedData,
            'reseller' => $resellerData,
            'seedboxes' => $seedboxesData,
            'dns' => $dnsData,
            'misc' => $miscData,
        ];

        return [
            'data' => $this->toJson($exportData),
            'filename' => "my_idlers_export_{$timestamp}.json",
            'content_type' => 'application/json'
        ];
    }

    /**
     * Export all data as a ZIP file containing separate CSV files
     *
     * @param array $serversData
     * @param array $domainsData
     * @param array $sharedData
     * @param array $resellerData
     * @param array $seedboxesData
     * @param array $dnsData
     * @param array $miscData
     * @param string $timestamp
     * @return array{data: string, filename: string, content_type: string}
     */
    protected function exportAllAsCsvZip(
        array $serversData,
        array $domainsData,
        array $sharedData,
        array $resellerData,
        array $seedboxesData,
        array $dnsData,
        array $miscData,
        string $timestamp
    ): array {
        // Create a temporary file for the ZIP
        $tempFile = tempnam(sys_get_temp_dir(), 'export_');
        $zip = new \ZipArchive();

        if ($zip->open($tempFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            throw new \RuntimeException('Failed to create export archive.');
        }

        // Add each service type as a separate CSV file
        $zip->addFromString(
            'servers.csv',
            $this->toCsv($serversData, $this->getServerCsvHeaders())
        );

        $zip->addFromString(
            'domains.csv',
            $this->toCsv($domainsData, $this->getDomainCsvHeaders())
        );

        $zip->addFromString(
            'shared_hosting.csv',
            $this->toCsv($sharedData, $this->getSharedCsvHeaders())
        );

        $zip->addFromString(
            'reseller_hosting.csv',
            $this->toCsv($resellerData, $this->getResellerCsvHeaders())
        );

        $zip->addFromString(
            'seedboxes.csv',
            $this->toCsv($seedboxesData, $this->getSeedboxCsvHeaders())
        );

        $zip->addFromString(
            'dns.csv',
            $this->toCsv($dnsData, $this->getDnsCsvHeaders())
        );

        $zip->addFromString(
            'misc_services.csv',
            $this->toCsv($miscData, $this->getMiscCsvHeaders())
        );

        // Add metadata file
        $metadata = [
            'export_date' => date('c'),
            'version' => '4.1.0',
            'counts' => [
                'servers' => count($serversData),
                'domains' => count($domainsData),
                'shared' => count($sharedData),
                'reseller' => count($resellerData),
                'seedboxes' => count($seedboxesData),
                'dns' => count($dnsData),
                'misc' => count($miscData),
            ],
        ];
        $zip->addFromString(
            'metadata.json',
            json_encode($metadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
        );

        $zip->close();

        // Read the ZIP file content
        $zipContent = file_get_contents($tempFile);

        // Clean up the temporary file
        unlink($tempFile);

        return [
            'data' => $zipContent,
            'filename' => "my_idlers_export_{$timestamp}.zip",
            'content_type' => 'application/zip'
        ];
    }
}
