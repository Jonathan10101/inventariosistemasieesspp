<?php

if (!function_exists('format_text')) {
    /**
     * Formatea el texto para que tenga solo la primera letra en mayúscula,
     * limite el número de palabras a $limit y agregue "..." si el texto es truncado.
     *
     * @param string $text
     * @param int $limit
     * @return string
     */
    function format_text(string $text, int $limit = 10): string
    {
        // Convierte todo el texto a minúsculas con soporte para caracteres multibyte
        $formattedText = mb_strtolower($text, 'UTF-8');

        // Capitaliza solo la primera letra con soporte multibyte
        $formattedText = mb_convert_case(mb_substr($formattedText, 0, 1, 'UTF-8'), MB_CASE_TITLE, 'UTF-8')
            . mb_substr($formattedText, 1, null, 'UTF-8');

        // Divide el texto en palabras
        $words = explode(' ', $formattedText);

        // Verifica si el texto necesita ser truncado
        $truncated = count($words) > $limit;

        // Toma las primeras $limit palabras
        $words = array_slice($words, 0, $limit);

        // Une las palabras y agrega "..." si fue truncado
        return implode(' ', $words) . ($truncated ? '...' : '');
    }

    function format_text_full(string $text, int $limit = 50): string
    {
        // Convierte todo el texto a minúsculas con soporte para caracteres multibyte
        $formattedText = mb_strtolower($text, 'UTF-8');

        // Capitaliza solo la primera letra con soporte multibyte
        $formattedText = mb_convert_case(mb_substr($formattedText, 0, 1, 'UTF-8'), MB_CASE_TITLE, 'UTF-8')
            . mb_substr($formattedText, 1, null, 'UTF-8');

        // Divide el texto en palabras
        $words = explode(' ', $formattedText);

        // Verifica si el texto necesita ser truncado
        $truncated = count($words) > $limit;

        // Toma las primeras $limit palabras
        $words = array_slice($words, 0, $limit);

        // Une las palabras y agrega "..." si fue truncado
        return implode(' ', $words) . ($truncated ? '...' : '');
    }
    
}
