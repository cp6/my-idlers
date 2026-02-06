# Implementation Plan: Data Export Feature

## Overview

This implementation plan breaks down the data export feature into discrete coding tasks. The approach follows Laravel conventions and builds incrementally, starting with the core ExportService, then controllers, routes, views, and finally tests.

## Tasks

- [x] 1. Create ExportService with core export methods
  - [x] 1.1 Create ExportService class with JSON/CSV transformation methods
    - Create `app/Services/ExportService.php`
    - Implement `toJson()` method with pretty-print formatting
    - Implement `toCsv()` method with header row and proper escaping
    - Implement `flattenForCsv()` helper for nested data
    - Implement `isValidFormat()` validation method
    - _Requirements: 8.1, 8.2, 8.3, 8.4, 8.5_

  - [x] 1.2 Implement server export method
    - Implement `exportServers()` method
    - Include all server fields, OS, location, provider relationships
    - Include YABS data with disk_speed and network_speed
    - Include pricing data
    - Include IP addresses
    - _Requirements: 1.1, 1.2, 1.3, 1.4, 1.5, 1.6_

  - [x] 1.3 Implement domain export method
    - Implement `exportDomains()` method
    - Include all domain fields and provider relationship
    - Include pricing data
    - _Requirements: 2.1, 2.2, 2.3, 2.4_

  - [x] 1.4 Implement shared hosting export method
    - Implement `exportShared()` method
    - Include all shared hosting fields, location, provider relationships
    - Include pricing data and IP addresses
    - _Requirements: 3.1, 3.2, 3.3_

  - [x] 1.5 Implement reseller hosting export method
    - Implement `exportReseller()` method
    - Include all reseller hosting fields, location, provider relationships
    - Include pricing data and IP addresses
    - _Requirements: 4.1, 4.2, 4.3_

  - [x] 1.6 Implement seedbox export method
    - Implement `exportSeedboxes()` method
    - Include all seedbox fields, location, provider relationships
    - Include pricing data
    - _Requirements: 5.1, 5.2_

  - [x] 1.7 Implement DNS export method
    - Implement `exportDns()` method
    - Include all DNS record fields
    - Support all DNS types (A, AAAA, DNAME, MX, NS, SOA, TXT, URI)
    - _Requirements: 6.1, 6.2_

  - [x] 1.8 Implement misc services export method
    - Implement `exportMisc()` method
    - Include all misc service fields
    - Include pricing data
    - _Requirements: 7.1, 7.2_

  - [x] 1.9 Implement global export method
    - Implement `exportAll()` method
    - For JSON: combine all service types with metadata
    - For CSV: create ZIP with separate CSV files
    - Include export_date, version, service_counts in metadata
    - _Requirements: 10.2, 10.3, 10.4_

  - [ ]* 1.10 Write property tests for ExportService
    - **Property 5: JSON Output Validity**
    - **Property 6: CSV Output Validity**
    - **Validates: Requirements 8.1, 8.2, 8.3, 8.4**

- [x] 2. Checkpoint - Ensure ExportService tests pass
  - Ensure all tests pass, ask the user if questions arise.

- [x] 3. Create ExportController for web exports
  - [x] 3.1 Create ExportController with export action methods
    - Create `app/Http/Controllers/ExportController.php`
    - Inject ExportService via constructor
    - Implement `servers()`, `domains()`, `shared()`, `reseller()`, `seedboxes()`, `dns()`, `misc()` methods
    - Implement `all()` method for global export
    - Return StreamedResponse with appropriate headers
    - _Requirements: 9.8_

  - [x] 3.2 Add web routes for export endpoints
    - Add export routes to `routes/web.php`
    - Apply auth middleware
    - Define named routes (export.servers, export.domains, etc.)
    - _Requirements: 9.1, 9.2, 9.3, 9.4, 9.5, 9.6, 9.7_

  - [ ]* 3.3 Write property test for export response headers
    - **Property 8: Export Response Headers**
    - **Validates: Requirements 9.8**

- [x] 4. Add API export endpoints
  - [x] 4.1 Add export methods to ApiController
    - Add `exportServers()`, `exportDomains()`, `exportShared()`, `exportReseller()`, `exportSeedboxes()`, `exportDns()`, `exportMisc()`, `exportAll()` methods
    - Accept format query parameter (default to json)
    - Return appropriate content-type headers
    - _Requirements: 11.1, 11.2, 11.4, 11.5, 11.6_

  - [x] 4.2 Add API routes for export endpoints
    - Add export routes to `routes/api.php`
    - Apply auth:api middleware
    - _Requirements: 11.1, 11.2, 11.3_

  - [ ]* 4.3 Write property tests for API authentication
    - **Property 9: API Authentication Requirement**
    - **Property 12: Format Parameter Handling**
    - **Validates: Requirements 11.3, 11.4, 8.5**

- [x] 5. Checkpoint - Ensure controller and API tests pass
  - Ensure all tests pass, ask the user if questions arise.

- [x] 6. Add export buttons to index views
  - [x] 6.1 Create export button component
    - Create `resources/views/components/export-buttons.blade.php`
    - Include JSON and CSV download buttons with icons
    - Accept route name as parameter
    - Style consistent with existing UI (Bootstrap 5.3)
    - _Requirements: 9.1, 9.2, 9.3, 9.4, 9.5, 9.6, 9.7_

  - [x] 6.2 Add export buttons to servers index page
    - Update `resources/views/servers/index.blade.php`
    - Add export buttons in page-actions section
    - _Requirements: 9.1_

  - [x] 6.3 Add export buttons to domains index page
    - Update `resources/views/domains/index.blade.php`
    - Add export buttons in page-actions section
    - _Requirements: 9.2_

  - [x] 6.4 Add export buttons to shared hosting index page
    - Update `resources/views/shared/index.blade.php`
    - Add export buttons in page-actions section
    - _Requirements: 9.3_

  - [x] 6.5 Add export buttons to reseller hosting index page
    - Update `resources/views/reseller/index.blade.php`
    - Add export buttons in page-actions section
    - _Requirements: 9.4_

  - [x] 6.6 Add export buttons to seedboxes index page
    - Update `resources/views/seedboxes/index.blade.php`
    - Add export buttons in page-actions section
    - _Requirements: 9.5_

  - [x] 6.7 Add export buttons to DNS index page
    - Update `resources/views/dns/index.blade.php`
    - Add export buttons in page-actions section
    - _Requirements: 9.6_

  - [x] 6.8 Add export buttons to misc services index page
    - Update `resources/views/misc/index.blade.php`
    - Add export buttons in page-actions section
    - _Requirements: 9.7_

- [x] 7. Add global export section to settings page
  - [x] 7.1 Update settings view with export section
    - Update `resources/views/settings/index.blade.php`
    - Add "Data Export" card section
    - Include JSON and CSV global export buttons
    - Add description text explaining the feature
    - _Requirements: 10.1_

- [x] 8. Checkpoint - Verify UI changes
  - Ensure all tests pass, ask the user if questions arise.

- [ ] 9. Write comprehensive property tests
  - [ ]* 9.1 Write property test for service field completeness
    - **Property 1: Service Field Completeness**
    - **Validates: Requirements 1.1, 2.1, 3.1, 4.1, 5.1, 6.1, 7.1**

  - [ ]* 9.2 Write property test for pricing data inclusion
    - **Property 2: Pricing Data Inclusion**
    - **Validates: Requirements 1.3, 2.2, 3.2, 4.2, 5.2, 7.2**

  - [ ]* 9.3 Write property test for IP address inclusion
    - **Property 3: IP Address Inclusion**
    - **Validates: Requirements 1.4, 3.3, 4.3**

  - [ ]* 9.4 Write property test for YABS data inclusion
    - **Property 4: YABS Data Inclusion**
    - **Validates: Requirements 1.2**

  - [ ]* 9.5 Write property test for DNS type support
    - **Property 7: DNS Type Support**
    - **Validates: Requirements 6.2**

  - [ ]* 9.6 Write property test for global export JSON structure
    - **Property 10: Global Export JSON Structure**
    - **Validates: Requirements 10.2, 10.4**

  - [ ]* 9.7 Write property test for global export CSV ZIP structure
    - **Property 11: Global Export CSV ZIP Structure**
    - **Validates: Requirements 10.3**

- [x] 10. Update version and documentation
  - [x] 10.1 Update README.md version badge
    - Change version badge from 4.0.0 to 4.1.0
    - _Requirements: 12.1_

  - [x] 10.2 Add changelog entry for 4.1.0
    - Add "4.1.0 changes" section to README.md
    - Document export feature additions
    - List new API endpoints
    - _Requirements: 12.2_

- [x] 11. Final checkpoint - Run full test suite
  - Ensure all tests pass, ask the user if questions arise.

## Notes

- Tasks marked with `*` are optional and can be skipped for faster MVP
- Each task references specific requirements for traceability
- Checkpoints ensure incremental validation
- Property tests validate universal correctness properties
- Unit tests validate specific examples and edge cases
- The ExportService is the core component - ensure it's solid before building controllers
