<?php

namespace App\Http\Controllers;

use App\Services\ExportService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param ExportService $exportService
     */
    public function __construct(
        protected ExportService $exportService
    ) {}

    /**
     * Export servers data
     *
     * @param Request $request
     * @return StreamedResponse|\Illuminate\Http\JsonResponse
     */
    public function servers(Request $request)
    {
        $format = $request->query('format', 'json');

        if (!$this->exportService->isValidFormat($format)) {
            return response()->json([
                'error' => 'Invalid format. Supported formats: json, csv'
            ], 400);
        }

        $export = $this->exportService->exportServers($format);

        return $this->createStreamedResponse($export);
    }

    /**
     * Export domains data
     *
     * @param Request $request
     * @return StreamedResponse|\Illuminate\Http\JsonResponse
     */
    public function domains(Request $request)
    {
        $format = $request->query('format', 'json');

        if (!$this->exportService->isValidFormat($format)) {
            return response()->json([
                'error' => 'Invalid format. Supported formats: json, csv'
            ], 400);
        }

        $export = $this->exportService->exportDomains($format);

        return $this->createStreamedResponse($export);
    }

    /**
     * Export shared hosting data
     *
     * @param Request $request
     * @return StreamedResponse|\Illuminate\Http\JsonResponse
     */
    public function shared(Request $request)
    {
        $format = $request->query('format', 'json');

        if (!$this->exportService->isValidFormat($format)) {
            return response()->json([
                'error' => 'Invalid format. Supported formats: json, csv'
            ], 400);
        }

        $export = $this->exportService->exportShared($format);

        return $this->createStreamedResponse($export);
    }

    /**
     * Export reseller hosting data
     *
     * @param Request $request
     * @return StreamedResponse|\Illuminate\Http\JsonResponse
     */
    public function reseller(Request $request)
    {
        $format = $request->query('format', 'json');

        if (!$this->exportService->isValidFormat($format)) {
            return response()->json([
                'error' => 'Invalid format. Supported formats: json, csv'
            ], 400);
        }

        $export = $this->exportService->exportReseller($format);

        return $this->createStreamedResponse($export);
    }

    /**
     * Export seedboxes data
     *
     * @param Request $request
     * @return StreamedResponse|\Illuminate\Http\JsonResponse
     */
    public function seedboxes(Request $request)
    {
        $format = $request->query('format', 'json');

        if (!$this->exportService->isValidFormat($format)) {
            return response()->json([
                'error' => 'Invalid format. Supported formats: json, csv'
            ], 400);
        }

        $export = $this->exportService->exportSeedboxes($format);

        return $this->createStreamedResponse($export);
    }

    /**
     * Export DNS records
     *
     * @param Request $request
     * @return StreamedResponse|\Illuminate\Http\JsonResponse
     */
    public function dns(Request $request)
    {
        $format = $request->query('format', 'json');

        if (!$this->exportService->isValidFormat($format)) {
            return response()->json([
                'error' => 'Invalid format. Supported formats: json, csv'
            ], 400);
        }

        $export = $this->exportService->exportDns($format);

        return $this->createStreamedResponse($export);
    }

    /**
     * Export misc services data
     *
     * @param Request $request
     * @return StreamedResponse|\Illuminate\Http\JsonResponse
     */
    public function misc(Request $request)
    {
        $format = $request->query('format', 'json');

        if (!$this->exportService->isValidFormat($format)) {
            return response()->json([
                'error' => 'Invalid format. Supported formats: json, csv'
            ], 400);
        }

        $export = $this->exportService->exportMisc($format);

        return $this->createStreamedResponse($export);
    }

    /**
     * Export all data (global export)
     *
     * @param Request $request
     * @return StreamedResponse|\Illuminate\Http\JsonResponse
     */
    public function all(Request $request)
    {
        $format = $request->query('format', 'json');

        if (!$this->exportService->isValidFormat($format)) {
            return response()->json([
                'error' => 'Invalid format. Supported formats: json, csv'
            ], 400);
        }

        $export = $this->exportService->exportAll($format);

        return $this->createStreamedResponse($export);
    }

    /**
     * Create a StreamedResponse with appropriate headers for file download
     *
     * @param array{data: string, filename: string, content_type: string} $export
     * @return StreamedResponse
     */
    protected function createStreamedResponse(array $export): StreamedResponse
    {
        return new StreamedResponse(
            function () use ($export) {
                echo $export['data'];
            },
            200,
            [
                'Content-Type' => $export['content_type'],
                'Content-Disposition' => 'attachment; filename="' . $export['filename'] . '"',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ]
        );
    }
}
