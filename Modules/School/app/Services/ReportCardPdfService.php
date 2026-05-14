<?php

namespace Modules\School\Services;

class ReportCardPdfService
{
    public function make(string $title, array $lines): string
    {
        $content = $title . "\n" . implode("\n", $lines);
        $safe = preg_replace('/[^\x20-\x7E\n]/', '', $content) ?? '';
        $safe = str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $safe);

        $stream = "BT /F1 10 Tf 50 780 Td (" . str_replace("\n", ') Tj T* (', $safe) . ") Tj ET";

        $objects = [];
        $objects[] = '1 0 obj << /Type /Catalog /Pages 2 0 R >> endobj';
        $objects[] = '2 0 obj << /Type /Pages /Kids [3 0 R] /Count 1 >> endobj';
        $objects[] = '3 0 obj << /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Resources << /Font << /F1 4 0 R >> >> /Contents 5 0 R >> endobj';
        $objects[] = '4 0 obj << /Type /Font /Subtype /Type1 /BaseFont /Helvetica >> endobj';
        $objects[] = '5 0 obj << /Length ' . strlen($stream) . ' >> stream\n' . $stream . '\nendstream endobj';

        $pdf = "%PDF-1.4\n";
        $offsets = [];

        foreach ($objects as $object) {
            $offsets[] = strlen($pdf);
            $pdf .= $object . "\n";
        }

        $xrefOffset = strlen($pdf);
        $pdf .= 'xref\n0 ' . (count($objects) + 1) . "\n";
        $pdf .= "0000000000 65535 f \n";

        foreach ($offsets as $offset) {
            $pdf .= sprintf('%010d 00000 n ', $offset) . "\n";
        }

        $pdf .= 'trailer << /Size ' . (count($objects) + 1) . ' /Root 1 0 R >>\n';
        $pdf .= 'startxref\n' . $xrefOffset . "\n%%EOF";

        return $pdf;
    }
}
