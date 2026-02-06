# Requirements Document

## Introduction

This document specifies the requirements for implementing data export functionality in My Idlers, a self-hosted server/hosting management application. The feature enables users to export their service data (servers, domains, shared hosting, reseller hosting, seedboxes, DNS records, and miscellaneous services) in JSON and CSV formats. Export functionality will be available through both the web UI and API endpoints, supporting individual service type exports and global exports of all data.

## Glossary

- **Export_Service**: The service responsible for transforming model data into exportable formats (JSON/CSV)
- **Export_Controller**: The controller handling web-based export requests and file downloads
- **Export_API_Controller**: The controller handling API-based export requests
- **Service_Type**: One of the seven exportable service categories: servers, domains, shared, reseller, seedboxes, dns, misc
- **YABS_Data**: Yet Another Bench Script benchmark data including CPU, RAM, disk speed, and network speed metrics
- **Pricing_Data**: Cost information including price, currency, payment term, and next due date
- **Global_Export**: A combined export containing all service types in a single file
- **Export_Format**: The output format for exported data, either JSON or CSV

## Requirements

### Requirement 1: Server Data Export

**User Story:** As a user, I want to export my server data including YABS benchmarks and pricing, so that I can backup or analyze my server inventory.

#### Acceptance Criteria

1. WHEN a user requests a server export, THE Export_Service SHALL include all server fields (hostname, server_type, os, location, provider, ram, disk, cpu, bandwidth, owned_since, active status)
2. WHEN a server has associated YABS data, THE Export_Service SHALL include the YABS benchmark results (CPU scores, disk speeds, network speeds)
3. WHEN a server has pricing data, THE Export_Service SHALL include the pricing information (price, currency, term, next_due_date, as_usd, usd_per_month)
4. WHEN a server has associated IP addresses, THE Export_Service SHALL include all IP addresses in the export
5. WHEN JSON format is requested, THE Export_Service SHALL return valid JSON with nested objects for related data
6. WHEN CSV format is requested, THE Export_Service SHALL flatten nested data into columns with appropriate prefixes

### Requirement 2: Domain Data Export

**User Story:** As a user, I want to export my domain data with pricing information, so that I can track my domain portfolio.

#### Acceptance Criteria

1. WHEN a user requests a domain export, THE Export_Service SHALL include all domain fields (domain, extension, ns1, ns2, ns3, provider, owned_since)
2. WHEN a domain has pricing data, THE Export_Service SHALL include the pricing information
3. WHEN JSON format is requested, THE Export_Service SHALL return valid JSON
4. WHEN CSV format is requested, THE Export_Service SHALL return valid CSV with headers

### Requirement 3: Shared Hosting Data Export

**User Story:** As a user, I want to export my shared hosting data, so that I can maintain records of my hosting accounts.

#### Acceptance Criteria

1. WHEN a user requests a shared hosting export, THE Export_Service SHALL include all shared hosting fields (main_domain, provider, location, disk, bandwidth, limits, active status)
2. WHEN shared hosting has pricing data, THE Export_Service SHALL include the pricing information
3. WHEN shared hosting has associated IPs, THE Export_Service SHALL include the IP addresses

### Requirement 4: Reseller Hosting Data Export

**User Story:** As a user, I want to export my reseller hosting data, so that I can track my reseller accounts.

#### Acceptance Criteria

1. WHEN a user requests a reseller hosting export, THE Export_Service SHALL include all reseller hosting fields (main_domain, accounts, provider, location, disk, bandwidth, limits, active status)
2. WHEN reseller hosting has pricing data, THE Export_Service SHALL include the pricing information
3. WHEN reseller hosting has associated IPs, THE Export_Service SHALL include the IP addresses

### Requirement 5: Seedbox Data Export

**User Story:** As a user, I want to export my seedbox data, so that I can maintain records of my seedbox services.

#### Acceptance Criteria

1. WHEN a user requests a seedbox export, THE Export_Service SHALL include all seedbox fields (title, hostname, provider, location, disk, bandwidth, port_speed, active status)
2. WHEN a seedbox has pricing data, THE Export_Service SHALL include the pricing information

### Requirement 6: DNS Records Data Export

**User Story:** As a user, I want to export my DNS records, so that I can backup my DNS configuration.

#### Acceptance Criteria

1. WHEN a user requests a DNS export, THE Export_Service SHALL include all DNS record fields (hostname, dns_type, address)
2. THE Export_Service SHALL support all DNS record types (A, AAAA, DNAME, MX, NS, SOA, TXT, URI)

### Requirement 7: Miscellaneous Services Data Export

**User Story:** As a user, I want to export my miscellaneous services data, so that I can track all my services.

#### Acceptance Criteria

1. WHEN a user requests a misc services export, THE Export_Service SHALL include all misc service fields (name, owned_since)
2. WHEN a misc service has pricing data, THE Export_Service SHALL include the pricing information

### Requirement 8: Export Format Support

**User Story:** As a user, I want to choose between JSON and CSV export formats, so that I can use the data in different applications.

#### Acceptance Criteria

1. WHEN a user selects JSON format, THE Export_Service SHALL generate valid JSON output with proper encoding
2. WHEN a user selects CSV format, THE Export_Service SHALL generate valid CSV output with headers and proper escaping
3. WHEN exporting to JSON, THE Export_Service SHALL use pretty-print formatting for readability
4. WHEN exporting to CSV, THE Export_Service SHALL handle special characters and commas in data values
5. IF an invalid format is requested, THEN THE Export_Service SHALL return an error indicating valid formats

### Requirement 9: Web UI Export Buttons

**User Story:** As a user, I want export buttons on each service index page, so that I can easily download my data.

#### Acceptance Criteria

1. WHEN viewing the servers index page, THE System SHALL display export buttons for JSON and CSV formats
2. WHEN viewing the domains index page, THE System SHALL display export buttons for JSON and CSV formats
3. WHEN viewing the shared hosting index page, THE System SHALL display export buttons for JSON and CSV formats
4. WHEN viewing the reseller hosting index page, THE System SHALL display export buttons for JSON and CSV formats
5. WHEN viewing the seedboxes index page, THE System SHALL display export buttons for JSON and CSV formats
6. WHEN viewing the DNS index page, THE System SHALL display export buttons for JSON and CSV formats
7. WHEN viewing the misc services index page, THE System SHALL display export buttons for JSON and CSV formats
8. WHEN a user clicks an export button, THE System SHALL trigger a file download with appropriate filename and content-type

### Requirement 10: Global Export from Settings

**User Story:** As a user, I want to export all my data at once from the settings page, so that I can create a complete backup.

#### Acceptance Criteria

1. WHEN viewing the settings page, THE System SHALL display a global export section with JSON and CSV options
2. WHEN a user requests a global JSON export, THE Export_Service SHALL combine all service types into a single JSON file with categorized sections
3. WHEN a user requests a global CSV export, THE Export_Service SHALL generate a ZIP file containing separate CSV files for each service type
4. WHEN generating a global export, THE Export_Service SHALL include metadata (export_date, version, service_counts)

### Requirement 11: API Export Endpoints

**User Story:** As a developer, I want API endpoints for programmatic export access, so that I can integrate exports into automation workflows.

#### Acceptance Criteria

1. THE Export_API_Controller SHALL provide GET endpoints for each service type export (/api/export/servers, /api/export/domains, etc.)
2. THE Export_API_Controller SHALL provide a GET endpoint for global export (/api/export/all)
3. WHEN an API export request is made, THE System SHALL require valid Bearer token authentication
4. THE Export_API_Controller SHALL accept a format query parameter (json or csv)
5. WHEN format parameter is omitted, THE Export_API_Controller SHALL default to JSON format
6. WHEN an authenticated request is made, THE Export_API_Controller SHALL return the exported data with appropriate content-type headers

### Requirement 12: Version Update

**User Story:** As a maintainer, I want the version updated to 4.1.0, so that users know this release includes the export feature.

#### Acceptance Criteria

1. THE System SHALL update the version badge in README.md from 4.0.0 to 4.1.0
2. THE System SHALL add a changelog entry for version 4.1.0 documenting the export feature
